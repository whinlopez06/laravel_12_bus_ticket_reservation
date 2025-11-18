#!/bin/sh
set -e

echo "⏳ Waiting for PostgreSQL to be ready..."

# Wait up to 60 seconds for DB
timeout=60
while ! pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME" >/dev/null 2>&1; do
  timeout=$((timeout - 1))
  if [ $timeout -le 0 ]; then
    echo "❌ Database is not responding. Exiting."
    exit 1
  fi
  echo "Waiting for database... ($timeout)"
  sleep 1
done

echo "✅ Database is ready!"

echo "Clearing config cache..."
php artisan config:clear

echo "Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- 🛠️ Database Connection Details ---"
echo "Host: $DB_HOST"
echo "Database: $DB_DATABASE"
echo "User: $DB_USERNAME"
echo "--------------------------------------"

echo "🚀 Running migrations..."
php artisan migrate --force || {
    echo "❌ Migration failed!"
    exit 1
}

echo "🎉 Starting Laravel..."
exec "$@"
