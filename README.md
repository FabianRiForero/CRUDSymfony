# CRUD Basico Symfony 5.4

Este proyecto es un ejercicio de la creacion de un **CRUD** (Create, Read, Update) utilizando **Doctrine** para la creacion de la base de Datos en el SGBD MySQL.

El ejercicio consta de un sistema donde uno pueda crear, visualizar, modificar y eliminar un producto y categoria. Las tecnologias usadas son las siguientes:
- PHP >= 7.2.5
- Composer
- Symfony 5.4
 - Validaciones
 - Formularios
- Twig (Template Engine)
- Bootstrap 5
- MySQL

1. Para probarlo despues de clonarlo ejecutar el comando **`composer update`** para traer las dependencias que necesita el proyecto.
2. Configura el usuario y contraseña con su Base de Datos en el archivo **`.env`** y cree una base de datos con el nombre **`pruebasymfony`** o ejecutando el comando **`php bin/console doctrine:database:create`**. Mirar el RAW de este archivo y copiar el comando ya que el editor lo interpreta como una imagen
3. Ejecutar el comando **`php bin/console doctrine:schema:update --force`** para crear las tablas. Mirar el RAW de este archivo y copiar el comando ya que el editor lo interpreta como una imagen
4. Una vez hecho los anteriores pasos ejecutar **`php bin/console server:run`** para ejecutar el servidor y probarlo.
