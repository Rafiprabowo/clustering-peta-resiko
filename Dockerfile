FROM php:8.2-fpm

# Install dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \             
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip  # ⬅️ Tambahkan zip di sini

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install
