#Dockerfile del servidor de base de datos

FROM mysql:5

#Definir la contraseña de root
ENV MYSQL_ROOT_PASSWORD=1234

#Crear la base de datos
COPY ./db/script.sql /docker-entrypoint-initdb.d/script.sql
RUN /entrypoint.sh mysqld & sleep 30 && killall mysqld

#Asignar el puerto
EXPOSE 3060