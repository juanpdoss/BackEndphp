<?php
    /*AltaEmpleado.php: Se recibirán por POST todos los valores: nombre, correo, clave, id_perfil, sueldo y foto
    para registrar un empleado en la base de datos. 
    Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.*/

    require_once("./clases/Empleado.php");
    
    $nombre=isset($_POST["nombre"])? $_POST["nombre"]:null;
    
    $correo=isset($_POST["correo"])? $_POST["correo"]:null;
    
    $clave=isset($_POST["clave"])? $_POST["clave"]:null;
    
    $id_perfil=isset($_POST["id_perfil"])? $_POST["id_perfil"]:null;
    
    $sueldo=isset($_POST["sueldo"])? $_POST["sueldo"]:null;
    
    $foto=isset($_POST["foto"])? $_POST["foto"]:null;
    
    if(isset($_FILES))
    {
        $fecha=date("his");

        $destino="./empleados/fotos/";
        $destino.=$nombre;
        $destino.=".";
        $destino.=$fecha;
        $destino.=".jpg";
        
        if(!move_uploaded_file($_FILES["foto"]["tmp_name"],$destino))
        {
            echo "Error al guardar la foto.";
        }
    
    }

    $resultado=new stdClass();
    $resultado->mensaje="Empleado registrado en la base de datos con exito";
    $resultado->exito=true;

    $empleado=new Empleado();
    $empleado->nombre=$nombre;
    $empleado->correo=$correo;
    $empleado->clave=$clave;
    $empleado->id_perfil=$id_perfil;
    $empleado->sueldo=$sueldo;
    $empleado->foto=$destino;


    if(!$empleado->Agregar())
    {
        $resultado->mensaje="No se pudo agregar el empleado en la base de datos.";+
        $resultado->exito=false;

    }

    echo json_encode($resultado);

?>