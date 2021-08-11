<?php include_once('inc/layout/header.php');?>
<?php include('inc/funciones/funciones.php')?>


<?php 

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT); 
// echo $id;

if(!$id){
    die('No es valido');
}
?>

<pre>
    <?php // var_dump(traerContacto($id));?>
</pre>


<?php $resultado = traerContacto($id);?>

<pre>
<?php  var_dump($contacto =$resultado->fetch_assoc());?>
</pre>

<div class="contenedor-barra">
   <div class="contenedor barra">
       <a href="index.php" class="btn btnVolver">Volver</a>
       <h1>Editar Contactos</h1>
   </div>
   <!--..barra---->
</div>
<!--contenedor-barra-->

<div class="bg-amarillo contenedor sombra">

    <form action="#" id="contacto">

        <legend>Edite el contacto</legend>

        <?php include "inc/layout/formulario.php" ?>

    </form>
</div>
<!--div bg-amarillo-->


<?php include_once('inc/layout/footer.php');?>