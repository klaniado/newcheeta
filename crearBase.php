<?php
require_once 'db-mysql.php';
$host='localhost';
$user='root';
$pass='root';
$conexion=mysql_connect($host,$user,$pass);
$sql="CREATE database cheta";
$inseltar=mysql_query($sql,$conexion);
if(!$inseltar){
    echo 'Error al crear la base de datos';
    }else{
        echo 'Base de datos creada exitosamente';



        mysql_select_db('test',$conexion);
        $tabla="CREATE TABLE IF NOT EXISTS `usuarios` ( `id` INT NULL DEFAULT NULL AUTO_INCREMENT , `nombre` VARCHAR(30) NOT NULL , `apellido` VARCHAR(30) NOT NULL , `mail` VARCHAR(50) NOT NULL , `password` VARCHAR(1000) NOT NULL , `edad` INT(100) NOT NULL , `pais` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`mail`), UNIQUE (`password`)) ENGINE = InnoDB;")

             $crear_tabla=mysql_query($tabla,$conexion) or die(mysql_error());
             if(!$crear_tabla){
                 echo 'Error al crear la table en la base de datos';
                 }else{
                     echo 'La tabla se creo correctamente'
                     ?> <a href="index.php">Volver a la pagina principal</a> <?php;
                 }
        }
?>
