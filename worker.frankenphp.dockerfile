FROM dunglas/frankenphp:php8.3

WORKDIR /app

# Copy all file & folder to the /app inside container
COPY . /app
# Copy Caddyfile in this project to /etc/caddy/Caddyfile in the docker container 
COPY Caddyfile /etc/caddy/Caddyfile

# give permission document folder 
RUN chmod -R 775 /app/storage && \
  chown -R www-data:www-data /app/storage

# Enabling the Worker Mode by Default by add the bellow config to .to env
ENV FRANKENPHP_CONFIG="worker ./public/index.php" 

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

RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
  composer require laravel/octane && \
  php artisan octane:install --server=frankenphp

