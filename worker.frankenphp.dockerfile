FROM dunglas/frankenphp:php8.3

# It defines where commands will be executed inside the container filesystem.
WORKDIR /app

# Copy all file & folder, this following command using for runner github action get the latest app and runner can push updated project to the docker hub (see the workflow on your github workflow deploy script)
COPY . /app 

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
  && docker-php-ext-install zip pcntl\
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

# download and Instal octane
RUN composer require laravel/octane && \
  php artisan octane:install --server=frankenphp

# RUN frankenphp php-cli optimize
RUN frankenphp php-cli artisan optimize

# this execute when the container it start not just when building
CMD php artisan octane:frankenphp --workers 20 --port 80

