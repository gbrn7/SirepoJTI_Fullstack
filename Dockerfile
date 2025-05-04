FROM php:8.3-fpm

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
  libzip-dev\
  libjpeg-dev \
  libpng-dev \
  libfreetype6-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd pdo pdo_mysql\
  && docker-php-ext-install zip \
  && docker-php-ext-enable zip \
  && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www

# ✅ src file for execute composer install
COPY src/ .

# ✅ Install dependencies before copying all files
RUN sed 's_@php artisan package:discover_/bin/true_;' -i composer.json \
  && composer install --no-dev --optimize-autoloader \
  && composer clear-cache \
  && php artisan package:discover --ansi \
  && chmod -R 775 storage \
  && chown -R www-data:www-data storage \
  && mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache


CMD ["php-fpm"]