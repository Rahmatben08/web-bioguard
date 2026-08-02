#!/bin/bash
set -e
export DEBIAN_FRONTEND=noninteractive

apt-get update -y
apt-get upgrade -y
apt-get install -y software-properties-common curl git unzip zip certbot python3-certbot-nginx mysql-server nginx

add-apt-repository ppa:ondrej/php -y
apt-get update -y
apt-get install -y php8.3-fpm php8.3-cli php8.3-common php8.3-mysql php8.3-zip php8.3-gd php8.3-mbstring php8.3-curl php8.3-xml php8.3-bcmath

curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

mysql -e "CREATE DATABASE IF NOT EXISTS bioguard_db;"
mysql -e "CREATE USER IF NOT EXISTS 'bioguard_user'@'localhost' IDENTIFIED BY 'BioguardSecure123!';"
mysql -e "GRANT ALL PRIVILEGES ON bioguard_db.* TO 'bioguard_user'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

echo 'Stack Installation Complete'
