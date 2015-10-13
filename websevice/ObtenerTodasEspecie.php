<?php


/*
 * Script PHP para obtener toda la tabla de especie en la base de datos
 * Recibe idespecie
 * Imprime Formato Json
 *  estatus 0: Operacion Incorrecta 1: Operacion Correcta
 *  mensaje : Justifica el Estatus
 * idespecie : identificador de la especie
 * nombre : Nombre que corresponde al idanimal
 * 
 */

$mensaje = array();
//Se inicializa Bandera de Error
$error = TRUE;
//Comprueba si el Script es llamado por un Metodo POST
//Se incluye la Clase para Validar Datos
require_once "../utilidades/Validaciones.php";
//Se comprueba si las Variables estan definidas, caso contrario se asigna NULL
//Clase con los metodos Genericos para el CRUB
    require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
    $modelo = new Crud();
//Se inicializan los atributos para el Select            
    //Columnas que se van a obtener 
    $modelo->setSelect("*");
    //Tabla de donde se van a obtener los datos
    $modelo->setFrom("especie");
    //Condicion que establece que para obtener el tipo usuario que corresponde a un tipo usuario
    //$modelo->setCondition("idanimal = $idanimal");

    $datos = array();
    
        if ($modelo->Read()) {
            $filas=$modelo->getRows();
            
            
            foreach($filas as $valor){
                
                $dato = array();
                $dato["idespecie"] = $valor["idespecie"];
                $dato["nombre"] = $valor["nombre"];
                
                array_push($datos, $dato);
            }
                
                $error = FALSE;
        }
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
    array_push($datos, $mensaje);
    echo json_encode($datos);






