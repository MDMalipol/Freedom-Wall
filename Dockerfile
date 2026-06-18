# syntax=docker/dockerfile:1

# =============================================================================
# Stage 1 - Build front-end assets with Vite/Tailwind
# =============================================================================
FROM node:20-alpine AS assets

WORKDIR /app

# Install node dependencies first (better layer caching)
COPY package.json package-lock.json ./
RUN npm ci

# Copy the files needed to build assets
COPY vite.config.js postcss.config.js tailwind.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# =============================================================================
# Stage 2 - PHP / Apache application image
# =============================================================================
FROM php:8.2-apache AS app

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libpq-dev \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        bcmath \
        gd \
        zip \
        exif \
        pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite module (required by Laravel)
RUN a2enmod rewrite

# Use the production PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install Composer from the official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies first (better layer caching)
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --no-scripts \
        --optimize-autoloader

# Copy the rest of the application
COPY . .

# Copy compiled front-end assets from the build stage
COPY --from=assets /app/public/build ./public/build

# Finish composer setup (now that all files are present)
RUN composer dump-autoload --optimize --no-dev \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Apache vhost + entrypoint
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Render provides the port via the PORT env var (defaults to 10000)
ENV PORT=10000
EXPOSE 10000

ENTRYPOINT ["entrypoint.sh"]
