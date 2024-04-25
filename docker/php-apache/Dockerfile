FROM php:8.3-apache

RUN apt update && apt install -y curl libzip-dev

#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_mysql zip

RUN a2enmod headers rewrite


#WORKDIR /var/www/html
#
##ENV COMPOSER_ALLOW_SUPERUSER=1
#
##RUN composer install