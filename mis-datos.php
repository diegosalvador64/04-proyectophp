<?php require_once 'includes/redireccion.php';?>  
<?php require_once 'includes/cabecera.php';?>     
       
<!--BARRA LATERAL --> 
<?php require_once 'includes/lateral.php';?>

<!--CAJA PRINCIPAL --> 

<div id="principal">
    
     <?php if(isset($_SESSION['completado'])): ?>
                    <div class="alerta alerta-exito">
                        <?=$_SESSION['completado']?>
                    </div>
               <?php elseif(isset($_SESSION['errores']['general'])):?>
                    <div class="alerta alerta-error">
                        <?=$_SESSION['errores']['general']?>
                    </div>
               <?php endif; ?>
    
               <form action="actualizar-usuario.php" method="post">
                   <label for="nombre">Nombre</label> 
                   <input type="text" name="nombre" value="<?=$_SESSION['usuario']['nombre'];?>"/><br><br>
                   
                   <!-- mostrarError es una función de tratamiento de errores implementada en el archivo helpers.php -->
                   <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'nombre') : " ";?>
                   <label for="apellidos">Apellidos</label> 
                   <input type="text" name="apellidos" value="<?=$_SESSION['usuario']['apellido'];?>"/><br><br>
                   <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'apellidos') : " ";?>
                   
                   <label for="email">Email</label> 
                   <input type="email" name="email" value="<?=$_SESSION['usuario']['email'];?>"/><br><br>
                   <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'email') : " ";?>
                   
                   <input type="submit" name="submit" value="Actualizar"/>
               </form>
               <?php borrarErrores(); ?>
           </div>
</div> <!--Fin contenedor principal -->
       
<?php require_once 'includes/pie.php'?>

