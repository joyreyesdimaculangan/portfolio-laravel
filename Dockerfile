FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first
COPY composer.json composer.lock ./

# Run composer install early to cache dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy rest of the application
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
