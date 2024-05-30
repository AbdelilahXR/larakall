FROM php:8.2 as php

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_mysql bcmath

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

WORKDIR /var/www
COPY . .

COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

ENV PORT=8000
ENTRYPOINT [ "docker/entrypoint.sh" ]

# ==============================================================================
#  node
FROM node:20-alpine as node

WORKDIR /var/www
COPY . .

# Set npm registry and retry mechanism
# RUN npm config set registry https://registry.npmjs.org/ && \
#     npm config set fetch-retries 5 && \
#     npm config set fetch-retry-mintimeout 20000 && \
#     npm config set fetch-retry-maxtimeout 120000

# Install cross-env with retry mechanism
#RUN npm install --global cross-env || npm install --global cross-env
RUN npm install

VOLUME /var/www/node_modules 
