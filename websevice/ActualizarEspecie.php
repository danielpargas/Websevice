<?php


//Script PHP para actualizar una especie en la base de datos
//Recibe idespecie (idespecie), nombre de la especie (nombre)
//Imprime en Formato Json
//  Estatus 0: Operacion Incorrecta 1: Operacion Correcta
//  Mensaje : Justifica el Estatus


$mensaje = array();
//Se inicializa Bandera de Error
$error = TRUE;
//Comprueba si el Script es llamado por un Metodo POST
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Se incluye la Clase para Validar Datos
    require_once "../utilidades/Validaciones.php";
//Se comprueba si las Variables estan definidas, caso contrario se asigna NULL
    $idespecie = isset($_POST["idespecie"]) ? Validar::filtrar_texto($_POST["idespecie"]) : NULL;
    $nombre = isset($_POST["nombre"]) ? Validar::filtrar_texto($_POST["nombre"]) : NULL;
    //$idespecie=1;
   // if (!is_null($idespecie) && !is_null($idestatususuario) && !is_null($nombre) && !is_null($fecha)&& !is_null($comentario)) {

     //   if (!Validar::esta_vacio($idespecie) && !Validar::esta_vacio($idestatususuario) && !Validar::esta_vacio($nombre) && !Validar::esta_vacio($fecha) && !Validar::esta_vacio($comentario)) {
//Clase con los metodos Genericos para el CRUB
            require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
            $modelo = new Crud();
//Se inicializan los atributos para el Insert            
            //Tabla a la que se le van a insertar los datos
            $modelo->setUpdate("especie");
            //Columna a la que se le insertaran los datos
            $modelo->set("nombre='$nombre'");
            
            $modelo->setCondition("idespecie=$idespecie");

            if ($modelo->Update()) {
                $error = FALSE;
            }
  //      }
  //  }
//}

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

