# Use official PHP 8.2 image with required extensions
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Cache Laravel config/routes/views
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

RUN apt-get update && apt-get install -y postgresql-client

# Expose port (Render uses this to detect container port)
EXPOSE 8000

# Copy the entrypoint script
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh   # ← IMPORTANT so it can run!

# Set the entrypoint
ENTRYPOINT ["entrypoint.sh"]

# Start Laravel server AFTER migrations run
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
