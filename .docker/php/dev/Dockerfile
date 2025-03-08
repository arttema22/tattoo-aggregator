FROM php:8.0-fpm AS build_php

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    locales \
    libzip-dev \
    libjpeg62-turbo-dev libwebp-dev libpng-dev libxpm-dev \
    libfreetype6-dev \
    jpegoptim optipng pngquant gifsicle \
    zip \
    unzip \
    git \
    vim \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN set -eux; \
	docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp; \
    docker-php-ext-install pdo_mysql zip exif pcntl gd

ADD .docker/php/dev/php.ini /usr/local/etc/php/php.ini
RUN groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

WORKDIR /var/www
COPY . /var/www
RUN chown -R 1000:1000 /var/www \
    && chown -R www:www /var/www \
    && curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
