
# --- Laravel + Apache + PHP 8.3 + Node/Tailwind ---
FROM php:8.3-apache

# Install Nginx (optional, comment out if not needed)
# RUN apt-get update && apt-get install -y nginx && rm -rf /var/lib/apt/lists/*

# Copy nginx config (optional)
# COPY nginx.conf /etc/nginx/nginx.conf

# Install system dependenciesCOPY nginx.conf /etc/nginx/nginx.conf

RUN apt-get update \# Install supervisor

    && apt-get install -y unzip git curl ca-certificates \RUN apt-get update && apt-get install -y supervisor && rm -rf /var/lib/apt/lists/*

    && rm -rf /var/lib/apt/lists/*

# Copy supervisor config

# Install ComposerCOPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer# --- Laravel + Nginx + PHP-FPM + FilamentPHP ---

FROM php:8.3-fpm-bookworm as base

# Install Node.js (for Tailwind and asset build)

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \# Install system dependencies and PHP extensions

    && apt-get install -y nodejs \RUN apt-get update \

    && npm install -g npm@latest    && apt-get install -y \

        libicu-dev \

# Copy application files        zlib1g-dev \

COPY . /var/www/html/        libzip-dev \

WORKDIR /var/www/html        unzip \

        git \

# Install PHP dependencies        libmariadb-dev \

RUN composer install --optimize-autoloader --no-scripts --no-interaction        libpng-dev \

        libjpeg-dev \

# Install Node dependencies and build assets (Tailwind, etc.)        libfreetype6-dev \

RUN if [ -f package.json ]; then npm install --no-progress --no-audit && npm run build; fi        libonig-dev \

    && docker-php-ext-install \

# Set permissions        intl \

RUN chown -R www-data:www-data storage bootstrap/cache        zip \

        pdo_mysql \

# Expose port 80 for Apache        mbstring \

EXPOSE 80        bcmath \

        ctype \

# Start Apache in foreground        tokenizer \

CMD ["apache2-foreground"]        fileinfo \

        gd \

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /var/www/html
WORKDIR /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Install Node.js and build assets if package.json exists
RUN apt-get update \
        && apt-get install -y curl ca-certificates libonig-dev \
        && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
        && apt-get install -y nodejs \
        && if [ -f package.json ]; then npm install --no-progress --no-audit && npm run build; fi \
        && apt-get remove -y curl \
        && apt-get autoremove -y \
        && rm -rf /var/lib/apt/lists/*

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache



# Expose port 8080 for Railway
EXPOSE 8080

# Start supervisor (which runs php-fpm and nginx)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
