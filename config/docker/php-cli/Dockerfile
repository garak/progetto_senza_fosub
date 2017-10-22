FROM php:7.1-cli

# Add php extension

RUN apt-get update && apt-get install -y \
    git \
    unzip

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Rome /etc/localtime
RUN "date"

# Install PHP extension
# Type docker-php-ext-install to see available extensions
# Install PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++ vim mysql-client netcat-openbsd
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# configure user
RUN mkdir /user
RUN useradd -d /user -s /bin/bash user
RUN chown user /user
USER user

WORKDIR /user/progetto

