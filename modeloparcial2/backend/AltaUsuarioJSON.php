<?php

    /*AltaUsuarioJSON.php: Se recibe por POST el correo, la clave y el nombre. Invocar al método 
    GuardarEnArchivo*/
    require_once("./clases/usuario.php");


    $correo=isset($_POST["correo"])? $_POST["correo"]:null;
    $clave=isset($_POST["clave"])? $_POST["clave"]:null;
    $nombre=isset($_POST["nombre"])? $_POST["nombre"]:null;

    $usuarioNuevo=new Usuario();
    $usuarioNuevo->correo=$correo;
    $usuarioNuevo->clave=$clave;
    $usuarioNuevo->nombre=$nombre;

    $resultado=$usuarioNuevo->GuardarEnArchivo();


    echo $resultado;


?>