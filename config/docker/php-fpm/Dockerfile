FROM composer:1.10 AS composer
FROM php:7.4-fpm

MAINTAINER Massimiliano Arione <garakkio@gmail.com>

# Add packages
RUN apt update && apt install -y --no-install-recommends git unzip ssh

# Set timezone
RUN rm /etc/localtime && ln -s /usr/share/zoneinfo/Europe/Rome /etc/localtime

# Install PHP extensions
RUN apt update && apt install -y --no-install-recommends zlib1g-dev libicu-dev g++ vim default-mysql-client gnupg libonig-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl ctype mbstring iconv

# Install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN { \
      echo 'error_reporting = E_ALL'; \
      echo 'display_startup_errors = On'; \
      echo 'display_errors = On'; \
      echo 'xdebug.remote_enable=1'; \
      echo 'xdebug.remote_connect_back=1'; \
      echo 'xdebug.idekey="PHPSTORM"'; \
      echo 'xdebug.remote_port=9001'; \
      echo 'xdebug.file_link_format=xdebug://%f@%l'; \
    } >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Force php timezone
RUN echo "date.timezone = Europe/Rome" >> /usr/local/etc/php/conf.d/docker-php-datetime.ini

# Install Composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Configure user
RUN mkdir /user && useradd -d /user -s /bin/bash user && chown user /user
USER user
RUN git config --global core.excludesfile ~/.gitignore

COPY php-fpm.conf /etc/php-fpm.conf

WORKDIR /user/progetto
