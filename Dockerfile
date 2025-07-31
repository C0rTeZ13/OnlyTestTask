FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev \
    libxml2-dev libpq-dev zip unzip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN mkdir -p storage/framework/{cache,sessions,testing,views} \
    storage/logs bootstrap/cache && \
    chown -R www-data:www-data /var/www/storage && \
    chmod -R 775 /var/www/storage && \
    chmod -R 775 bootstrap/cache

RUN composer install --optimize-autoloader

RUN composer remove laravel/pail --no-update || true
