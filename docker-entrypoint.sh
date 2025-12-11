#!/bin/sh
set -e

# Print env vars (debug)
echo "DB_HOST=$DB_HOST"
echo "DB_PORT=$DB_PORT"
echo "DB_DATABASE=$DB_DATABASE"

# Wait for database (use Railway env vars)
until nc -z -v -w30 "$DB_HOST" "$DB_PORT"
do
  echo "Waiting for database..."
  sleep 3
done

# Clear caches (important on Railway)
php artisan config:clear

# Run migrations
php artisan migrate --force || true

# Cache config after migration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start app
php artisan serve --host=0.0.0.0 --port=8080
