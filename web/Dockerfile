FROM php:8-apache

#RUN apt update && apt install -y curl gnupg && \
#    curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
#    apt install -y nodejs

RUN apt update && apt upgrade -y
RUN apt install -y mc vim nano less

RUN apt install -y libxslt1-dev
RUN docker-php-ext-install xsl

RUN apt install -y libpq-dev && docker-php-ext-install pdo_pgsql
RUN pecl install xdebug && docker-php-ext-enable xdebug

#RUN cat <<EOF >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#xdebug.mode=debug
#xdebug.idekey=docker
#xdebug.start_with_request=yes
#xdebug.client_host=host.docker.internal
#xdebug.client_port=9003
#EOF

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod headers rewrite
WORKDIR /var/www/html

##WORKDIR /app
##COPY web/package*.json ./
##RUN npm install -D tailwindcss postcss autoprefixer
##COPY web/tailwind.config.js web/postcss.config.js web/input.css ./
##COPY . /var/www/html
##RUN npx tailwindcss -i ./input.css -o ./output.css --minify