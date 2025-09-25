FROM php:8.3-fpm-alpine AS builder

RUN apk add --no-cache \
    autoconf \
    build-base \
    linux-headers \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    libzip-dev \
    postgresql-dev \
    rabbitmq-c-dev \
    git \
    unzip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY ./src/composer.json ./src/composer.lock ./
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader --no-scripts

COPY ./src .

# ===================================

FROM php:8.3-fpm-alpine

ARG UID=1000
ARG GID=1000

RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    libpq \
    rabbitmq-c \
    bash \
    fcgi

COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /usr/bin/composer /usr/bin/composer

RUN addgroup -g ${GID} -S www && \
    adduser -u ${UID} -G www -s /bin/sh -D www

WORKDIR /var/www

COPY --from=builder --chown=${UID}:${GID} /var/www .

RUN chmod -R ug+w storage bootstrap/cache

USER www

EXPOSE 9000
CMD ["php-fpm"]

HEALTHCHECK --interval=15s --timeout=3s --start-period=5s --retries=3 \
  CMD SCRIPT_NAME=/ping SCRIPT_FILENAME=/ping REQUEST_METHOD=GET cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1