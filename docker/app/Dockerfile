FROM php:7.4-cli-alpine

RUN apk upgrade --update && apk add --no-cache \
            bzip2 \
            curl \
            freetype \
            file \
            git \
            gmp-dev \
            icu-dev \
            libffi\
            libintl \
            libjpeg-turbo\
            libpng \
            libxml2 \
            libxslt \
            libzip-dev \
            postgresql-dev \
            re2c \
        && apk add --virtual .build-deps \
            autoconf \
            bzip2-dev \
            curl-dev \
            dpkg-dev dpkg \
            freetype-dev \
            g++ \
            gcc \
            gettext-dev \
            icu-dev \
            ldb-dev \
            libc-dev \
            libffi-dev \
            libjpeg-turbo-dev \
            libpng-dev \
            libsodium-dev \
            libxml2-dev \
            libxslt-dev \
            make \
            oniguruma-dev \
            pcre-dev \
            postgresql-dev \
            pkgconf \
            sqlite-dev \
            wget \
        && docker-php-ext-install bcmath bz2 calendar dba exif ffi gd gettext gmp  intl opcache \
            pcntl pdo pdo_mysql pdo_pgsql pdo_sqlite soap sockets sodium xsl zend_test zip \
        && pecl install xdebug && docker-php-ext-enable xdebug \
        && apk del .build-deps && rm -rf /var/cache/apk/* && docker-php-source delete

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN addgroup -g ${PGID} application && \
    adduser -D -u ${PUID} -h "/home/application" -s /bin/bash -G application application && \
    mkdir /app && \
    chown application:application /app

COPY docker/app/ext-xdebug.ini /usr/local/etc/php/conf.d/

WORKDIR /app
USER application
