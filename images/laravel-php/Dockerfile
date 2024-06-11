FROM php:8.1.14-apache

ARG USER_ID
ARG GROUP_ID
RUN groupadd -f -g $GROUP_ID user
RUN useradd -u  $USER_ID -g $GROUP_ID user
USER root

WORKDIR /var/www/html

RUN apt update && apt install -y \
        nodejs \
        npm \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite

# installer les utilitaire
RUN apt-get update -y && apt-get install -y \
    build-essential \
    mariadb-client\
    libpng-dev\
    libjpeg62-turbo-dev\
    libfreetype6-dev\
    locales\
    zip\
    wget \
    bash \
    vim \
    zsh \
    net-tools \
    tar \
    iputils-ping \
    curl

# this was missing for some reason. Didn't require last time.
RUN apt-get install -y gnupg2
# install de composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#installation et configuration de sudo
RUN apt-get install -y sudo

# install extensions
RUN  docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y libzip-dev
#installation de php-redis
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis


RUN docker-php-ext-install pdo_mysql zip exif opcache
RUN apt-get install libicu-dev -y
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN apt-get remove libicu-dev icu-devtools -y
#installation de imagemagik
# RUN apt update && \
#     apt upgrade && \
#     apt install -y libmagickwand-dev --no-install-recommends && \
#     pecl install imagick && docker-php-ext-enable imagick && \
#     rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick
# installation de mongodb
RUN apt-get update \
    && apt-get install -y --no-install-recommends openssl libssl-dev libcurl4-openssl-dev \
    && pecl install mongodb \
    && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
    && echo "extension=mongodb.so" >> /usr/local/etc/php/php.ini \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
# RUN pecl install mongodb \
#     &&  echo "extension=mongo.so" > /usr/local/etc/php/conf.d/mongo.ini

# installation de node js14
RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs
# RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
# RUN apt -y install nodejs
RUN apt -y  install gcc g++ make

Run npm install -g yarn


RUN apt-get update && apt-get install -y openssh-server
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

RUN mkdir /var/run/sshd
RUN echo 'root:1234' | chpasswd
# SSH & Keeping Session Alive

#INSTALL swole for octave

RUN pecl install swoole -y
RUN pecl install pecl install openswoole-22.0.0 -y
RUN echo "extension=openswoole.so" >> /usr/local/etc/php/php.ini

RUN docker-php-ext-configure pcntl --enable-pcntl
RUN docker-php-ext-install pcntl


WORKDIR /var/www


COPY vhost.conf /etc/apache2/sites-available/000-default.conf

RUN useradd -m -s /bin/bash sshuser
RUN echo 'sshuser:fiZX867rze' | chpasswd
RUN echo "sshuser ALL=NOPASSWD: ALL" >>  /etc/sudoers
EXPOSE 22

RUN usermod -a -G root sshuser

RUN apt -y install certbot python3-certbot-apache
RUN a2enmod ssl
RUN mkdir /var/certbot

RUN wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6.1-2/wkhtmltox_0.12.6.1-2.bullseye_amd64.deb
RUN apt -y install -f ./wkhtmltox_0.12.6.1-2.bullseye_amd64.deb
RUN npm install -g laravel-echo-server
RUN sed -i 's,^memory_limit =.*$,memory_limit = 2148M,' /usr/local/etc/php/php.ini
RUN sed -i 's,^max_execution_time =.*$,max_execution_time = 6000,' /usr/local/etc/php/php.ini

RUN echo 'user:fiZX867rze' | chpasswd
RUN echo "user ALL=NOPASSWD: ALL" >>  /etc/sudoers

RUN apt -y install -f python3-pip
RUN pip install RPLCD
RUN apt -y install -f python3-smbus
RUN echo "fs.inotify.max_user_instances=524288" >> /etc/sysctl.conf
RUN echo "fs.inotify.max_user_watches=524288" >> /etc/sysctl.conf
RUN echo "fs.inotify.max_queued_events=524288" >> /etc/sysctl.conf
RUN echo fs.inotify.max_user_watches=524288 |  tee -a /etc/sysctl.conf
#RUN #sudo npm install -g npm@6.4
RUN pip install  pandas
RUN pip install  numpy
RUN pip install  sqlalchemy
RUN pip install mysql-connector-python-rf
RUN pip install openpyxl

COPY start.sh /usr/local/bin/start
RUN  chmod +x /usr/local/bin/start
USER user

CMD ["/usr/local/bin/start"]