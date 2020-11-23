<?php
if (!isset($_SESSION)) {
    session_start();
}

//Comprobar que existe en la sesión el usuario
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
}
