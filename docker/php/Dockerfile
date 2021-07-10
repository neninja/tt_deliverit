FROM php:7.4-apache

# habilita reescrita com .htaccess
RUN a2enmod rewrite

# cria php.ini
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# THANKS: https://github.com/docker-library/php/issues/221#issuecomment-601129850
RUN apt-get update; \
    apt-get install -y libpq5 libpq-dev libzip-dev zip; \
    docker-php-ext-install pdo pdo_pgsql zip; \
    apt-get autoremove --purge -y libpq-dev; \
    apt-get clean ; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# instala composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
