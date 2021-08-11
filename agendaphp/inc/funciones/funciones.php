<?php

function obtenerContactos(){
    include 'db.php';


    try{

        $consulta_sql = "SELECT * FROM contactos";

        $resultado = $conn->query($consulta_sql);

        return $resultado;

    } catch(Exception $e){
        echo $e->getMessage() . "<br>";
        return false; //con este return, cuando se llame la funcion, se puede realizar una validacion
        //por tanto, si retorna false, no realizar accion alguna
    }



}


function traerContacto($id){
    include 'db.php';

    try{
        $consulta = "SELECT * FROM contactos WHERE id=$id";
        $resultado = $conn->query($consulta);

        return $resultado;

    } catch(Exception $e){
        echo $e->getMessage();
        return false;
    }
}

// function obtenerNumeroContactos(){
//     include 'db.php';

//     try{

//         $consulta_sql = "SELECT COUNT(*) FROM contactos";

//         $resultado = $conn->query($consulta_sql);

//         return $resultado;

//     } catch(Exception $e){

//         return false;

//     }
// }


?>