FROM php:7.1.3-fpm
MAINTAINER Superbalist <info@superbalist.com>

RUN apt-get update

RUN apt-get install -qy \
    git \
    nginx \
    python \
    supervisor \
    unzip \
    zlib1g-dev

WORKDIR /var/www
RUN rm -rf /var/www/html

RUN docker-php-ext-install -j$(nproc) opcache zip

ENV COMPOSER_HOME /composer
ENV PATH /composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
  && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
  && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
  && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --version=1.1.0 && rm -rf /tmp/composer-setup.php \
  && composer global require "hirak/prestissimo:^0.3"

COPY src/composer.json /var/www/
RUN composer install --no-autoloader --no-scripts --no-interaction

COPY src /var/www/
COPY configs/nginx/nginx.conf /etc/nginx/
COPY configs/nginx/default /etc/nginx/sites-available/
COPY configs/php-fpm/php.ini /usr/local/etc/php/
COPY configs/php-fpm/php-fpm.conf /usr/local/etc/
COPY configs/php-fpm/www.conf /usr/local/etc/php-fpm.d/
COPY configs/supervisor/supervisord.conf /etc/supervisor/
COPY configs/supervisor/nginx.conf /etc/supervisor/conf.d/
COPY configs/supervisor/php-fpm.conf /etc/supervisor/conf.d/

RUN composer dump-autoload --no-interaction

EXPOSE 80
CMD ["supervisord"]
