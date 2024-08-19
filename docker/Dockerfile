FROM php:8.2-fpm

ARG user
ARG uid

RUN apt-get update
RUN apt-get install -y --no-install-recommends apt-utils

RUN apt-get install -y build-essential \
    openssl \
    nano \
    unzip \
    curl \
    git \
    wget \
    openssl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    supervisor

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd opcache
RUN pecl install redis && docker-php-ext-enable redis

RUN mkdir /tmp/composer \
	&& cd /tmp/composer ;\
    COMPOSER_SUM="$(curl -sSL https://composer.github.io/installer.sig)" \
    && curl -o /tmp/composer/composer-setup.php https://getcomposer.org/installer \
    && echo "$COMPOSER_SUM composer-setup.php" > composer-setup.php.sha384 \
    && sha384sum -c /tmp/composer/composer-setup.php.sha384 || exit 1 \
    && php composer-setup.php --quiet --filename=composer --install-dir=/bin \
    && rm -rf *

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf


WORKDIR /var/www/html
COPY composer.json composer.lock  /var/www/html/

COPY ./docker/start.sh /start.sh
RUN chmod +x /start.sh

USER $user
CMD ["/start.sh"]
