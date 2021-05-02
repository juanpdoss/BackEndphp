<?php

    /*
    ListadoEmpleados.php: (GET) Se mostrará el listado completo de los empleados (obtenidos de la base de 
    datos). Invocar al método TraerTodos. 
    Si se recibe el parámetro tabla con el valor mostrar, retornará los datos en una tabla (HTML con cabecera). Si 
    el parámetro no es pasado, retornará el array de objetos con formato JSON.
    Nota: preparar la tabla (HTML) con una columna extra para que muestre la imagen de la foto (50px X 50px
    */


    require_once("./clases/Empleado.php");

    if(isset($_GET))
    {
        $accion=$_GET["tabla"];
        $arrayEmpleados=Empleado::TraerTodos();

        switch ($accion) 
        {
            case 'mostrar':
                $ahre="backend\empleados\fotos\superEmpleado.111509.jpg";
            $tablaHtml="<table><tr><th>Id</th><th>Nombre</th><th>Correo</th><th>Descripcion</th><th>Sueldo</th><th>Foto</th></tr>";
            foreach ($arrayEmpleados as $Empleado) 
            {
                $tablaHtml.="<tr><td>{$Empleado->id}</td><td>{$Empleado->nombre}</td><td>{$Empleado->correo}</td><td>{$Empleado->perfil}</td><td>{$Empleado->sueldo}</td><td><img src=\"{$ahre}\"widht=50 height=50></img></td></tr>";
            }
            $tablaHtml.="</table>";
            
            

            echo $tablaHtml;
        
                break;
            
            default:
         
            foreach ($arrayEmpleados as $Empleado) 
            {
                # code...
                echo json_encode($empleado);
            }
               
            break;
        }




    }

    











?>