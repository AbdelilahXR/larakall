@echo off

echo === Step 1: Running composer install ===
echo === Step 2: Installing npm packages and building ===
echo === Step 3: Copying .env.example to .env ===
echo === Step 4: Generating application key ===

composer install && npm install && npm run build && copy .env.example .env && php artisan setupApp && pause
