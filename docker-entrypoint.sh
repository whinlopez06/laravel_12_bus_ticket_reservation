#!/bin/sh

# Wait until MySQL is ready
echo "Waiting for MySQL..."

until nc -z -v -w30 "$DB_HOST" "$DB_PORT"
do
  echo "Waiting for database connection..."
  sleep 5
done

echo "Database is up!"

echo "DB_HOST=$DB_HOST"
echo "DB_PORT=$DB_PORT"
echo "DB_DATABASE=$DB_DATABASE"
echo "DB_USERNAME=$DB_USERNAME"
echo "DB_CONNECTION=$DB_CONNECTION"

# Run migrations
php artisan migrate --force || true

# Finally start Laravel
php artisan serve --host=0.0.0.0 --port=8080
