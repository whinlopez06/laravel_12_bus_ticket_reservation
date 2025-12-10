# Use official PHP 8.2 FPM image
FROM php:8.2-fpm

# Install system dependencies including libpq-dev for PostgreSQL
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip exif pcntl bcmath gd

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

# Optional: install PostgreSQL client for artisan tinker, migrations, pg_dump, etc.
RUN apt-get update && apt-get install -y postgresql-client

# Expose port for Render
EXPOSE 8000

# Copy entrypoint script
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set entrypoint
ENTRYPOINT ["entrypoint.sh"]

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
