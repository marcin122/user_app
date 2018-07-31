FROM php:7.1-apache

# Install any custom system requirements
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    curl \
    libicu-dev \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    libxml2-dev \
    libbz2-dev \
    libjpeg62-turbo-dev \
    git \
    subversion \
    mc\
  && rm -rf /var/lib/apt/lists/*

# Install various PHP extensions
RUN docker-php-ext-configure bcmath --enable-bcmath \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
    && docker-php-ext-configure pdo_pgsql --with-pgsql \
    && docker-php-ext-configure mbstring --enable-mbstring \
    && docker-php-ext-configure soap --enable-soap \
    && docker-php-ext-install \
        bcmath \
        intl \
        mbstring \
        mcrypt \
        mysqli \
        pcntl \
        pdo_mysql \
        pdo_pgsql \
        soap \
        sockets \
        zip \
  && docker-php-ext-configure gd \
    --enable-gd-native-ttf \
    --with-jpeg-dir=/usr/lib \
    --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd

# xdebug extension
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# xdebug configration
ADD docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# php configuration
ADD docker/php.ini /usr/local/etc/php/conf.d/php.ini

# apache configuration
ADD docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

ADD . /app
WORKDIR /app

RUN chown -R www-data:www-data /var/www/