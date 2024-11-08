FROM php:8.2.5-apache

RUN a2enmod rewrite

# Install PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN install-php-extensions apcu gd opcache redis zip intl pdo_mysql xsl

COPY php/conf.d/docker-php.ini /usr/local/etc/php/conf.d/
COPY ./apache/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY php /var/www

WORKDIR /var/www

EXPOSE 9000
