#!/bin/sh
set -e

# Wait for Postgres to be ready
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  echo "Waiting for database..."
  sleep 2
done

echo "Clearing and Caching Configuration..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- 🛠️ Database Connection Details ---"
echo "Database Host: $DB_HOST"
echo "Database Name: $DB_DATABASE"
echo "Database User: $DB_USERNAME"
echo "Database Pass: $DB_PASSWORD"
echo "-------------------------------------"

echo "Running Laravel migrations..."
php artisan migrate --force || {
    echo "Migration failed!"
    exit 1
}

echo "Starting Laravel application..."
exec "$@"
