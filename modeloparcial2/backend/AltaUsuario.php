<?php

    /*AltaUsuario.php: Se recibe por POST el correo, la clave, el nombre y el id_perfil. Se invocará al método 
    Agregar. 
    Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */

    require_once("./clases/usuario.php");

    $correo=isset($_POST["correo"])? $_POST["correo"]:null;
    $clave=isset($_POST["clave"])? $_POST["clave"]:null;
    $nombre=isset($_POST["nombre"])? $_POST["nombre"]:null;
    $id_perfil=isset($_POST["id_perfil"])? $_POST["id_perfil"]:null;

    $usuarioNuevo=new Usuario();
    $usuarioNuevo->correo=$correo;
    $usuarioNuevo->clave=$clave;
    $usuarioNuevo->nombre=$nombre;
    $usuarioNuevo->id_perfil=$id_perfil;

    $claseRespuesta=new stdClass();
    $claseRespuesta->mensaje="Usuario agregado en la base de datos con exito.";
    $claseRespuesta->exito=true;


    if(!($usuarioNuevo->Agregar()))
    {
        $claseRespuesta->exito=false;
        $claseRespuesta->mensaje="Error al agregar el usuario en la base de datos.";

    }



    echo json_encode($claseRespuesta);

?>