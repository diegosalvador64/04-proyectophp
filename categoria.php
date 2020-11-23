<?php require_once 'includes/conexion.php';?> 
<?php require_once 'includes/helpers.php';?>  
<?php
 //Hacemos esto aquí para comprobar que existan categorías. Si no, 
 //redireccionar a la página index
    $categoria_actual = conseguirCategoria($db, $_GET['id']);
    if (!isset($categoria_actual['id'])) {
        header("Location: index.php");
    }         
?>

<?php require_once 'includes/cabecera.php';?>     
       
<!--BARRA LATERAL --> 
<?php require_once 'includes/lateral.php';?>
       <!--CAJA PRINCIPAL --> 
         <div id="principal">
            
             <h1>Entradas de <?=$categoria_actual['nombre']?></h1>
             
             <?php 
                //Utilizamos la misma función de helpers aquí y en index 
                //para obtener las 4 últimas entradas o todas, según el parámetro 
                //que le metemos a la función. Como aquí solo metemos como 
                //parámetro $db, en este caso obtenemos todas las entradas
                $entradas = conseguirEntradasCategoria($db, $categoria_actual['id']);
                if(!empty($entradas) && mysqli_num_rows($entradas) >= 1):
                    while ($entrada= mysqli_fetch_assoc($entradas)):
              ?>
                     <article class="entrada">
                        <a href="entrada.php?id=<?=$entrada['id']?>">
                        <h2><?=$entrada['titulo']?></h2>
                        <span class="fecha"><?=$entrada['categoria'].' | '.$entrada['fecha'] ?></span>
                        <p>
                            <?=substr($entrada['descripcion'], 0, 180)."..."?>  
                        </p>
                        </a>
                    </article>
            
            <?php
                    endwhile; 
                    
                else:
            ?>
             <div class="alerta">No hay entradas en esta categoría</div>
            <?php 
                endif;
            ?> 
        </div> <!--Fin contenedor principal -->
       
       <?php require_once 'includes/pie.php'?>


