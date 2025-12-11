#!/bin/sh
set -e

echo "DB_HOST=$DB_HOST"
echo "DB_PORT=$DB_PORT"
echo "DB_DATABASE=$DB_DATABASE"

if [ -z "$DB_HOST" ] || [ -z "$DB_PORT" ]; then
  echo "ERROR: DB variables are missing"
  exit 1
fi

until nc -z -v -w30 "$DB_HOST" "$DB_PORT"
do
  echo "Waiting for database..."
  sleep 3
done

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan serve --host=0.0.0.0 --port=8080
