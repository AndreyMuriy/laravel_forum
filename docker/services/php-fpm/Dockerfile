FROM php:7.3-fpm

RUN echo "Install libraries" \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        libmemcached-dev \
        libz-dev \
        libzip-dev \
        libsodium-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        libmcrypt-dev \
        mariadb-client \
        wget \
        git \
        unzip \
    && rm -rf /var/lib/apt/lists/*

RUN echo "Install extensions" \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip sodium bcmath \
    && docker-php-ext-enable pdo_mysql pdo_pgsql zip sodium bcmath \
    && docker-php-ext-configure gd \
    --with-jpeg-dir=/usr/lib \
    --with-freetype-dir=/usr/include/freetype2 \
    && docker-php-ext-install gd

RUN echo "Install XDebug" \
    && pecl install xdebug-2.7.2 \
    && docker-php-ext-enable xdebug

RUN echo "Install composer" \
    && wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

RUN groupadd -r andrey \
    && useradd -r andrey -g andrey

USER andrey

WORKDIR /var/www
