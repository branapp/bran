FROM debian:buster

# Set environment variables
ENV PHP_VERSION=8.1
ENV NODE_VERSION=14

# Update and install necessary packages
RUN apt-get update && apt-get install -y \
    curl gnupg lsb-release sudo

# Install sudo and configure it
RUN apt-get install -y sudo && \
    echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

# Add the PHP repository
RUN curl -sS https://packages.sury.org/php/apt.gpg | apt-key add - && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list

# Install Apache, MariaDB, PHP, and other necessary packages
RUN apt-get update && apt-get install -y \
    software-properties-common apache2 mariadb-server \
    libapache2-mod-php${PHP_VERSION} php${PHP_VERSION} \
    php${PHP_VERSION}-mysql git && \
    apt-get autoremove -y && rm -rf /var/lib/apt/lists/*

RUN a2enmod php${PHP_VERSION} rewrite && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set the working directory
WORKDIR /var/www/html

# Clone the repository as www-data
RUN sudo -u www-data git clone https://github.com/branapp/bran.git && \
    chown -R www-data:www-data /var/www/html/bran

# Adjust the Apache configuration to serve the app
RUN sed -i 's|/var/www/html|/var/www/html/bran/public|' /etc/apache2/sites-available/000-default.conf

# Copy the startup script into the container
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Command to run the startup script
CMD ["/usr/local/bin/start.sh"]

EXPOSE 80
