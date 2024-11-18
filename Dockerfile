# Usa una imagen base de PHP con FPM
FROM php:8.2-fpm

# Instalar dependencias adicionales (si es necesario)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar los archivos del proyecto a la imagen
COPY . /var/www/html/proyecto

# Establecer el directorio de trabajo
WORKDIR /var/www/html/

# Ajustar permisos si es necesario
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 9000 (puerto PHP-FPM)
EXPOSE 9000

# Ejecutar PHP-FPM
CMD ["php-fpm"]
