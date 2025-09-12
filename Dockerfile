FROM php:8.3-fpm

# Install dependencies + PHP extensions + Node
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev \
    libpq-dev libjpeg-dev libfreetype6-dev libssl-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install FrankenPHP
RUN curl -fsSL https://frankenphp.org/install.sh | bash

# Set working directory
WORKDIR /var/www/html

# Copy app
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build assets
RUN npm install && npm run build
RUN php artisan filament:assets

# Ensure directories exist
RUN mkdir -p storage bootstrap/cache public/build public/vendor

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache public/build public/vendor

# Expose Railway port
EXPOSE 8080

# Serve app via FrankenPHP
CMD ["frankenphp", "public/index.php"]
