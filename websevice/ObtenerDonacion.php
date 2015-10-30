<?php


/*
 * Script PHP para obtener una Donacion en la base de datos
 * Recibe un iddonacion
 * Imprime en Formato Json
 *  estatus 0: Operacion Incorrecta 1: Operacion Correcta
 *  mensaje : Justifica el Estatus
 *  nombre : Nombre que corresponde al idtipousuario
 */

$mensaje = array();
//Se inicializa Bandera de Error
$error = TRUE;
//Comprueba si el Script es llamado por un Metodo POST
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Se incluye la Clase para Validar Datos
require_once "../utilidades/Validaciones.php";
//Se comprueba si las Variables estan definidas, caso contrario se asigna NULL
$iddonacion = isset($_POST["iddonacion"]) ? Validar::filtrar_texto($_POST["iddonacion"]) : NULL;

if (!is_null($idconsulta) && Validar::es_numero($idconsulta, true)) {
//Clase con los metodos Genericos para el CRUB
    require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
    $modelo = new Crud();
//Se inicializan los atributos para el Insert            
    //Columnas que se van a obtener 
    $modelo->setSelect("*");
    //Tabla de donde se van a obtener los datos
    $modelo->setFrom("donacion");
    //Condicion que establece que para obtener el tipo usuario que corresponde a un tipo usuario
    $modelo->setCondition("iddonacion = $idconsulta");

    $datos = array();
    if ($modelo->Read()) {
        $dato = array();
        $dato["nombre"] = $modelo->getRows()[0]["nombre"];
        $error = FALSE;
    }
}
//}
//Si existe un error el estatus es 0
if ($error) {
    $mensaje["estatus"] = 0;
    $mensaje["mensaje"] = "Ocurrio un error al Obtener el Tipo Usuario";
} else {
//Caso contrario es 1    
    $mensaje["estatus"] = 1;
    $mensaje["mensaje"] = "Tipo Usuario Obtenido con Exito";
}
//Se usa la funcion json_encode para obtener el formato json del array
array_push($datos, $dato);
array_push($datos, $mensaje);
echo json_encode($datos);