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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Se incluye la Clase para Validar Datos
    require_once "../utilidades/Validaciones.php";
    //Se comprueba si las Variables estan definidas, caso contrario se asigna NULL
    $idgasto = isset($_POST["idgasto"]) ? $_POST["idgasto"] : NULL;
    $idanimal= isset($_POST["idanimal"]) ? Validar::filtrar_texto($_POST["idanimal"]) : NULL;
    $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : NULL;
    $monto = isset($_POST["monto"]) ? $_POST["monto"] : NULL;
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
      $modelo->setInserInto("gasto");
      //Columna a la que se le insertaran los datos
      $modelo->setInsertColumns("idgasto,idanimal,fecha,monto");
      //Variables que se le insertaran a la colummna
      $modelo->setInsertValues("'$idgasto','$idanimal','$fecha','$monto'");
      // $modelo->setInsertValues("'$idespecie','$idestatususuario','$nombre','$fecha','$comentario'");

      if ($modelo->Create()) {
        $error = FALSE;
      }
//    }
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
