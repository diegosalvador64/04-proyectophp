<?php

//Iniciar la sesión y la conexión a la BBDD

require_once 'includes/conexion.php';

//recoger los datos del formulario

if(isset($_POST)) {
   //Borrar el posible error antiguo 
   if(isset($_SESSION['error_login'])) {
               session_unset();
           }
           
   //Recoger datos del formulario
   $email = trim($_POST['email']);
   $password = trim($_POST['password']);
   
   //Consulta para comnprobar credenciales del usuario
   $sql = "SELECT * FROM usuarios WHERE email = '$email'";
   $login = mysqli_query($db, $sql);
 
   if($login && mysqli_num_rows($login) ==1){
       $usuario = mysqli_fetch_assoc($login);
        //Comprobar la contraseña del formulario 
       //con la que se recoge de la bbdd, que estaba cifrada
       //Con la función password_verify hace esto
       $verificar =  password_verify($password, $usuario['password']);
       
       if ($verificar) { //Si la variable es true, las contraseñas coinciden
           //Utilizar una sesión para guardar los datos del usuario logueado
       
           $_SESSION['usuario'] = $usuario;
      
           //Borrar el error de la sesión que pudiese haber.
           
           
       } else {
           //Si algo falla, enviar sesión con el fallo
           $_SESSION['error_login'] = "Login incorrecto!!";
           
       }
       
       
   } else {
       //mensaje de error
       $_SESSION['error_login'] = "Login incorrecto!!";
   }

    
}

//Redirigir al index
header('Location: index.php');
