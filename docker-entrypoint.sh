#!/bin/sh
set -e

echo "DB_HOST = $DB_HOST"
echo "DB_PORT = $DB_PORT"
echo "DB_DATABASE = $DB_DATABASE"
echo "DB_USERNAME = $DB_USERNAME"
echo "DB_PASSWORD = $DB_PASSWORD"
echo "DB_CONNECTION = $DB_CONNECTION"

if [ -z "$DB_HOST" ] || [ -z "$DB_PORT" ]; then
  echo "ERROR: DB_HOST or DB_PORT is not set!"
  exit 1
fi

echo "Waiting for MySQL..."

until nc -z -v -w30 "$DB_HOST" "$DB_PORT"
do
  echo "Waiting for database connection..."
  sleep 5
done

echo "Database is up!"

php artisan migrate --force

php artisan serve --host=0.0.0.0 --port=8080
