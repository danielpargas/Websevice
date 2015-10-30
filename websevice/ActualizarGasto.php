<?php

//Script PHP para insertar un gasto en la base de datos
//Recibe id del gasto (idgasto), id del animal (idanimal), fecha del gasto (fecha), monto del gasto (comentario)
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
    $idgasto = isset($_POST["idgasto"]) ? Validar::filtrar_texto($_POST["idgasto"]) : NULL;
    $idanimal= isset($_POST["idanimal"]) ? Validar::filtrar_texto($_POST["idanimal"]) : NULL;
    $fecha = isset($_POST["fecha"]) ? Validar::filtrar_texto($_POST["fecha"]) : NULL;
    $monto = isset($_POST["monto"]) ? Validar::filtrar_texto($_POST["monto"]) : NULL;
//    $idgasto = isset($_POST["idgasto"]) ? 
//    $idanimal= isset($_POST["idanimal"]) ? Validar::filtrar_texto($_POST["idanimal"]) : NULL;
//    $fecha = isset($_POST["fecha"]) ? Validar::filtrar_texto($_POST["fecha"]) : NULL;
//    $monto = isset($_POST["monto"]) ? : NULL;

//    if (!is_null($idgasto) && !Validar::esta_vacio($idgasto)) {
    //Clase con los metodos Genericos para el CRUD
      require_once '../modelo/Crud.php';
      //Se instancia un objeto de tipo CRUB
      $modelo = new Crud();
      //Se inicializan los atributos para el Insert            
      //Tabla a la que se le van a insertar los datos
      $modelo->setUpdate("gasto");
      //Columna a la que se le insertaran los datos
      $modelo->setSet("idanimal='$idanimal',fecha='$fecha',monto='$monto'");
      
      $modelo->setCondition("idgasto=$idgasto");
      
      if ($modelo->Create()) {
        $error = FALSE;
      }
//    }
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
