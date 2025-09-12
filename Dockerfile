FROM php:8.3-fpm

WORKDIR /var/www/html

# Install PHP extensions + node + curl for FrankenPHP installer
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev zip unzip \
    libjpeg-dev libfreetype6-dev libssl-dev nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Install FrankenPHP
RUN curl -fsSL https://frankenphp.dunglas.dev/install.sh | bash

# Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy app
COPY . .

# Install dependencies & build assets
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build
RUN php artisan filament:assets

# Ensure all directories exist before setting permissions
RUN mkdir -p public/build public/vendor storage bootstrap/cache

# Set permissions
RUN chown -R www-data:www-data public/build public/vendor storage bootstrap/cache

# Expose port
EXPOSE 8080

# Serve Laravel via FrankenPHP (Railway recommended)
CMD ["frankenphp", "public/index.php"]
