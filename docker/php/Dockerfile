FROM php:7.4-apache

# habilita reescrita com .htaccess
RUN a2enmod rewrite

# cria php.ini
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# instala ferramentas úteis
RUN apt-get install -y \
    vim
