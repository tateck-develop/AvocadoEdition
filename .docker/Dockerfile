FROM php:7.4-apache

# install mysqli and gd
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd mysqli

# install app
COPY ./AvocadoEdition /var/www/html/
RUN chmod -R 707 /var/www/html/data