FROM php:8.1

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
COPY ./docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /app
COPY . /app
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000
