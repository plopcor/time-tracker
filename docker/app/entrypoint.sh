#!/bin/bash

# On WORKDIR

echo "------------ [ENTRYPOINT - START] --------------"

# Composer - Install
if [ ! -d vendor/ ]; then
    composer install \
        # --no-autoloader \
        --no-interaction \
        --no-scripts
fi

# Laravel - Generate key if not set
if grep -E 'APP_KEY=$' .env; then       # If APP_KEY not set
    echo "[Entrypoint] Generate Laravel key"
    php artisan key:generate
fi

# Laravel - Migrate (force to create DB automatically)
php artisan migrate --force

echo "------------ [ENTRYPOINT - END] --------------"

# Continue with the CMD set in original image
php-fpm
