#!/bin/bash
set -e
apt-get update -y
apt-get install -y postgresql postgresql-contrib php8.3-pgsql

sudo -u postgres psql -c "CREATE DATABASE bioguard_db;" || true
sudo -u postgres psql -c "CREATE USER bioguard_user WITH ENCRYPTED PASSWORD 'BioguardSecure123!';" || true
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE bioguard_db TO bioguard_user;"
sudo -u postgres psql -d bioguard_db -c "GRANT ALL ON SCHEMA public TO bioguard_user;"

cd /var/www/bioguard
sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=pgsql/' .env
sed -i 's/DB_PORT=3306/DB_PORT=5432/' .env

php artisan optimize:clear
php artisan migrate:fresh --seed --force

systemctl stop mysql
systemctl disable mysql

echo 'PostgreSQL Migration Complete'
