# =========================
# Stage 1: Build frontend
# =========================
FROM node:22 AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY . .

RUN npm run build


# =========================
# Stage 2: Laravel + FrankenPHP
# =========================
FROM dunglas/frankenphp:php8.4

WORKDIR /app

COPY . .

# Copy Vite compiled assets
COPY --from=frontend /app/public/build /app/public/build

RUN install-php-extensions \
    pdo_mysql \
    intl \
    zip \
    bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist


# Laravel permissions
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache


# Create storage symlink
RUN php artisan storage:link || true


# Clear old cache first
RUN php artisan optimize:clear


EXPOSE 8080


CMD ["frankenphp", "php-server", "--listen", ":8080", "--root", "public"]