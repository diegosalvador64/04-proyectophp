<?php

if (isset($_POST)) {
    //Cargar la conexión a la BBDD
    require_once 'includes/conexion.php';
    
    //Iniciar sesión si no existiese (en la include conexión, se inicia
    if (!isset($_SESSION)) {
        session_start();
    }
   /* if (isset($_POST['nombre'])){
         $nombre = $_POST['nombre'];
    } else {
        $nombre=false;
    }*/
    //todo esto es sustituido por la siguiente
    //expresión de operadores ternarios
    //mysqli_real_escape_string es una función que hace que si metemos comillas o caracteres
    //de este tipo en el formulario, los interprete como tales y no dé error en el acceso a BBDD
    //Hay que pasárselo con conexiòn a bbdd, es decir, en este caso, con $db, que está
    //en la include conexion
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ?  mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['email']) ?  mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ?  mysqli_real_escape_string($db, $_POST['password']) : false;

    //Array de errores
    
    $errores = array();
    
    //Validar los datos antes de guardar en BBDD
    //Validamos que el nombre no esté vacío, no sea un número y que no tenga números
    if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
        $nombre_validado = true;
    } else {
        $nombre_validado = false;
        $errores['nombre'] = "El nombre no es válido";
    }
    //Validamos que apellidos no esté vacío, no sea un número y que no tenga números
    if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){
        $apellido_validado = true;
    } else {
        $apellido_validado = false;
        $errores['apellidos'] = "Los apellidos no son válidos";
    }
    
    //Validamos que email no esté vacío, y sea un email válido, para lo cual se usa esa función
    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_validado = true;
    } else {
        $email_validado = false;
        $errores['email'] = "El email no es válido";
    }
    
    //Validamos que password no esté vacío
    if(!empty($password)){
        $password_validado = true;
    } else {
        $password_validado = false;
        $errores['password'] = "La password está vacía";
    }
    //Comprobar que el array de errores está vacío para poder insertar un registro en la bbdd
    
    $guardar_usuario = false;
    if(count($errores)==0){
       //Insertar usuario en la tabla correspondiente 
       $guardar_usuario = true;
       //cifrar la contraseña para guardarla cifrada en la bbdd
       //para que se guarde de forma segura
       $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]); //cost cifra el coste de las pasadas de seguridad
       
       //INSERTAR USUARIO EN LA TABLA USUARIOS DE LA bbdd
       $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_segura', CURDATE());";
       $guardar = mysqli_query($db, $sql);
       
       /*var_dump(mysqli_error($db));
       die();*/
       
       if ($guardar) {
           $_SESSION['completado'] = "El registro se ha completado con éxito";
       } else {
           $_SESSION['errores']['general'] = "Error al guardar el usuario";
       }
       
    } else {
        $_SESSION['errores'] = $errores;
        
    }
}
header('Location: index.php');

