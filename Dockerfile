FROM php:8.0-fpm-alpine

RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install pgsql pdo_pgsql \
    && docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY . /var/www

RUN composer install

CMD ["php-fpm"]