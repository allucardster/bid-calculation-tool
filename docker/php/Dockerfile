FROM php:8.1-fpm

RUN apt-get update && \
apt-get install -y \
apt-utils \
zip \
git \
zlib1g-dev \
libzip-dev \
libicu-dev \
g++ \
libpq-dev \
nodejs \
npm

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install intl extension
RUN docker-php-ext-configure intl \
&& docker-php-ext-install intl

# Install ext-zip
RUN docker-php-ext-install zip

# Enable opcache
RUN docker-php-ext-enable opcache

# Install pdo
RUN docker-php-ext-install pdo

# Install postgres
#RUN docker-php-ext-install pdo_pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

# Setup workdir
WORKDIR /opt/app
