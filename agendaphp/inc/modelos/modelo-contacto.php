<?php 


//include_once('inc/layout/header.php'); 


if( $_POST['accion'] == "crear"){

    require_once('../funciones/db.php');

    //validar entradas
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING); 
    $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);



    try{

        $stmt = $conn->prepare("INSERT INTO contactos (nombre, empresa, telefono) VALUES (?,?,?) ");
        $stmt->bind_param('sss', $nombre, $empresa, $telefono);
        $stmt->execute();

        if($stmt->affected_rows == 1){
            $respuesta = array(
                'respuesta' => 'correcto',
                
                'datos' => array (
                    'nombre' => $nombre,
                    'empresa' => $empresa,
                    'telefono' => $telefono,
                    'id_insertado' => $stmt->insert_id
                )
            );
        }


        $stmt->close();
        $conn->close();

    } catch(Exception $e){
        $respuesta = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);

} 

if($_GET['accion'] == 'borrar'){

    require_once('../funciones/db.php');

    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT); 

    try{
        
        $stmt = $conn->prepare("DELETE FROM contactos WHERE id = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if($stmt->affected_rows == 1){
           $respuesta = array(
               'respuesta' => 'correcto'
           );
             

        }
        $stmt->close();
        $conn->close();

    } catch(Exception $e){

          $respuesta = array(
              'error' => $e->getMessage()
          );


    }


 
 
    echo json_encode($respuesta);
  
}


if($_POST['accion'] == 'editar'){

    require('../funciones/db.php');

    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING); 
    $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
    $id = filter_var($_POST['idRegistro'], FILTER_SANITIZE_NUMBER_INT); 


    try{

        $stmt = $conn->prepare('UPDATE contactos SET nombre = ?, empresa = ?, telefono = ? WHERE id= ?');
        $stmt->bind_param("sssi", $nombre, $empresa, $telefono, $id);
        $stmt->execute();


        if($stmt->affected_rows <= 1){
                       $respuesta = array(
                'respuesta' => 'correcto'
            ); 
        }

        


        $stmt->close();
        $conn->close();

        


    }
    catch(Exception $e){
        $respuesta = array(
          'error' => $e->getMessage()  
        );
    }





    echo json_encode($respuesta);

}



//include_once('inc/layout/footer.php'); 


?>