FROM php:7.4-fpm-alpine

RUN apk add --no-cache autoconf g++ make \
    && pecl install xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN apk add --no-cache libmcrypt-dev mysql-client \
    && docker-php-ext-install pdo_mysql

RUN docker-php-ext-install sockets

RUN apk add --no-cache supervisor

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./php/conf.d /usr/local/etc/php/conf.d
COPY ./php-fpm/conf.d /usr/local/etc/php/conf.d
COPY ./supervisor/conf.d/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /app

COPY ./php-fpm/entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
