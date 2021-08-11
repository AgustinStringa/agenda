<?php


//credenciales de la base de datos
//constantes

define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
/****
 * en este caso se define como host localhost ya que la db esta en el mismo server que nuestros archivps y scripts
 * en casos como empresas que tienen servidores separados, es necesario introducir el ip en lugar de localhost
 * y tambien contar con los privilegios necesarios
 */
define('DB_NAME', 'agendaphp');

//msqli es una de las nuevas formas de conectarse a una base de datos
//PDO es otra. La principal diferencia es que PDO permite conectarse a más DB
//mysqli solo a mysql
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//recibe HOST, USUARIO, PASSWORD, DB --> 4 parametros obligatorios
// en caso de que no conecte, es necesario introducir el puerto 
//se encuentra en la app de mamp, en preferencias, es el puerto de mysql



//funcion que muestra si la conexion a la db es exitosa. //1 en caso de exito, nada en caso de fracaso
//echo $conn->ping();





?>