FROM php:8.2-fpm


ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

# В Ubuntu группа staff имеет gid 20, как и dialout в alpine linux. Мы не используем dialout, поэтому удалим её.
RUN delgroup dialout

RUN addgroup --gid ${GID} laravel
RUN adduser --disabled-password --gecos '' --uid ${UID} --gid ${GID} laravel






RUN mkdir -p /var/www/html

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libjpeg-dev \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
    libmagickwand-dev\
        graphviz \
        ffmpeg \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets \
    && docker-php-source delete \
    && curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer \
    && apt-get install -y npm

RUN apt-get install -y libmagickwand-dev; \
    pecl install imagick; \
    docker-php-ext-enable imagick;

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY ./php.ini "$PHP_INI_DIR/php.ini"

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]

USER laravel
