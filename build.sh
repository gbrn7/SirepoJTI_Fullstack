echo "Run deploy script"

echo "Pulling from Github"
git pull origin

echo "Installing packages using composer"
composer install

echo "The app has been build!"