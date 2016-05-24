FROM php:7.0.6-alpine
MAINTAINER Jan Papenbrock <j.papenbrock@hochzehn.com>

# Install Xdebug
RUN pecl install xdebug \
 && echo "zend_extension=xdebug.so" >> "/usr/local/etc/php/conf.d/xdebug.ini"

VOLUME /app
WORKDIR /app

ENTRYPOINT ["php", "run.php"]
