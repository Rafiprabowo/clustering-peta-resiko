FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    locales zip jpegoptim pngquant gifsicle vim unzip git curl \
    libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000
