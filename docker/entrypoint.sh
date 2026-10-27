#!/bin/sh
set -e

if [ -z "$APP_KEY" ]; then
  echo "FATAL: APP_KEY is not set. Generate one with 'php artisan key:generate --show' and put it in .env.production before starting this container." >&2
  exit 1
fi

mkdir -p /app/storage/database
mkdir -p /app/storage/app/book-loans
touch /app/storage/database/database.sqlite

mkdir -p /app/storage/framework/sessions /app/storage/framework/views \
         /app/storage/framework/cache/data /app/storage/logs

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
