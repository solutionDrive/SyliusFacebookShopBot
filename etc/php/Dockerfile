FROM php:7.1.2-fpm

RUN apt-get update \
    && apt-get install -y \
    libpq-dev \
    zip \
    unzip

RUN pecl install xdebug

RUN docker-php-ext-enable xdebug
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pgsql pdo_pgsql zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

