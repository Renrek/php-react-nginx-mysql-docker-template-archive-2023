FROM node:latest AS node

FROM php:fpm

COPY --from=node / /

# Install packages
RUN apt-get update
RUN apt-get install -y git zip unzip

# Prepare PHP
RUN docker-php-ext-install pdo pdo_mysql 
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Composer Offical Docker setup
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# Add path to composer bin, still need to manually run composer install
ENV PATH="${PATH}:/srv/app/libraries/vendors/bin"

# Set the entry point when connecting by cli command "docker exec -it php bash"
WORKDIR /srv