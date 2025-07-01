FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev curl git \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd pdo pdo_mysql mbstring zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --prefer-dist \
    && chown -R www-data:www-data /var/www
