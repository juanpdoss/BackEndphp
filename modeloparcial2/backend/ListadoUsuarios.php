<?php

    /*ListadoUsuarios.php: (GET) Se mostrará el listado completo de los usuarios, exepto la clave (obtenidos de la 
    base de datos). Invocar al método TraerTodos. 
    Si se recibe el parámetro tabla con el valor mostrar, retornará los datos en una tabla (HTML con cabecera). Si 
    el parámetro no es pasado, retornará el array de objetos con formato JSON*/

    require_once("./clases/usuario.php");

    $accion=isset($_GET["tabla"]) ? $_GET["tabla"]:"SinPasar";
    $arrayUsuarios=Usuario::TraerTodos();
    
    echo count($arrayUsuarios);
    

    switch ($accion)
    {
        case "mostrar":
            $tablaHtml="<table><tr><th>Id</th><th>Nombre</th><th>Correo</th><th>Descripcion</th></tr>";
            foreach ($arrayUsuarios as $usuario) 
            {
                $tablaHtml.="<tr><td>{$usuario->id}</td><td>{$usuario->nombre}</td><td>{$usuario->correo}</td><td>{$usuario->perfil}</td></tr>";
            }
            $tablaHtml.="</table>";

            echo $tablaHtml;
        
            break;
        
        default:
            foreach($arrayUsuarios as $usuario)
            {
                echo $usuario->ToJson();
            }
            # code...
            break;
    }







?>