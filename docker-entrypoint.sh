#!/bin/bash
set -e

# Create required Laravel directories
mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache

# Ensure log file exists
touch storage/logs/laravel.log

# Set permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate app key if missing
php artisan key:generate --force

# Run package discovery
php artisan package:discover --ansi

# Start Apache in foreground
apache2-foreground
