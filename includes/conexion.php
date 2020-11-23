<?php
//conexión a la BBDD
$servidor = 'localhost';
$usuario= 'root';
$password= '';
$basededatos= 'blog_master';
$db = mysqli_connect($servidor, $usuario, $password, $basededatos);

mysqli_query($db, "SET NAMES 'utf8'");

//Iniciar la sesión (si no existe y no se ha dado de alta en otro sitio)
// para ir recogiendo variables y guardarlas aquí
if (!isset($_SESSION)) {
    session_start();
}