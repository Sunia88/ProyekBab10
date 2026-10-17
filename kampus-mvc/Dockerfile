# Dockerfile - image PHP 8.3 + Apache untuk kampus-mvc (pengganti XAMPP)
FROM php:8.3-apache

# Ekstensi PDO MySQL (dipakai core/Database.php) + Xdebug untuk debugging di PhpStorm
RUN docker-php-ext-install pdo_mysql \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug

# Aktifkan mod_rewrite agar public/.htaccess (Kode 10.4) bekerja
RUN a2enmod rewrite

# Document root = folder public/ (praktik keamanan Sub-bab 10.3.1)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/*.conf \
 && printf '<Directory ${APACHE_DOCUMENT_ROOT}>\n    AllowOverride All\n    Require all granted\n</Directory>\n' \
        > /etc/apache2/conf-available/kampus.conf \
 && a2enconf kampus

COPY docker/php/kampus.ini /usr/local/etc/php/conf.d/kampus.ini

WORKDIR /var/www/html
