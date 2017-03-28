#!/bin/bash

# Installing Apache
sudo apt-get -y --force-yes install apache2 apache2-mpm-worker

# Get the current document root
DOC_ROOT=$(grep -i 'DocumentRoot' /etc/apache2/sites-enabled/000-default.conf)

# If the current root directory is not the sale cents directory then change it
if [ "$DOC_ROOT" = "	DocumentRoot /var/www/html" ]; then

	# Enable the .htaccess file to be used
	sudo a2enmod rewrite
	sudo sed -i '166s/AllowOverride\ None/AllowOverride\ All/g' /etc/apache2/apache2.conf

	# Setup root directory for apache to be /var/www/website
	sudo sed -i 's/\/var\/www\/html/\/var\/www\/skeleton/g' /etc/apache2/sites-enabled/000-default.conf

fi

# Installing PHP and it's dependencies
sudo apt-get -y --force-yes install php5 libapache2-mod-php5 php5-mcrypt
sudo apt-get -y --force-yes install curl libcurl3 libcurl3-dev php5-curl 
sudo apt-get -y --force-yes install imagemagick php5-imagick
sudo php5enmod mcrypt
sudo php5enmod imagick

# Set php's max file size
sudo sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 10M/g' /etc/php5/apache2/php.ini

# Restart apache server after updating its root directory
sudo service apache2 restart