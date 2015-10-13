<?php

//Script PHP para insertar un tipo de usuario en la base de datos
//Recibe Nombre del nombre del tipo usuario
//Imprime en Formato Json
//  Estatus 0: Operacion Incorrecta 1: Operacion Correcta
//  Mensaje : Justifica el Estatus


$mensaje = array();
//Se inicializa Bandera de Error
$error = TRUE;
//Comprueba si el Script es llamado por un Metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Se incluye la Clase para Validar Datos
    require_once "../utilidades/Validaciones.php";
//Se comprueba si las Variables estan definidas, caso contrario se asigna NULL
    $nombre = isset($_POST["nombre"]) ? Validar::filtrar_texto($_POST["nombre"]) : NULL;    
    if (!is_null($nombre) && !Validar::esta_vacio($nombre)) {
//Clase con los metodos Genericos para el CRUB
        require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
        $modelo = new Crud();
//Se inicializan los atributos para el Insert            
        //Tabla a la que se le van a insertar los datos
        $modelo->setInserInto("tipousuario");
        //Columna a la que se le insertaran los datos
        $modelo->setInsertColumns("nombre");
        //Valores que se le insertaran a la colummna
        $modelo->setInsertValues("'$nombre'");
        
        if ($modelo->Create()) {
            $error = FALSE;
        }
    }
}

//Si existe un error el estatus es 0
if ($error) {
    $mensaje["estatus"] = 0;
    $mensaje["mensaje"] = "Ocurrio un error al Insertar el Usuario";
} else {
//Caso contrario es 1    
    $mensaje["estatus"] = 1;
    $mensaje["mensaje"] = "Usuario Insertado con Exito";
}
//Se usa la funcion json_encode para obtener el formato json del array
echo json_encode($mensaje);