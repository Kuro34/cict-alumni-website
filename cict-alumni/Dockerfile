# Use official PHP image with necessary extensions
FROM php:8.2-cli

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    zip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer (from official Composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all project files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Generate storage symlink and optimize Laravel
RUN php artisan storage:link || true
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

# Expose port for Render (Render automatically assigns PORT)
EXPOSE 10000

# Automatically run migrations during startup, then serve app
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
