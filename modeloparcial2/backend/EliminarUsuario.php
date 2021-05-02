<?php
    /*EliminarUsuario.php: Si recibe el parámetro id por POST, más el parámetro accion con valor "borrar", se 
    deberá borrar el usuario (invocando al método Eliminar). 
    Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido*/

    $id=isset($_POST["id"])?$_POST["id"]:null;
    $accion=isset($_POST["accion"])?$_POST["accion"]:null;
    $resultado=new stdClass();
    $resultado->exito=true;
    $resultado->mensaje="Usuario eliminado con exito.";

    if($accion == "borrar" && $id != null)
    {
        if(!Usuario::Eliminar($id))
        {
            $resultado->exito=false;
            $resultado->mensaje="No se pudo eliminar el usuario.";
        }
    }



    echo json_encode($resultado);

?>