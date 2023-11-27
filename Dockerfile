# Utiliza la imagen de PHP con Apache
FROM php:8.2-apache

# Establece el directorio de trabajo en /var/www/html
WORKDIR /var/www/html

# Copia los archivos del proyecto al contenedor
COPY . .

# Instala las dependencias necesarias
RUN apt-get update \
    && apt-get install -y zip unzip p7zip libxml2-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install soap pdo pdo_mysql


# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

# Instala las dependencias de Composer
RUN composer install 

# Configura el host virtual de Apache para apuntar directamente a la carpeta public
RUN sed -i 's/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\/public/g' /etc/apache2/sites-available/000-default.conf

# Activa el módulo de reescritura de Apache para permitir URLs amigables
RUN a2enmod rewrite

# Configura las variables de entorno para Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APACHE_LOG_DIR /var/log/apache2

# Configura Apache para permitir la reescritura de URL
RUN echo "<Directory /var/www/html/public>" >> /etc/apache2/apache2.conf
RUN echo "    Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf
RUN echo "    AllowOverride All" >> /etc/apache2/apache2.conf
RUN echo "    Require all granted" >> /etc/apache2/apache2.conf
RUN echo "</Directory>" >> /etc/apache2/apache2.conf

# Permite la escritura en los directorios de almacenamiento de Laravel
RUN chmod -R 775 storage bootstrap/cache

# Exponer el puerto 80
EXPOSE 80

# Inicia el servidor Apache en primer plano
CMD ["apache2-foreground"]
