FROM php:8.1-fpm-buster
ARG TIMEZONE

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    libpq-dev \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    iputils-ping \
    telnet \
    nano \
    less \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN apt-get update && \
  apt-get install -y --no-install-recommends gcc git libssl-dev g++ make && \
  cd /tmp && git clone https://github.com/edenhill/librdkafka.git && \
  cd librdkafka && git checkout tags/v1.9.2 && \
  ./configure && make && make install && \
  pecl channel-update pecl.php.net && \
  pecl install rdkafka && \
  docker-php-ext-enable rdkafka && \
  cd ../ && rm -rf librdkafka

RUN docker-php-ext-configure gd --with-jpeg --with-freetype 

RUN docker-php-ext-install \
    pgsql pdo pdo_pgsql pdo_mysql zip xsl gd intl opcache exif mbstring
# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo 'alias codecept="/src/vendor/bin/codecept"' >> ~/.bashrc
RUN echo 'alias exportDebug="export PHP_IDE_CONFIG=serverName=sf-auth.devel"' >> ~/.bashrc

WORKDIR /src