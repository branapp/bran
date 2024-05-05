# Use a base image that includes Ubuntu with PHP, Apache, and Node.js
FROM ubuntu:latest

RUN apt-get update && \
    apt-get install -y apache2 mariadb-server php8.1 php8.1-pdo php8.1-cli libapache2-mod-php8.1 git npm

RUN a2enmod php8.1 rewrite && \
    systemctl enable apache2

RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs

WORKDIR /var/www/html
COPY . .

RUN touch bran-config.php && \
    chown www-data:www-data bran-config.php && \
    chmod 600 bran-config.php

WORKDIR /var/www/html/api
RUN npm install

WORKDIR /var/www/html
RUN chown -R www-data:www-data .

EXPOSE 80 4567

CMD service apache2 start && \
    node /var/www/html/api/server.js