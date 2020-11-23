<?php

function mostrarError($errores, $campo) {
    $alerta = '';
    if(isset($errores[$campo]) && !empty($campo)){
        $alerta = "<div class='alerta alerta-error'>".$errores[$campo].'</div>';
    }
    return $alerta;
}

function borrarErrores() {
    
   $borrado=false;
   
   if(isset($_SESSION['errores'])){
       $_SESSION['errores']=null;
       $borrado = true;
   }
   
   if(isset($_SESSION['errores:entrada'])){
       $_SESSION['errores_entrada']=null;
       $borrado = true;
   }
   
   if(isset($_SESSION['completado'])){
       $_SESSION['completado']=null;
       $borrado = true;
   }
   
   
   
   /*$borrado = session_unset();*///Víctor Robles le pasó como parámetro  $_SESSION['errores']
   //y no le daba warnings. A mí me daba uno de que estab recibiendo parámetros cuando no necesita ninguno.
   //$borrado = session_unset($_SESSION['errores']); Lo tenía así al principio
   //Al final este tío ha quitado el session_unset. Es que a mí me borraba todas las sesiones y 
   //cuando quería recoger la sesión del usuario me decía que no existía,
   //porque no sé que le pasa a esta versión de php que no
   //permite parámetros en el session_unset
   /*$borrado = session_unset();*/
   return $borrado;
   
}

function conseguirCategorias($conexion) {//por parámetro, $conexion es la $db 
//del include conexion, que lleva: $db = mysqli_connect($servidor, $usuario, $password, $basededatos); 
    $sql = "SELECT * FROM categorias ORDER BY id ASC;";
    $categorias = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($categorias && mysqli_num_rows($categorias)>=1) {
        $resultado = $categorias;
    }
    return $resultado;
}

function conseguirCategoria($conexion, $id) {//por parámetro, $conexion es la $db 
//del include conexion, que lleva: $db = mysqli_connect($servidor, $usuario, $password, $basededatos); 
    $sql = "SELECT * FROM categorias WHERE id = $id;";
    $categorias = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($categorias && mysqli_num_rows($categorias)>=1) {
        $resultado = mysqli_fetch_assoc($categorias);
    }
    return $resultado;
}

function conseguirUltimasEntradas($conexion){
//Lo pongo así porque el INNER JOIN no se lo ha tragado
    $sql= "SELECT e.*, c.nombre AS 'categoria' ".
          "FROM entradas e, categorias c ".
          "WHERE e.categoria_id = c.id ORDER BY e.id DESC LIMIT 4;";
    $entradas = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($entradas && mysqli_num_rows($entradas)>=1) {
        $resultado = $entradas;
    }
    return $resultado;
}
function conseguirEntradas($conexion, $limit=null, $categoria = null){
//Lo pongo así porque el INNER JOIN no se lo ha tragado
    $sql= "SELECT e.*, c.nombre AS 'categoria' ".
          "FROM entradas e, categorias c ".
          "WHERE e.categoria_id = c.id ORDER BY e.id DESC";
        
    if($limit) {
        $sql .= " LIMIT 4";
    }
    $entradas = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($entradas && mysqli_num_rows($entradas)>=1) {
        $resultado = $entradas;
    }
    return $resultado;
}

function conseguirEntradasCategoria($conexion, $categoria){
//Lo pongo así porque el INNER JOIN no se lo ha tragado
    $sql= "SELECT e.*, c.nombre AS 'categoria' ".
          "FROM entradas e, categorias c ".
          "WHERE e.categoria_id = c.id AND e.categoria_id = $categoria ORDER BY e.id DESC";
        
    $entradas = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($entradas && mysqli_num_rows($entradas)>=1) {
        $resultado = $entradas;
    }
    return $resultado;
}

function conseguirEntrada($conexion, $id) {//por parámetro, $conexion es la $db 
//del include conexion, que lleva: $db = mysqli_connect($servidor, $usuario, $password, $basededatos); 
    $sql = "SELECT e.*, c.nombre AS 'categoria', CONCAT(u.nombre, ' ', u.apellido) ".
            "AS usuario FROM entradas e, categorias c, usuarios u ".
           "WHERE e.categoria_id = c.id AND e.usuario_id = u.id AND e.id = $id";
    $entrada = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($entrada && mysqli_num_rows($entrada)>=1) {
        $resultado = mysqli_fetch_assoc($entrada);
    }
    return $resultado;
}

function buscarEntradas($conexion, $busqueda) {//por parámetro, $conexion es la $db 
//del include conexion, que lleva: $db = mysqli_connect($servidor, $usuario, $password, $basededatos); 
    
    $sql = "SELECT e.*, c.nombre AS 'categoria', CONCAT(u.nombre, ' ', u.apellido) ".
            "AS usuario FROM entradas e, categorias c, usuarios u ".
           "WHERE e.categoria_id = c.id AND e.usuario_id = u.id AND e.titulo LIKE '%$busqueda%'";
    $entrada = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($entrada && mysqli_num_rows($entrada)>=1) {
        $resultado = mysqli_fetch_assoc($entrada);
    }
   
    return $resultado;
}


