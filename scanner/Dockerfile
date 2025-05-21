# Gunakan PHP 8.2 + FPM
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    nodejs \
    npm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working dir
WORKDIR /var/www

# Salin semua file ke container
COPY . .

# Install dependency backend
RUN composer install --no-dev --optimize-autoloader

# Install dependency frontend dan build
RUN npm install && npm run build

# Set permission
RUN chmod -R 775 storage bootstrap/cache

# Laravel akan jalan di port 8000
EXPOSE 8000

# Jalankan Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
