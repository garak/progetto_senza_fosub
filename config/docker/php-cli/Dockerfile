FROM php:7.4-cli

# Add git and unzip
RUN apt update && apt install -y --no-install-recommends git unzip

# Set timezone
RUN rm /etc/localtime && ln -s /usr/share/zoneinfo/Europe/Rome /etc/localtime

# Install extensions
RUN apt update && apt install -y --no-install-recommends zlib1g-dev libicu-dev g++ vim libonig-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl ctype mbstring pdo pdo_mysql

RUN echo "memory_limit = -1" >> /usr/local/etc/php/conf.d/memory-limit.ini

# Configure user
RUN mkdir /user && useradd -d /user -s /bin/bash user && chown user /user
USER user

WORKDIR /user/progetto
