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

# Configure PHP for large file uploads (up to 1GB)
RUN { \
  echo 'upload_max_filesize = 1024M'; \
  echo 'post_max_size = 1024M'; \
  echo 'memory_limit = 1536M'; \
  echo 'max_execution_time = 600'; \
  echo 'max_input_time = 600'; \
  } > /usr/local/etc/php/conf.d/uploads.ini

RUN composer install --no-interaction --prefer-dist --optimize-autoloader