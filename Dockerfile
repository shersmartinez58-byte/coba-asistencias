FROM php:8.4-cli

# Instalamos Apache y dependencias del sistema
RUN apt-get update && apt-get install -y \
    apache2 \
    libapache2-mod-php \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    unzip \
    git \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalamos las extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Copiamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiamos el proyecto
WORKDIR /var/www/html
COPY . .

# Instalamos las dependencias de Laravel (ahora sí con PHP 8.4)
RUN composer install --no-dev --optimize-autoloader

# Damos permisos a Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configuramos Apache para apuntar a public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

EXPOSE 80

CMD php artisan migrate --force && apache2-foreground
