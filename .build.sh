#!/bin/bash

echo "Running deploy script"

echo "[1/5] Pulling from GitHub"
git pull origin

echo "[2/4] Installing packages using composer"
composer install

echo "[3/4] Migrating database"
php artisan migrate --force

echo "[4/4] Cache config, routes, dan views"
php artisan optimize

echo "The app has been built and deployed!"
