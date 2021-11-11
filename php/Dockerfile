FROM php:7.4-fpm

WORKDIR /var/www/project

RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apt-get -y install cron


# xDebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Cron - At 09:00 on every day-of-week from Monday through Friday.
RUN echo "0 9 * * 1-5 root php /var/www/project/bin/console app:email:send >> /var/log/cron.log 2>&1" >> /etc/crontab

# Symfony

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
