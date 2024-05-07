FROM debian:buster

# Set environment variables
ENV PHP_VERSION=8.1
ENV NODE_VERSION=14

# Update the package list
RUN apt-get update && \
    apt-get install -y curl gnupg lsb-release

# Import the key for the PHP repository
RUN curl -sS https://packages.sury.org/php/apt.gpg | apt-key add -

# Add the PHP repository to the sources list
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list

# Install required packages
RUN apt-get update && \
    apt-get install -y software-properties-common apache2 mariadb-server libapache2-mod-php${PHP_VERSION} php${PHP_VERSION} php${PHP_VERSION}-mysql git && \
    # curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - && \
    # apt-get install -y nodejs && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/*

# Enable required Apache modules
RUN a2enmod php${PHP_VERSION} rewrite && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Clone bran repository
RUN git clone https://github.com/branapp/bran.git

# Create and configure bran-config.php
RUN touch bran/bran-config.php && \
    chown www-data:www-data bran/bran-config.php && \
    chmod 600 bran/bran-config.php

# Change ownership of project directory
RUN chown -R www-data:www-data /var/www/html/bran

# Set webroot
RUN sed -i 's|/var/www/html|/var/www/html/bran/public|' /etc/apache2/sites-available/000-default.conf

# Start Apache and Node.js server
CMD ["apache2ctl", "-D", "FOREGROUND"]

# Expose ports
EXPOSE 80
