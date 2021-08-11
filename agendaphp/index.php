<?php include_once('inc/layout/header.php'); ?>
<?php include 'inc/funciones/funciones.php'; ?>

<div class="contenedor-barra">
    <h1>Agenda de contactos</h1>

</div>
<!--div.contenedor-barra-->

<div class="bg-amarillo contenedor sombra">

    <form action="#" id="contacto">

        <legend>Añada un campo <span>Todos los campos son obligatorios</span></legend>

        <?php include_once "inc/layout/formulario.php" ?>
    </form> 
</div>
<!--div-->


<div class="contenedor bg-white sombra contactos">
    <div class="contenedor-contactos">
        <h2>Contactos</h2>

        <input type="text" name="" class="buscador sombra" placeholder="Buscar contactos" id="buscar">

        <?php 
        //$asd = obtenerNumeroContactos();
        //$numero = $asd->fetch_assoc();
        
        ?>

        
         
        
        <p class="total-contactos"><span> <?php// echo $numero["COUNT(*)"] ; ?></span> Contactos</p>

        <div class="contenedor-tabla">
          <table id="listado-contactos">
              <thead>
                  <tr>
                      <th>Nombre</th>
                      <th>Empresa</th>
                      <th>Teléfono</th>
                      <th>Acciones</th>
                  </tr>
              </thead>

              <tbody>
                
                <tr id="tr-placeholder">
                      <td>Nombre aqui</td>
                      <td>Empresa aqui</td>
                      <td>Telefono aqui</td>
                      <td>
                          <a href="editar_contacto.php?id=1" class="btn btnEditar">
                            <i class="fas fa-pen-square"></i>  
                        </a>

                          <button type="button" data-id="1" class="btn btnBorrar">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                      </td>
                </tr>
                <!--tr palceholder---->

                <?php 
                $contactos = obtenerContactos();
                while($contacto = $contactos->fetch_assoc()){?>

                <tr>
                    <td><?php echo $contacto['nombre']; ?></td>
                    <td><?php echo $contacto['empresa']; ?></td>
                    <td><?php echo $contacto['telefono']; ?></td>
                    <td>
                          <a href="editar_contacto.php?id=<?php echo $contacto['id'];?>" class="btn btnEditar">
                            <i class="fas fa-pen-square"></i>  
                        </a>

                          <button type="button" data-id="<?php echo $contacto['id'];?>" class="btn btnBorrar">
                            <i class="fas fa-trash-alt"></i>
                          </button>  
                      </td>
                </tr>



                <?php } ?>

                <!--while completar contactos-->
              </tbody>
          </table>
        </div>
        <!--div.contenedor-tabla-->
    </div>
    <!--div.contenedor-contactos-->
</div>
<!--div.-->

<?php include_once('inc/layout/footer.php'); ?>


