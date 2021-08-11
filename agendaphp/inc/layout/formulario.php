<div class="campos">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="" placeholder="Nombre Contacto" id="nombre"
                value="<?php echo ($contacto['nombre']) ? $contacto['nombre'] : ''; ?>">
            </div>

            <!----lo que ocurre en value es que muestra lo que haya en la variable $contacto['nombre']
            pero solo si esta existe, lo que solo ocurre cuando se esta modificando un contacto
            en caso cierto, muestra el valor, en caso falso, agrega ""---->

            <div class="campo">
                <label for="empresa">Empresa</label>
                <input type="text" name="" placeholder="Empresa Contacto" id="empresa"
                value="<?php echo ($contacto['empresa']) ? $contacto['empresa'] : ''; ?>"
                >
            </div>

            <div class="campo">
                <label for="telefono">Telefono</label>
                <input type="tel" name="" placeholder="Telefono Contacto" id="telefono"
                value="<?php echo ($contacto['telefono']) ? $contacto['telefono'] : ''; ?>"
                >
            </div>

</div>
<!--div.campos-->
        
<div class="campo enviar">

    <?php 
    $textoBtn= ($contacto['nombre']) ? 'guardar' : "crear";
    $accion = ($contacto['nombre']) ? "editar" : "crear"; 

    //estas dos variables manejan el valor para el texto del btn dependiendo de la pagina en que se encuentre el formulario
    //y hacen los mismo con la accion, que dependerá de la pagina en q se necesite el formulario
    ?>




    <input type="hidden" name="" id="accion" value="<?php echo $accion?>">
    <?php if(isset($contacto['id'])){?>
        <input type="hidden" name="" id="id" value="<?php echo $contacto['id']; ?>">
        <?php }?>
    <input type="submit" value="<?php echo $textoBtn;?>">
</div>
<!---div.enviar-->


<!---mensaje de validacion hecho por mi--->
<!-- <div class="mensaje-validacion clearfix" id="mensajeValidacion">
    <i class="far fa-times-circle"></i>
    <p>Algunos campos no están completos</p>
</div>

<div class="clearfix"></div> -->

