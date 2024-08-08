FROM php:8.3-apache

# Enable Apache modules
# TODO: check if we use the rewrite apache module or not
RUN a2enmod rewrite

RUN apt-get update && \
    apt-get upgrade && \
    apt-get install zip unzip

# TODO: add tidy extension, remove unused extesions
RUN docker-php-ext-install pdo_mysql

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Change work directory to /var/www/html
WORKDIR /var/www/html

# Copy all backend into /var/www/html
COPY backend/* .