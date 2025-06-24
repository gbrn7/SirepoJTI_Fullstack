FROM dunglas/frankenphp:php8.3

ENV SERVER_NAME=":80"

WORKDIR /app

COPY . /app

RUN apt update && apt install -y \
  zip \
  libzip-dev \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libonig-dev \
  libxml2-dev \
  && docker-php-ext-configure zip \
  && docker-php-ext-install zip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd \
  && docker-php-ext-install pdo_mysql

COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

RUN composer install