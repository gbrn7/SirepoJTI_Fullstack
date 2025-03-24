FROM dunglas/frankenphp:php8.3

ENV SERVER_NAME=":80"

WORKDIR /app

COPY . /app

# RUN apt update && apt install zip libzip-dev -y && \
#   docker-php-ext-install zip && \
#   docker-php-ext-enable zip &&\
#   apt install gd php-gd -y &&\
#   docker-php-ext-install gd &&\
#   docker-php-ext-enable gd 


RUN apt-get update && apt-get install -y \
  libzip-dev\
  libjpeg-dev \
  libpng-dev \
  libfreetype6-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd \
  && docker-php-ext-install zip \
  && docker-php-ext-enable zip \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer 

RUN composer install