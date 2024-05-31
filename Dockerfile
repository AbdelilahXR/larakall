# Use the official PHP image
FROM php:8.2 as php

# Install system dependencies
RUN apt-get update -y \
    && apt-get install -y unzip libpq-dev libcurl4-gnutls-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql bcmath \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install Composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

# Install node and npm dependencies
FROM node:20-alpine as node
WORKDIR /var/www
COPY . .
RUN npm install

# Define environment variables
ENV PORT=8000

# Set entrypoint commands
CMD ["sh", "-c", "\
    if [ ! -f 'vendor/autoload.php' ]; then \
        echo '=== Step 1: Running composer install ==='; \
        composer install --no-progress --no-interaction; \
    fi; \
    if [ ! -f '.env' ]; then \
        echo 'Creating env file for env $APP_ENV'; \
        cp .env.example .env; \
    else \
        echo 'env file exists.'; \
    fi; \
    echo '=== Step 2: Installing npm packages and building ==='; \
    npm install && npm run build; \
    echo '=== Step 4: Generating application key ==='; \
    php artisan key:generate; \
    role=${CONTAINER_ROLE:-app}; \
    if [ \"$role\" = \"app\" ]; then \
        php artisan migrate; \
        php artisan cache:clear; \
        php artisan config:clear; \
        php artisan route:clear; \
        php artisan serve --port=$PORT --host=0.0.0.0 --env=.env; \
    elif [ \"$role\" = \"queue\" ]; then \
        echo 'Running the queue ... '; \
        php /var/www/artisan queue:work --verbose --tries=3 --timeout=180; \
    elif [ \"$role\" = \"websocket\" ]; then \
        echo 'Running the websocket server ... '; \
        php artisan websockets:serve; \
    fi"]


# FROM php:8.2 as php

# RUN apt-get update -y
# RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
# RUN docker-php-ext-install pdo pdo_mysql bcmath

# RUN pecl install -o -f redis \
#     && rm -rf /tmp/pear \
#     && docker-php-ext-enable redis \
#     && docker-compose up -d

# WORKDIR /var/www
# COPY . .

# COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer


# ENV PORT=8000
# ENTRYPOINT [ "docker/entrypoint.sh" ]

# # ==============================================================================
# #  node
# FROM node:20-alpine as node

# WORKDIR /var/www
# COPY . .

# # Set npm registry and retry mechanism
# # RUN npm config set registry https://registry.npmjs.org/ && \
# #     npm config set fetch-retries 5 && \
# #     npm config set fetch-retry-mintimeout 20000 && \
# #     npm config set fetch-retry-maxtimeout 120000

# # Install cross-env with retry mechanism
# #RUN npm install --global cross-env || npm install --global cross-env
# RUN npm install

# VOLUME /var/www/node_modules 
