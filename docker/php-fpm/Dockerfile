FROM php:7.4-fpm

RUN apt update && apt install -y --no-install-recommends \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  curl \
  git \
  libzip-dev \
  zip \
  unzip \
  bsdtar \
  libpq-dev \
  libicu-dev \
  libmagickwand-dev \
  imagemagick \
  ssh

RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ \
  && docker-php-ext-install -j$(nproc) pdo_pgsql gd zip

COPY --from=composer:1.10.17 /usr/bin/composer /usr/local/bin/composer
RUN echo -n "Installed Composer Version: " && \
    composer --version


# only for development
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

CMD ["php-fpm", "-F"]