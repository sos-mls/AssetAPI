#!/bin/bash

# install cron
sudo apt-get -y --force-yes install cron

# add test console command to the cron tab

crontab -l | { cat; echo "* * * * * sudo php /var/www/assetapi/protected/cron.php garbagecollection"; } | crontab -