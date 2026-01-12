# ================================
# Dockerfile for Laravel + Apache
# ================================

# 1️⃣ Base image with PHP + Apache
FROM php:8.2-apache

# 2️⃣ Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql \
    && a2enmod rewrite

# 3️⃣ Set working directory inside container
WORKDIR /var/www/html

# 4️⃣ Copy entire Laravel project
COPY . .

# 5️⃣ Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# 6️⃣ Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 7️⃣ Ensure storage directories exist and are writable
# Ensure storage and cache directories exist and are writable
RUN mkdir -p \
        storage/framework/{cache,sessions,views} \
        storage/logs \
        bootstrap/cache \
    && touch storage/logs/laravel.log \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

    # After composer install and storage setup
RUN php artisan migrate --force || true

# 8️⃣ Run Laravel post-install commands
RUN php artisan key:generate \
    && php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan storage:link || true \
    && php artisan package:discover --ansi

# 9️⃣ Set Apache DocumentRoot to Laravel's public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 🔟 Expose Apache port
EXPOSE 80

# 1️⃣1️⃣ Start Apache in the foreground
CMD ["apache2-foreground"]
