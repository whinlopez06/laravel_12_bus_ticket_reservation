#!/bin/sh
set -e

# Wait for Postgres to be ready
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  echo "Waiting for database..."
  sleep 2
done

echo "Running Laravel migrations..."
php artisan migrate --force || {
    echo "Migration failed!"
    exit 1
}

echo "Starting Laravel application..."
exec "$@"
