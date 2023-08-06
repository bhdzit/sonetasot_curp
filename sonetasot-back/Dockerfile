# imagen de dockerhub que descargara
FROM php:8.1-fpm-alpine

# algunas configuraciones para que funcione el contenedor
RUN docker-php-ext-install pdo pdo_mysql

# instala composer en el contenedor
 RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY ./ /var/www/html
RUN cp /var/www/html/.env.example /var/www/html/.env 
RUN composer install --optimize-autoloader --no-dev --working-dir=/var/www/html
RUN chmod o+w /var/www/html/storage -R
RUN php /var/www/html/artisan key:generate
#RUN php /var/www/sonetasot-back/artisan migrate

