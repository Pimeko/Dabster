FROM php:7-fpm

RUN apt-get update && apt-get install -y zlib1g-dev && apt-get install -y netcat
RUN docker-php-ext-install zip pdo pdo_mysql
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN mkdir -p /usr/src/dabster/
WORKDIR /usr/src/dabster/
COPY . /usr/src/dabster/

RUN mv /usr/src/dabster/.env.docker /usr/src/dabster/.env

EXPOSE 8000
RUN composer install

CMD bash wait_for_it.sh && php artisan migrate & php artisan serve --host=0.0.0.0