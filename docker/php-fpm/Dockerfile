FROM php:7.3-fpm-alpine

# Set timezone
RUN apk add tzdata && \
    cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime && \
    echo "America/Sao_Paulo" > /etc/timezone && \
    apk del tzdata

# Install the PHP pdo_pgsql extention
RUN apk add --no-cache postgresql-dev && \
    docker-php-ext-install pdo_pgsql

# Install the PHP pdo_pgsql extention
RUN docker-php-ext-install pdo_mysql

## Install the PHP zip extention
RUN apk add --no-cache libzip-dev && \
    docker-php-ext-install zip

## Install the PHP opcache extention
RUN docker-php-ext-install -j$(nproc) opcache

## Install the PHP bcmath extension
RUN docker-php-ext-install -j$(nproc) bcmath

## Install the PHP sockets extension
RUN docker-php-ext-install -j$(nproc) sockets

## Install the PHP iconv extension
RUN docker-php-ext-install -j$(nproc) iconv

## Install the PHP intl extension
RUN apk add --no-cache icu-dev && \
    docker-php-ext-install intl

## Install the PHP soap extension
RUN apk add --no-cache libxml2-dev && \
    docker-php-ext-install soap

RUN docker-php-ext-install pcntl

# Install the PHP gd extension
RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev && \
  docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install -j$(nproc) gd

# Install the PHP xdebug extension
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apk del -f .build-deps

# Copy xdebug configuration for remote debugging
#COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer && \
    curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig && \
    php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" && \
    php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --snapshot && \
    rm -f /tmp/composer-setup.* && \
    chown 1000.www-data /usr/local/bin/composer

RUN apk --no-cache add shadow && \
    usermod -u 1000 www-data && \
    apk del shadow

USER www-data
## Instalando prestissimo para installs rápidos
# RUN composer global require "hirak/prestissimo"

ENV PATH="/home/www-data/.composer/vendor/bin:${PATH}"

USER root


