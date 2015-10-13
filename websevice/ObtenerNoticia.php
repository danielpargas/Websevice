<?php

/*
 * Script PHP para obtener una noticia de la base de datos
 * Recibe idnoticia, idtiponoticia, idusuario, fecha, hora, titulo, descripcion, resumen
 * Imprime Formato Json
 *  estatus 0: Operacion Incorrecta 1: Operacion Correcta
 *  mensaje : Justifica el Estatus
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
$idgasto = isset($_POST["idnoticia"]) ? Validar::filtrar_texto($_POST["idnoticia"]) : NULL;
if (!is_null($idnoticia) && Validar::es_numero($idnoticia, true)) {
//Clase con los metodos Genericos para el CRUB
    require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
    $modelo = new Crud();
//Se inicializan los atributos para el Select            
    //Columnas que se van a obtener 
    $modelo->setSelect("*");
    //Tabla de donde se van a obtener los datos
    $modelo->setFrom("noticias");
    //Condicion que establece que para obtener el tipo gatso que corresponde a un animal
    $modelo->setCondition("idnoticia = $idnoticia");

    $datos = array();
    if ($modelo->Read()) {
        $dato = array();
        $dato["idtiponoticia"] = $modelo->getRows()[0]["idtiponoticia"];
        $dato["idusuario"] = $modelo->getRows()[0]["idusuario"];
        $dato["fecha"] = $modelo->getRows()[0]["fecha"];
        $dato["hora"] = $modelo->getRows()[0]["hora"];
        $dato["titulo"] = $modelo->getRows()[0]["titulo"];
        $dato["descripcion"] = $modelo->getRows()[0]["descripcion"];
        $dato["resumen"] = $modelo->getRows()[0]["resumen"];
       
        $error = FALSE;
    }
}
}
//Si existe un error el estatus es 0
if ($error) {
    $mensaje["estatus"] = 0;
    $mensaje["mensaje"] = "Ocurrio un error al Obtener noticia";
} else {
//Caso contrario es 1    
    $mensaje["estatus"] = 1;
    $mensaje["mensaje"] = "Noticia Obtenido con Exito";
}
//Se usa la funcion json_encode para obtener el formato json del array
array_push($datos, $dato);
array_push($datos, $mensaje);
echo json_encode($datos);

