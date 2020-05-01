FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        git \
        unzip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr --with-jpeg-dir=/usr --with-png-dir=/usr \
    && docker-php-ext-install -j "$(nproc)" gd mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli pdo pdo_mysql

#install Imagemagick & PHP Imagick ext
RUN apt-get update && apt-get install -y \
        libmagickwand-dev --no-install-recommends

RUN pecl install imagick && docker-php-ext-enable imagick

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

# install xdebug
RUN pecl install xdebug \
&& docker-php-ext-enable xdebug \
&& echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN echo 'alias sf="php app/console"' >> ~/.bashrc \
&& echo 'alias sf3="php bin/console"' >> ~/.bashrc

# remove not necessary files
RUN rm -rf /var/lib/apt/lists/*

ADD ./php.ini /usr/local/etc/php/php.ini

CMD ["php-fpm"]
