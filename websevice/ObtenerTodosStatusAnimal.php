<?php

/*
 * Script PHP para obtener un tipos de animal en la base de datos
 * Recibe idanimal
 * Imprime Formato Json
 *  estatus 0: Operacion Incorrecta 1: Operacion Correcta
 *  mensaje : Justifica el Estatus
 * idespecie : identificador de la especie
 * idstatususuario : estatus actual del animal (activ, inactivo).
 * nombre : Nombre que corresponde al idanimal
 * fehca: Fecha de ingreso del animla a la institucion
 * comentario : comentarios importantes de su ingreso
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
$idstatusanimal = isset($_POST["idstatusanimal"]) ? Validar::filtrar_texto($_POST["idstatusanimal"]) : NULL;
if (!is_null($idstatusanimal) && Validar::es_numero($idstatusanimal, true)) {
//Clase con los metodos Genericos para el CRUB
    require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
    $modelo = new Crud();
//Se inicializan los atributos para el Select            
    //Columnas que se van a obtener 
    $modelo->setSelect("*");
    //Tabla de donde se van a obtener los datos
    $modelo->setFrom("statusanimal");

    $datos = array();
    if ($modelo->Read()) {
        $dato = array();
        $dato["idstatusanimal"] = $modelo->getRows()[0]["idstatusanimal"];
        $dato["nombre"] = $modelo->getRows()[0]["nombre"];

       
        $error = FALSE;
    }
}
}
//Si existe un error el estatus es 0
if ($error) {
    $mensaje["estatus"] = 0;
    $mensaje["mensaje"] = "Ocurrio un error al Obtener el status del animal";
} else {
//Caso contrario es 1    
    $mensaje["estatus"] = 1;
    $mensaje["mensaje"] = "Status del animal obtenido con Exito";
}
//Se usa la funcion json_encode para obtener el formato json del array
array_push($datos, $dato);
array_push($datos, $mensaje);
echo json_encode($datos);

