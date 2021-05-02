<?php

    /*Empleado.php. Crear, en ./backend/clases, la clase Empleado (hereda de Usuario) y posee atributos públicos 
    (foto y sueldo). Implementa la interface ICRUD*/
    require_once("usuario.php");
    require_once("ICRUD.php");
    class Empleado extends Usuario implements ICRUD 
    {



        public $foto;
        public $sueldo;

        public function __construct($id=0,$nombre="",$correo="",$clave="",$id_perfil=0,$perfil="",$foto="",$sueldo=0)
        {
            parent::__construct($id,$nombre,$correo,$clave,$id_perfil,$perfil);
            $this->foto=$foto;
            $this->sueldo=$sueldo;
                 
        }


        /*
        TraerTodos (de clase): retorna un array de objetos de tipo Empleado, recuperados de la base de datos (con la 
        descripción del perfil correspondiente y su foto).
        */
        public static function TraerTodos()
        {
            $stringCon="mysql:host=localhost;dbname=usuarios_test;charset=utf8";
            $user="root";
            $password="";
            $arrayEmpleados=[];

            try 
            {
                $conexionBd=new PDO($stringCon,$user,$password);
                $query=$conexionBd->prepare("SELECT empleados.id, empleados.nombre, empleados.clave, empleados.correo, empleados.foto, perfiles.descripcion, empleados.sueldo FROM empleados INNER JOIN perfiles ON empleados.id_perfil=perfiles.id");


                $query->execute();

                $resultado=$query->fetchAll();
               
                foreach ($resultado as $aux) 
                {
                    
                    $empleado=new Empleado();
                    $empleado->nombre=$aux["nombre"];
                    $empleado->correo=$aux["correo"];
                    $empleado->sueldo=$aux["sueldo"];
                    $empleado->clave=$aux["clave"];
                    $empleado->perfil=$aux["descripcion"];
                    $empleado->id=$aux["id"];
                    $empleado->foto=$aux["foto"];

                    array_push($arrayEmpleados,$empleado);
                }

                

            } catch (PDOexception $th)
            {
                          
                echo $th->getMessage();
            }


            return $arrayEmpleados;

        }

        
        /*Agregar (de instancia): agrega, a partir de la instancia actual, un nuevo registro en la tabla empleados
        (id,nombre, correo, clave, id_perfil, foto y sueldo), de la base de datos usuarios_test. Retorna true, si se pudo 
        agregar, false, caso contrario.
        Nota: La foto guardarla en “./backend/empleados/fotos/”, con el nombre formado por el nombre punto tipo 
        punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg).*/


        public function Agregar()
        {
            $stringCon="mysql:host=localhost;dbname=usuarios_test;charset=utf8";
            $user="root";
            $password="";
            $pudeAgregar=true;

            try 
            { 
                $conexionBD=new PDO($stringCon,$user,$password);
                $query=$conexionBD->prepare("INSERT INTO empleados (nombre,correo,clave,id_perfil,foto,sueldo) VALUES(:nombre,:correo,:clave,:id_perfil,:foto,:sueldo)");

                $query->bindValue(":nombre",$this->nombre);
                $query->bindValue(":correo",$this->correo);
                $query->bindValue(":clave",$this->clave);
                $query->bindValue(":id_perfil",$this->id_perfil);
                $query->bindValue(":foto",$this->foto);
                $query->bindValue(":sueldo",$this->sueldo);

                $query->execute();

                $resultado=$query->rowCount();

                if($resultado==0)
                {
                    $pudeAgregar=false;
                }
                
            } catch (PDOException $th)
            {
                echo $th->getMessage();
                $pudeAgregar=false;
            }


            return $pudeAgregar;
        }


        /*
        Modificar (de instancia): Modifica en la base de datos el registro coincidente con la instancia actual (comparar 
        por id). Retorna true, si se pudo modificar, false, caso contrario.
        Nota: Si la foto es pasada, guardarla en “./backend/empleados/fotos/”, con el nombre formado por el nombre
        punto tipo punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg). Caso contrario, sólo actualizar 
        el campo de la base.
        */
        public function Modificar()
        {
            $stringCon="mysql:host=localhost;dbname=usuarios_test;charset=utf8";
            $user="root";
            $password="";
            $pudeModificar=true;

            try 
            { 
                $conexionBD=new PDO($stringCon,$user,$password);
                $query=$conexionBD->prepare("UPDATE empleados SET nombre=:nombre, correo=:correo , clave=:clave , id_perfil=:id_perfil , foto=:foto ,sueldo=:sueldo WHERE id=:id");

                $query->bindValue(":nombre",$this->nombre);
                $query->bindValue(":correo",$this->correo);
                $query->bindValue(":clave",$this->clave);
                $query->bindValue(":id_perfil",$this->id_perfil);
                $query->bindValue(":foto",$this->foto);
                $query->bindValue(":sueldo",$this->sueldo);
                $query->bindValue(":id",$this->id);

                $query->execute();

                $resultado=$query->rowCount();

                if($resultado==0)
                {
                    $pudeModificar=false;
                }



                
            } catch (PDOException $th)
            {
                $pudeModificar=false;
            }

            return $pudeModificar;
        }


        /*Eliminar (de clase): elimina de la base de datos el registro coincidente con el id recibido cómo parámetro. 
        Retorna true, si se pudo eliminar, false, caso contrario.
        */

        public static function Eliminar($id)
        {
            $stringCon="mysql:host=localhost;dbname=usuarios_test;charset=utf8";
            $user="root";
            $password="";
            $pudeEliminar=true;

            try 
            {
                $conexionBD=new PDO($stringCon,$user,$password);
                
                $query=$conexionBD->prepare("DELETE from empleados WHERE id=:id");

                $query->bindParam(":id",$id);
                $query->execute();

                $resultado=$query->rowCount();

                if($resultado==0)
                {   
                    $pudeEliminar=false;    

                }
                
            }catch(PDOexception $th)
            {
                echo $th->getMessage();
                $pudeEliminar=False;

            }

            return $pudeEliminar;
        }





    }




?>