

<!-- BARRA LATERAL -->
<aside id="sidebar">
    
    <div id="buscador" class="bloque">
               <h3>Buscar</h3>
               
               <form action="buscar.php" method="post">
                   <input type="text" name="busqueda"/><br><br>
                   <input type="submit" value="Buscar"/>
               </form>
           </div>
    
            <?php if(isset($_SESSION['usuario'])): ?>
           <div id="usuario-logueado" class="bloque">
               <h3>Bienvenido, <?=$_SESSION['usuario']['nombre'].' '.
                        $_SESSION['usuario']['apellido']; ?>
               </h3>
               <!-- botones -->
               <a href="crearentradas.php" class="boton boton-verde">Crear entradas</a>
               <a href="crearcategoria.php" class="boton">Crear categoría</a>
               <a href="mis-datos.php" class="boton boton-naranja">Mis datos</a>
               <a href="cerrar.php" class="boton boton-rojo">Cerrar sesión</a>

           </div>
           <?php endif; ?>
           <!-- Para quitar los formularios de login y registro 
           cuando el usuario esté logueado ya-->
           <?php if(!isset($_SESSION['usuario'])): ?>
           <div id="login" class="bloque">
               <h3>Identificate</h3>
               
               <?php if(isset($_SESSION['error_login'])): ?>
               <div class="alerta alerta-error">
                    <?=$_SESSION['error_login'];?>
               </div>
                <?php endif; ?>
               <form action="login.php" method="post">
                   <label for="email">Email</label> 
                   <input type="email" name="email"/><br><br>
                   <label for="password">Contraseña</label> 
                   <input type="password" name="password"/><br><br>
                   <input type="submit" value="Entrar"/>
               </form>
           </div>
           <div id="register" class="bloque">
                              
               <h3>Regístrate</h3>
               <!-- Mostrar errores -->
               <?php if(isset($_SESSION['completado'])): ?>
                    <div class="alerta alerta-exito">
                        <?=$_SESSION['completado']?>
                    </div>
               <?php elseif(isset($_SESSION['errores']['general'])):?>
                    <div class="alerta alerta-error">
                        <?=$_SESSION['errores']['general']?>
                    </div>
               <?php endif; ?>
               <form action="registro.php" method="post">
                   <label for="nombre">Nombre</label> 
                   <input type="text" name="nombre"/><br><br>
                   <!-- mostrarError es una función de tratamiento de errores implementada en el archivo helpers.php -->
                   <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'nombre') : " ";?>
                   <label for="apellidos">Apellidos</label> 
                   <input type="text" name="apellidos"/><br><br>
                   <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'apellidos') : " ";?>
                   <label for="email">Email</label> 
                   <input type="email" name="email"/><br><br>
                   <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'email') : " ";?>
                   <label for="password">Contraseña</label> 
                   <input type="password" name="password"/><br><br>
                   <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'password') : " ";?>
                   <input type="submit" name="submit" value="Registrar"/>
               </form>
               <?php borrarErrores(); ?>
           </div>
           <?php endif; ?>
 </aside>

