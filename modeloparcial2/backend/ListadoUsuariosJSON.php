<?php

    /* ListadoUsuariosJSON.php: (GET) Se mostrará el listado de todos los usuarios en formato JSON.  */
    require_once("./clases/usuario.php");

    $arrayUsuariosJson=Usuario::TraerTodosJSON();


    if(isset($arrayUsuariosJson))
    {
        foreach ($arrayUsuariosJson as $usuario) 
        {
            echo json_encode($usuario);
            echo "<br>";
            
        }
    
    }


?>