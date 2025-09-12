# Use FrankenPHP base image (includes PHP + web server)
FROM dunglas/frankenphp

# Install dependencies + PHP extensions + Node
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev \
    libpq-dev libjpeg-dev libfreetype6-dev libssl-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

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

# Run Laravel using FrankenPHP
CMD ["frankenphp", "run", "--port", "${PORT:-8080}", "public/index.php"]

