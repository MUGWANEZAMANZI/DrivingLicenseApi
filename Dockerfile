# --- Laravel + Nginx + PHP-FPM + FilamentPHP ---
FROM php:8.3-fpm-bookworm as base

# Install system dependencies and PHP extensions
RUN apt-get update \
    && apt-get install -y \
        nginx \
        libicu-dev \
        zlib1g-dev \
        libzip-dev \
        unzip \
        git \
        libmariadb-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
    && docker-php-ext-install \
        intl \
        zip \
        pdo_mysql \
        mbstring \
        bcmath \
        ctype \
        tokenizer \
        fileinfo \
        gd \
    && rm -rf /var/lib/apt/lists/*

# FrankenPHP extension (for Filament Livewire SSE/Websockets if needed)
RUN curl -fsSL https://github.com/dunglas/frankenphp/releases/latest/download/frankenphp.so \
    -o /usr/local/lib/php/extensions/no-debug-non-zts-20230831/frankenphp.so \
    && echo "extension=frankenphp.so" > /usr/local/etc/php/conf.d/frankenphp.ini

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /var/www/html
WORKDIR /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Install Node.js and build assets if package.json exists
RUN apt-get update \
    && apt-get install -y curl ca-certificates \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && if [ -f package.json ]; then npm install --no-progress --no-audit && npm run build; fi \
    && apt-get remove -y curl \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy nginx config
COPY nginx.conf /etc/nginx/nginx.conf

# Install supervisor
RUN apt-get update && apt-get install -y supervisor && rm -rf /var/lib/apt/lists/*

# Copy supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 8080 for Railway
EXPOSE 8080

# Start supervisor (which runs php-fpm and nginx)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
