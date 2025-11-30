FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && install-php-extensions \
    gd \
    pdo_pgsql \
    zip \
    bcmath \
    sockets \
    amqp \
    opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupmod -g ${GID} www-data && \
    usermod -u ${UID} -g ${GID} www-data

WORKDIR /var/www

COPY ./src/composer.json ./src/composer.lock ./

RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader --no-scripts

COPY --chown=www-data:www-data ./src .

RUN chmod -R ug+w storage bootstrap/cache

USER www-data

EXPOSE 9000
CMD ["php-fpm"]

HEALTHCHECK --interval=15s --timeout=3s --start-period=5s --retries=3 \
  CMD bash -c "echo > /dev/tcp/127.0.0.1/9000" || exit 1