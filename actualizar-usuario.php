<?php

if (isset($_POST)) {
    //Cargar la conexión a la BBDD
    require_once 'includes/conexion.php';
    
    //Recoger los datos del formulario de actualización
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ?  mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['email']) ?  mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    
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
    
    //Comprobar que el array de errores está vacío para poder insertar un registro en la bbdd
     
    $guardar_usuario = false;
    if(count($errores)==0){
       $usuario = $_SESSION['usuario'];
       //Insertar usuario en la tabla correspondiente 
       $guardar_usuario = true;
              
       //ACTUALIZAR USUARIO EN LA TABLA USUARIOS DE LA bbdd
       //PERO ANTES HAY QUE COMPROBAR QUE EL NUEVO EMAIL NO EXISTE YA EN LA TABLA
       
       $sql = "SELECT id, email FROM usuarios WHERE email = '$email';";
       $isset_email = mysqli_query($db, $sql);
       $isset_user = mysqli_fetch_assoc($isset_email);
       
       if ($isset_user['id'] == $usuario['id'] || empty($isset_user)) {

            $sql = "UPDATE usuarios SET ".
                    "nombre = '$nombre', ".
                    "apellido = '$apellidos', ".
                    "email = '$email' ".
                    "WHERE id = ".$usuario['id'];
            $guardar = mysqli_query($db, $sql);

            if ($guardar) {
                //guardamos en las variables de sesión los nuevos valores actualizados
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['email'] = $email;

                $_SESSION['completado'] = "Tus datos se han actualizado con éxito";
            } else {
                $_SESSION['errores']['general'] = "Error al actualizar el usuario";
            }
       } else {
           $_SESSION['errores']['general'] = "El usuario ya existe";
       }
       
    } else {
        $_SESSION['errores'] = $errores;
        
    }
}
header('Location: mis-datos.php');



