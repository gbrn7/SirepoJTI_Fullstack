echo "Running deploy script"

echo "[1/5] Pulling from GitHub"
git pull origin

echo "[2/5] Installing packages using composer"
composer install

echo "[3/5] Migrating database"
php artisan migrate

echo "[4/5] Storage link"
php artisan storage:link

echo "[5/5] Cache config, routes, dan views"
php artisan optimize

echo "The app has been built and deployed!"
