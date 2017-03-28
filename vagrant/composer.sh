#!/bin/bash
# Install composer
sudo apt-get -y --force-yes install curl php5-cli

curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

cd /var/www/assets_api/protected

sudo composer update

cd ~