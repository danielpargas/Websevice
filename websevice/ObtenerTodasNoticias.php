<?php


/*
 * Script PHP para obtener toda la tabla de noticias en la base de datos
 * Recibe idnoticia
 * Imprime Formato Json
 * estatus 0: Operacion Incorrecta 1: Operacion Correcta
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
//Se instancia un objeto de tipo CRUD
    $modelo = new Crud();
//Se inicializan los atributos para el Select            
    //Columnas que se van a obtener 
    $modelo->setSelect("*");
    //Tabla de donde se van a obtener los datos
    $modelo->setFrom("noticias");
    //Condicion que establece que para obtener el tipo usuario que corresponde a un tipo usuario
    //$modelo->setCondition("idanimal = $idanimal");
    
   if($_SERVER["REQUEST_METHOD"] == "POST"){
                        
        $idtiponoticia = (isset($_POST["idtiponoticia"])) ?  $_POST["idtiponoticia"] : NULL;
        $idusuario = (isset($_POST["idusuario"])) ?  $_POST["idusuario"] : NULL;                
                                
                if(!is_null($idtiponoticia) && !is_null($idusuario)){
                    $modelo->setCondition("idtiponoticia = $idtiponoticia and  idusuario = $idusuario");
                }elseif (!is_null($idtiponoticia)){
                    $modelo->setCondition("idtiponoticia = $idtiponoticia");
                }elseif(!is_null($idusuario)){
                    $modelo->setCondition("idusuario = $idusuario");
                }                        
    }

    $datos = array();
    
        if ($modelo->Read() && !empty($modelo->getRows())) {
            $filas=$modelo->getRows();

            //Tiene idnoticia, idtiponoticia, idusuario, fecha, hora, titulo, descripcion, resumen            
            foreach($filas as $valor){
                
                $dato = array();
                                
                //iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($input));
                
                $dato["idnoticia"] = $valor["idnoticia"];
                $dato["idtiponoticia"] = $valor["idtiponoticia"];
                $dato["idusuario"] = $valor["idusuario"];
                $dato["fecha"] = $valor["fecha"];
                $dato["hora"] = $valor["hora"];
                $dato["titulo"] = $valor["titulo"];
                $dato["descripcion"] = $valor["descripcion"];
                $dato["resumen"] = $valor["resumen"];
                
                array_push($datos, $dato);
            }
                
                $error = FALSE;
        }
//Si existe un error el estatus es 0

if ($error) {
    $mensaje["estatus"] = 0;
    $mensaje["mensaje"] = "Ocurrio un error al Obtener noticias";
} else {
//Caso contrario es 1    
    $mensaje["estatus"] = 1;
    $mensaje["mensaje"] = "Noticias Obtenidas con Exito";
    
    
    $noticias["items"] = array();
    $noticias["items"] = $datos;
        
    echo json_encode($noticias);
}
//Se usa la funcion json_encode para obtener el formato json del array    
    //array_push($datos, $mensaje);
   
    
    






