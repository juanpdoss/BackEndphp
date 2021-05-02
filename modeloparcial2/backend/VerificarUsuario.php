<?php
    /*
        VerificarUsuario.php: (POST) Se recibe el parámetro usuario_json (correo y clave, en formato de cadena 
        JSON) y se invoca al método TraerUno. 
       Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
    */
     
    require_once("./clases/usuario.php");


    $usuarioJson=isset($_POST["usuario_json"])? $_POST["usuario_json"]:null;

    $json=json_decode($usuarioJson);
    $resultado=Usuario::TraerUno($json);


    echo json_encode($resultado);


?>