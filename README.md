# OrquestacionWebApp
Proyecto final para la materia de laboratorio de despliegue de aplicaciones. Despliegue de una webapp CRUD en kubernetes

Navegación de directorios
- DockerFiles
  - CRUDdb
    - db: 
      - Script de la base de datos
    - Dockerfile del contenedor del servidor MySQL de la base de datos
  - CRUDwebapp
    - demo.com:
      - Archivos de la página web
    - Dockerfile del contenedor de Apache + PHP

- KubernetesDeploy
  - persistencia:
    - YAML del PV
    - YAML del PVC
  - servicios:
    - YAML del servicio NodePort para acceder al deploy del servidor Apache 
    - YAML del servicio ClusterIP para la comunicación de Apache con MySQL
    - YAML de Ingress
  - YAML del deploy de Apache
  - YAML del deploy de MySQL
  - YAML del namespace
    

