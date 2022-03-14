FROM php:8.0.2-fpm

# Instalamos las dependencias necesarias
RUN apt-get update && apt-get -y install \
build-essential \ 
libzip-dev \ 
libpng-dev \ 
libjpeg62-turbo-dev \
libfreetype6-dev \
libonig-dev \
locales \
zip \
jpegoptim \
optipng \
pngquant \
gifsicle \
vim \
git \
curl


# Instalamos extensiones de PHP
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Instalamos composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#nos movemos a la carpeta del proyecto
WORKDIR /var/www/html

# Instalamos dependendencias de composer
#RUN composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader --no-scripts

#Damos permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod 755 /var/www/html

