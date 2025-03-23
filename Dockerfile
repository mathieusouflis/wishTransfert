FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

RUN a2enmod rewrite

RUN { \
    echo 'upload_max_filesize = 4G'; \
    echo 'post_max_size = 4G'; \
    echo 'memory_limit = 512M'; \
    echo 'max_execution_time = 300'; \
    echo 'max_input_time = 300'; \
    echo 'opcache.enable = 1'; \
    echo 'opcache.memory_consumption = 128'; \
    echo 'opcache.interned_strings_buffer = 8'; \
    echo 'opcache.max_accelerated_files = 4000'; \
} > /usr/local/etc/php/conf.d/custom.ini

RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf && \
    echo 'LimitRequestBody 4294967296' >> /etc/apache2/apache2.conf && \
    echo 'TimeOut 300' >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html && \
    echo 'fs.file-max = 65536' >> /etc/sysctl.conf

EXPOSE 80

CMD ["apache2-foreground"]
