<?php

    /*modificarUsuario.php: Se recibirán por POST los siguientes valores: usuario_json (id, nombre, correo, clave y 
    id_perfil, en formato de cadena JSON), para modificar un usuario en la base de datos. Invocar al método     
    Modificar. 
    Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.*/

    $usuarioJson=isset($_POST["usuario_json"])?$_POST["usuario_json"]:NULL;
    $datos=json_decode($usuarioJson);
    $resultado=new stdClass();
    $resultado->mensaje="Usuario modificado con exito.";
    $resultado->exito=true;

    $usuario=new Usuario();
    $usuario->nombre=$datos->nombre;
    $usuario->id=$datos->id;
    $usuario->correo=$datos->correo;
    $usuario->clave=$datos->clave;
    $usuario->id_perfil=$datos->id_perfil;


    if(!$usuario->Modificar())
    {
        $resultado->mensaje="No se pudo modificar el usuario.";
        $resultado->exito=false;

    }


    echo json_encode($resultado);


?>