FROM dunglas/frankenphp:php8.3

# It defines where commands will be executed inside the container filesystem.
WORKDIR /app

# Executes when the image is being built, used to install packages, copy files, or set up the environment
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

# Configure PHP for large file uploads (up to 1GB)
RUN { \
  echo 'upload_max_filesize = 1024M'; \
  echo 'post_max_size = 1024M'; \
  echo 'memory_limit = 1536M'; \
  echo 'max_execution_time = 600'; \
  echo 'max_input_time = 600'; \
  } > /usr/local/etc/php/conf.d/uploads.ini

COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# RUN frankenphp php-cli optimize
RUN frankenphp php-cli artisan optimize

RUN php artisan optimize
