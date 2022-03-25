FROM php:8.1-fpm
USER root

# Set working directory
WORKDIR /var/www/newspaper

RUN  rm /etc/apt/preferences.d/no-debian-php

# Install dependencies
RUN apt-get update -y \
  && apt-get install -y \
        ssh \
        zip \
        php-zip \
        php-dev \
        libpq-dev \
  && apt-get clean -y \
  && docker-php-ext-install pcntl sockets

RUN pecl install xdebug \
 && docker-php-ext-enable xdebug

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ADD ./php.ini /usr/local/etc/php/php.ini

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]

