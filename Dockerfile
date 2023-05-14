FROM php:8.1-apache
WORKDIR /var/www/html
COPY . .
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN docker-php-ext-install pdo pdo_mysql
# Enable Apache rewrite module
RUN a2enmod rewrite

# Set file permissions
RUN chown -R www-data:www-data .
EXPOSE 80