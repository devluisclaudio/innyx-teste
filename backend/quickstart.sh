#!/bin/bash

/bin/chmod 777 -R /var/www/html/artisan
/bin/chmod guo+wr -R /var/www/html/storage

php -f /var/www/html/artisan migrate

php -f /var/www/html/artisan route:cache
php -f /var/www/html/artisan cache:clear
php -f /var/www/html/artisan view:clear
php -f /var/www/html/artisan config:cache
php -f /var/www/html/artisan optimize
php -f /var/www/html/artisan storage:link

chmod 777 -R /var/www/html

php-fpm
