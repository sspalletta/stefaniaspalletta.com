FROM php:7.1-apache

MAINTAINER Sebastian Buckpesch <s.buckpesch@gmail.com>

# Set the locale
RUN apt-get clean && apt-get -y update && apt-get install -y locales && locale-gen en_US.UTF-8

# Install Ubuntu packages
RUN apt-get install -y \
        build-essential \
        curl \
        git \
        libcurl4-openssl-dev \
        libicu-dev \
        libmcrypt-dev \
        libmysqlclient-dev \
        libpng-dev \
        mysql-client \
        ruby-full \
        software-properties-common \
        vim \
        zip

# Install PHP and NodeJS
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - \
    && apt-get install -y \
        nodejs \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install \
      curl \
      #fpm \
      gd \
      intl \
      json \
      mbstring \
      mcrypt \
      mysqli \
      pdo_mysql \
      zip \
      opcache \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && npm install -g yarn webpack yo xclap-cli generator-electrode \
    && mkdir /run/php \
    && apt-get remove -y --purge software-properties-common \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Dev dependecies
RUN curl -fsSL 'https://xdebug.org/files/xdebug-2.5.5.tgz' -o xdebug.tar.gz \
        && mkdir -p xdebug \
        && tar -xf xdebug.tar.gz -C xdebug --strip-components=1 \
        && rm xdebug.tar.gz \
        && ( \
        cd xdebug \
        && phpize \
        && ./configure --enable-xdebug \
        && make -j$(nproc) \
        && make install \
        ) \
        && rm -r xdebug \
        && docker-php-ext-enable xdebug
RUN su -c "gem install sass"

# Apache configuration
RUN a2enmod rewrite ssl
RUN service apache2 restart

# Change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data