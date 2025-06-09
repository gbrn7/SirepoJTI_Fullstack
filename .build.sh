#!/bin/bash

echo "Running deploy script"

echo "[1/] Pulling from GitHub"
git pull origin

echo "[2/] Creating database if one isn't found"
touch database/database.sqlite

echo "[3/] Installing packages using composer"
composer install

echo "[4/] Migrating database"
php artisan migrate --force

echo "[5/] Cache config, routes, dan views"
php artisan optimize

echo "The app has been built and deployed!"
