#!/usr/bin/env sh
set -e

if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
fi

if [ ! -d vendor ]; then
    composer install
fi

if [ -f package-lock.json ] && [ ! -d node_modules ]; then
    npm install --ignore-scripts
fi

if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    php artisan key:generate --ansi
fi

exec "$@"
