#!/bin/bash

# Install composer dependencies
composer install --ignore-platform-reqs

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Start PHP-FPM (or any other process that keeps the container running)
php-fpm
