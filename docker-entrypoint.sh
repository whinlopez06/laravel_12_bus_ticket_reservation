#!/bin/sh
set -e

# Hardcoded DB credentials from your Railway MySQL
DB_HOST="shinkansen.proxy.rlwy.net"
DB_PORT="38442"
DB_DATABASE="railway"
DB_USERNAME="root"
DB_PASSWORD="fpijFkPZviwUJedUuiSvJolxciIdofUj"
DB_CONNECTION="mysql"

echo "DB_HOST=$DB_HOST"
echo "DB_PORT=$DB_PORT"
echo "DB_DATABASE=$DB_DATABASE"

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
