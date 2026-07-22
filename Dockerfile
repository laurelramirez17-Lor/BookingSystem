FROM dunglas/frankenphp:php8.4

WORKDIR /app

COPY . .

RUN install-php-extensions \
    pdo_mysql \
    intl \
    zip \
    bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["frankenphp", "php-server", "--listen", ":8080", "--root", "public"]