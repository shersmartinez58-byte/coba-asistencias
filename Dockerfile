# Usamos una imagen oficial de PHP con Apache
FROM php:8.4-apache

# Instalamos las extensiones necesarias para Laravel y tu proyecto
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuramos el directorio de trabajo
WORKDIR /var/www/html

# Copiamos los archivos del proyecto
COPY . .

# Instalamos las dependencias de PHP sin las de desarrollo
RUN composer install --no-dev --optimize-autoloader

# Damos permisos a las carpetas que Laravel necesita escribir
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configuramos Apache para que apunte a la carpeta public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Habilitamos el módulo de reescritura de Apache
RUN a2enmod rewrite

# Exponemos el puerto 80
EXPOSE 80

# El comando de inicio: corre las migraciones y luego inicia Apache
CMD php artisan migrate --force && apache2-foreground
