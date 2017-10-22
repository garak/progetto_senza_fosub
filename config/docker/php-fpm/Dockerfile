FROM php:7.1-fpm

MAINTAINER Massimiliano Arione <userkio@gmail.com>

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

# Install other
RUN docker-php-ext-install sockets

# Install nodejs
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - && apt-get install -y nodejs

# install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.file_link_format=xdebug://%f@%l" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# install imagick
RUN apt-get update && apt-get install -y libmagickwand-6.q16-dev --no-install-recommends \
&& ln -s /usr/lib/x86_64-linux-gnu/ImageMagick-6.8.9/bin-Q16/MagickWand-config /usr/bin \
&& pecl install imagick \
&& echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer
RUN composer --version

# configure user
RUN mkdir /user
RUN useradd -d /user -s /bin/bash user
RUN chown user /user
USER user
RUN git config --global core.excludesfile ~/.gitignore

COPY php-fpm.conf /etc/php-fpm.conf
COPY create-database.sh /usr/local/bin/

ENTRYPOINT ["create-database.sh", "php-fpm"]

WORKDIR /user/progetto
