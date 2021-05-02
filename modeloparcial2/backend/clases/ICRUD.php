<?php

    /*
    TraerTodos (de clase): retorna un array de objetos de tipo Empleado, recuperados de la base de datos (con la 
    descripción del perfil correspondiente y su foto).
    Agregar (de instancia): agrega, a partir de la instancia actual, un nuevo registro en la tabla empleados
    (id,nombre, correo, clave, id_perfil, foto y sueldo), de la base de datos usuarios_test. Retorna true, si se pudo 
    agregar, false, caso contrario.
    Nota: La foto guardarla en “./backend/empleados/fotos/”, con el nombre formado por el nombre punto tipo 
    punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg). 

    Modificar (de instancia): Modifica en la base de datos el registro coincidente con la instancia actual (comparar 
    por id). Retorna true, si se pudo modificar, false, caso contrario.
    Nota: Si la foto es pasada, guardarla en “./backend/empleados/fotos/”, con el nombre formado por el nombre
    punto tipo punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg). Caso contrario, sólo actualizar 
    el campo de la base.
    Eliminar (de clase): elimina de la base de datos el registro coincidente con el id recibido cómo parámetro. 
    Retorna true, si se pudo eliminar, false, caso contrario.**/



    interface ICRUD
    {
        public static function TraerTodos();
        public function Agregar();
        public function Modificar();
        public static function Eliminar($id);



    }




?>