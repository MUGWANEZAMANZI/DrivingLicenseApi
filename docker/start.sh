#!/usr/bin/env bash
set -euo pipefail

# Honor Railway PORT or default 8080
export PORT="${PORT:-8080}"

# Render nginx config from template (Docker's envsubst is not in alpine by default, use envsubst from gettext)
envsubst '\n$PORT' < /etc/nginx/templates/default.conf.template > /etc/nginx/http.d/default.conf

# Laravel setup
mkdir -p storage/framework/cache storage/framework/views storage/framework/sessions bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true
php -r "file_exists('.env') || copy('.env.example', '.env');" || true
php artisan key:generate --force --no-ansi || true
php artisan storage:link --no-ansi || true
# Publish Filament assets (CSS/JS) for panels/widgets
php artisan filament:assets --no-ansi --force || true
# Also publish any vendor-tagged Filament assets to public/vendor
php artisan vendor:publish --tag=filament-assets --force --no-interaction --no-ansi || true
# Cache icons used by Filament/blade-icon-kit
php artisan icons:cache --no-ansi || true
php artisan config:cache --no-ansi || true
php artisan route:cache --no-ansi || true
# Skip view:cache to prevent component discovery issues with vendor views

# Run database migrations if a DB is configured
php artisan migrate --force --no-ansi || true

exec /usr/bin/supervisord -c /etc/supervisord.conf


