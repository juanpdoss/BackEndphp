<?php
    /*Usuario.php. Crear, en ./backend/clases, la clase Usuario con atributos públicos (id, nombre, correo, clave, 
    id_perfil y perfil) y un método de instancia ToJSON(), que retornará los datos de la instancia nombre, correo y 
    clave (en una cadena con formato JSON). 
    Agregar los siguientes métodos:
    Método de instancia GuardarEnArchivo(), que agregará al usuario en ./backend/archivos/usuarios.json. 
    Retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. 
    Método de clase TraerTodosJSON(), que retornará un array de objetos de tipo Usuario, recuperado del 
    archivo usuarios.json.
    Método de instancia Agregar(): agrega, a partir de la instancia actual, un nuevo registro en la tabla usuarios 
    (id,nombre, correo, clave e id_perfil), de la base de datos usuarios_test. Retorna true, si se pudo agregar, 
    false, caso contrario.
    Método de clase TraerTodos(): retorna un array de objetos de tipo Usuario, recuperados de la base de datos 
    (con la descripción del perfil correspondiente).
    Método de clase TraerUno($params): retorna un objeto de tipo Usuario, de acuerdo al correo y clave que ser 
    reciben en el parámetro $params */

    require_once("IBM.php");

    class Usuario implements JsonSerializable,IBM
    {
        public $id;
        public $nombre;
        public $correo;
        public $clave;
        public $id_perfil;
        public $perfil;

        public function __construct($id=-1,$nombre="",$correo="",$clave=-1,$id_perfil=0,$perfil="")
        {
            $this->id=$id;
            $this->nombre=$nombre;
            $this->correo=$correo;
            $this->clave=$clave;
            $this->id_perfil=$id_perfil;
            $this->perfil=$perfil;
            
        }

        public function jsonSerialize()
        {
            return
            [
                "nombre"=>$this->nombre,

                "clave"=>$this->clave,

                "correo"=>$this->correo

            ];
            
        }

      

        public function ToJson()
        {          
            return json_encode($this);
        }




        /*Método de instancia GuardarEnArchivo(), que agregará al usuario en ./backend/archivos/usuarios.json. 
        Retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.  */

        public function GuardarEnArchivo()
        {
            $claseRetorno=new stdClass();
            $claseRetorno->mensaje="Usuario guardado con exito.";
            $claseRetorno->exito="true";
            $arrayUsuarios=self::TraerTodosJSON();
            array_push($arrayUsuarios,$this);

            if(!file_put_contents("./archivos/usuarios.json",json_encode($arrayUsuarios,JSON_PRETTY_PRINT)))
            {
                $claseRetorno->mensaje="Error al guardar el usuario.";
                $claseRetorno->exito=false;

            }

        
           return json_encode($claseRetorno);
        }

        
        /*Método de clase TraerTodosJSON(), que retornará un array de objetos de tipo Usuario, recuperado del 
        archivo usuarios.json. */

        public static function TraerTodosJSON()
        {
            $arrayUsuarios=array();
            $stringArchivo=file_get_contents("./archivos/usuarios.json");        
            $arrayObjetos=json_decode($stringArchivo);

            if(isset($arrayObjetos))
            {
                foreach($arrayObjetos as $objeto)
                {
                    $usuario=new Usuario();
                    $usuario->nombre= $objeto->nombre;
                    $usuario->correo= $objeto->correo;
                    $usuario->clave= $objeto->clave;
                    array_push($arrayUsuarios,$usuario);
                }
            }

            return $arrayUsuarios;
        }

        /*Método de instancia Agregar(): agrega, a partir de la instancia actual, un nuevo registro en la tabla usuarios 
        (id,nombre, correo, clave e id_perfil), de la base de datos usuarios_test. Retorna true, si se pudo agregar, 
         false, caso contrario.*/

        public function Agregar()
        {
            $pudeAgregar=true;

            $stringCon="mysql:host=localhost;dbname=usuarios_test;charset=utf8";
            $user="root";
            $password="";

            try
            {
                $conexionBd=new PDO($stringCon,$user,$password);

                $query=$conexionBd->prepare("INSERT INTO usuarios (nombre,correo,clave,id_perfil)"."VALUES(:nombre,:correo,:clave,:id_perfil)");
            
                $query->bindValue(":nombre",$this->nombre);
                $query->bindValue(":correo",$this->correo);
                $query->bindValue(":clave",$this->clave);
                $query->bindValue(":id_perfil",$this->id_perfil);

                $query->execute();

                $resultado=$query->rowCount();

                if($resultado == 0)
                {
                   $pudeAgregar=false; 
                }

            }
            catch(PDOException $exception)
            {
                //echo $exception->getMessage();
                $pudeAgregar=false;
            }

            return $pudeAgregar;
        }    

        /*Método de clase TraerTodos(): retorna un array de objetos de tipo Usuario, recuperados de la base de datos 
        (con la descripción del perfil correspondiente).
        */
        public static function TraerTodos()
        {
            $arrayUsuarios=array();
            $stringCon="mysql:host=localhost;dbname=usuarios_test;charset=utf8";
            $user="root";
            $password="";

            try
            {
                $conexionBd=new PDO($stringCon,$user,$password);
                $query=$conexionBd->prepare("SELECT usuarios.id,usuarios.correo,usuarios.clave,usuarios.nombre,perfiles.descripcion FROM usuarios INNER JOIN perfiles ON usuarios.id_perfil=perfiles.id");
                
                $query->execute();

                while($registro=$query->fetch())
                {
                    $usuario= new Usuario();
                    $usuario->nombre=$registro["nombre"];
                    $usuario->clave=$registro["clave"];
                    $usuario->id=$registro["id"];
                    $usuario->perfil=$registro["descripcion"];
                    $usuario->correo=$registro["correo"];
                    array_push($arrayUsuarios,$usuario);
                }
            
            }
            catch(PDOException $exception)
            {
               
            }

            return $arrayUsuarios;
        }


        /*Método de clase TraerUno($params): retorna un objeto de tipo Usuario, de acuerdo al correo y clave que se 
        reciben en el parámetro $params.    
        */

        public static function TraerUno($params)
        {
            $usuarioQueRetorno=new Usuario();
            $correoAbuscar=$params->correo;
            $claveAbusaR=$params->clave;

            $arrayUsuarios=self::TraerTodos();

            foreach($arrayUsuarios as $usuario)
            {
                if($usuario->correo == $correoAbuscar && $usuario->clave == $claveAbusaR)
                {
                    $usuarioQueRetorno=$usuario;
                    break;
                }
            }

            return $usuarioQueRetorno;
        }

        
        /*modifica en la base de datos el registro coincidente con la instancia actual (comparar por id). 
        Retorna true, si se pudo modificar, false, caso contrario.*/


        public function Modificar() //metodo que viene de la interfaz IBM
        {
            $stringCon="mysql:host=localhost;dbname=usuarios_test;charset=utf8";
            $user="root";
            $password="";
            $pudeModificar=TRUE;

            try 
            {
                $conexionBD=new PDO($stringCon,$user,$password);

                $query=$conexionBD->prepare("UPDATE usuarios SET nombre=:nombre, correo=:correo, id_perfil=:id_perfil, clave=:clave WHERE id=:id");

                $query->bindValue(":nombre",$this->nombre);
                $query->bindValue(":correo",$this->correo);
                $query->bindValue(":id_perfil",$this->id_perfil);
                $query->bindValue(":clave",$this->clave);
                $query->bindValue(":id",$this->clave);

                $query->execute();

                $filasAfectadas=$query->rowCount();

                if($filasAfectadas == 0)
                {
                    $pudeModificar=false;
                }

                
            } catch (PDOException $th) 
            {
                //echo $th->getMessage();
                $pudeModificar=true;
            }

            
            return $pudeModificar;
        }


        
        /*liminar (estático): elimina de la base de datos el registro coincidente con el id recibido cómo parámetro. 
        Retorna true, si se pudo eliminar, false, caso contrario.*/

        public static function Eliminar($id) //metodo que viene de la interfaz IBM
        {
            $stringCon="mysql:host=localhost;dbname=usuarios_test;charset=utf8";
            $user="root";
            $password="";
            $pudeEliminar=TRUE;

            try 
            {
                $conexionBD=new PDO($stringCon,$user,$password,$pudeEliminar);
                
                $query=$conexionBD->prepare("DELETE FROM usuarios WHERE id=:id");
                $query->bindParam(":id",$id);
                $query->execute();
                $filasAfectadas=$query->rowCount();

                if($filasAfectadas == 0)
                {
                    $pudeEliminar=false;
                }

                
            } catch (PDOException $exception) 
            {
               //echo $exception->getMessage();
               $pudeEliminar=false;
            }
            return $pudeEliminar;

        }


    }



    




?>