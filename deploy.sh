#!/bin/bash
set -e

# Clone repository
if [ ! -d "/var/www/bioguard" ]; then
    git clone git@github.com:Rahmatben08/web-bioguard.git /var/www/bioguard
else
    cd /var/www/bioguard
    git fetch --all
    git reset --hard origin/main
fi

cd /var/www/bioguard

# Environment setup
cp .env.example .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=bioguard_db/' .env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=bioguard_user/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=BioguardSecure123!/' .env
sed -i 's/APP_URL=.*/APP_URL=http:\/\/76.13.197.167/' .env

# Permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader
npm install
npm run build

# Laravel setup
php artisan key:generate
php artisan migrate --force
php artisan storage:link || true
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo 'Deployment Complete'
