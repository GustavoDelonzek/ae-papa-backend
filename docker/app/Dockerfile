FROM php:8.3-fpm-alpine AS builder

RUN apk add --no-cache \
    build-base \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    libzip-dev \
    postgresql-dev \
    git \
    unzip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath

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
    bash \
    curl  # necessário para o HEALTHCHECK

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

HEALTHCHECK --interval=30s --timeout=5s --start-period=5s --retries=3 \
  CMD curl -f http://localhost:9000 || exit 1