# Use outdated PHP 7.4 with Apache
FROM php:7.4-apache

WORKDIR /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY app/ /var/www/html/Minifourchan/

# Copy the upload directory into the container
COPY upload/ /var/www/html/Minifourchan/upload/

# Set permissions for the upload directory
RUN chown -R www-data:www-data /var/www/html/Minifourchan/upload && \
    chmod -R 755 /var/www/html/Minifourchan/upload

RUN a2enmod rewrite

# Expose port 80
EXPOSE 80
