<?php

/*
 * Script PHP para obtener un tipos de gasto en la base de datos
 * Recibe idgasto
 * Imprime Formato Json
 *  estatus 0: Operacion Incorrecta 1: Operacion Correcta
 *  mensaje : Justifica el Estatus
 * idgasto : identificador del gasto
 * idanimal : identificador del animal
 * fehca: Fecha de ingreso del animla a la institucion
 * monto : monto del gasto
 * 
 */

$mensaje = array();
//Se inicializa Bandera de Error
$error = TRUE;
//Comprueba si el Script es llamado por un Metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Se incluye la Clase para Validar Datos
require_once "../utilidades/Validaciones.php";
//Se comprueba si las Variables estan definidas, caso contrario se asigna NULL
$idgasto = isset($_POST["idgasto"]) ? Validar::filtrar_texto($_POST["idgasto"]) : NULL;
if (!is_null($idgasto) && Validar::es_numero($idgasto, true)) {
//Clase con los metodos Genericos para el CRUB
    require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
    $modelo = new Crud();
//Se inicializan los atributos para el Select            
    //Columnas que se van a obtener 
    $modelo->setSelect("*");
    //Tabla de donde se van a obtener los datos
    $modelo->setFrom("gasto");
    //Condicion que establece que para obtener el tipo gatso que corresponde a un animal
    $modelo->setCondition("idgasto = $idgasto");

    $datos = array();
    if ($modelo->Read()) {
        $dato = array();
        $dato["idanimal"] = $modelo->getRows()[0]["idespecie"];
        $dato["fecha"] = $modelo->getRows()[0]["fecha"];
        $dato["monto"] = $modelo->getRows()[0]["monto"];
       
        $error = FALSE;
    }
}
}
//Si existe un error el estatus es 0
if ($error) {
    $mensaje["estatus"] = 0;
    $mensaje["mensaje"] = "Ocurrio un error al Obtener el Gasto";
} else {
//Caso contrario es 1    
    $mensaje["estatus"] = 1;
    $mensaje["mensaje"] = "Gasto Obtenido con Exito";
}
//Se usa la funcion json_encode para obtener el formato json del array
array_push($datos, $dato);
array_push($datos, $mensaje);
echo json_encode($datos);

