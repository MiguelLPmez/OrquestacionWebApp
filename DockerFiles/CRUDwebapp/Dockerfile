#Dockerfile de la aplicación web CRUD.

FROM php:8.0.11-apache

# Extensiones php y apache para comunicarnos con mysql desde el código
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN a2enmod headers expires rewrite

# Copiar los archivos al VirtualHost
COPY ./demo.com /var/www/html

# Asignar el puerto
EXPOSE 80
