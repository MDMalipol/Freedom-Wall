#!/usr/bin/env bash
set -e

# -----------------------------------------------------------------------------
# Configure Apache to listen on the port provided by the platform (Render sets
# the PORT env var, defaulting to 10000). Both the global listener and the
# vhost are updated.
# -----------------------------------------------------------------------------
: "${PORT:=10000}"
export PORT

sed -i "s/^Listen 80\$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/\${PORT}/${PORT}/g" /etc/apache2/sites-available/000-default.conf

# -----------------------------------------------------------------------------
# Laravel runtime preparation
# -----------------------------------------------------------------------------

# Generate an app key only if one was not supplied via the environment.
# APP_KEY should be set as an environment variable in production; this is just
# a safety net so the container does not crash if it is missing.
if [ -z "${APP_KEY}" ]; then
    echo "APP_KEY is not set - generating a temporary one (set APP_KEY in your env for stable sessions/encryption)."
    [ -f .env ] || cp .env.example .env 2>/dev/null || touch .env
    php artisan key:generate --force || true
fi

# Link the public storage directory (ignored if it already exists).
php artisan storage:link || true

# Cache configuration and views for production performance.
# NOTE: route:cache is intentionally tolerant because this app defines some
# closure-based routes, which cannot be serialized/cached by Laravel.
php artisan config:cache
php artisan view:cache
php artisan route:cache || echo "Skipping route cache (closure-based routes present)."

# Run database migrations. Set RUN_MIGRATIONS=false to skip.
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || echo "Migrations failed or were skipped."
fi

# -----------------------------------------------------------------------------
# Hand off to Apache in the foreground.
# -----------------------------------------------------------------------------
exec apache2-foreground
