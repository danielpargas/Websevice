<?php


$mensaje = array();
$error = TRUE;

require_once "../utilidades/Validaciones.php";

require_once '../modelo/Crud.php';

$modelo = new Crud();

$modelo->setSelect("*");

$modelo->setFrom("donacion");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idusuario = (isset($_POST["idusuario"])) ? $_POST["idusuario"] : NULL;   

    if (!is_null($idusuario)) {
        $modelo->setCondition("idusuario = $idusuario");
    }    
}

$datos = array();

if ($modelo->Read() && !empty($modelo->getRows())) {
    $filas = $modelo->getRows();

    foreach ($filas as $valor) {

        $dato = array();

        //iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($input));

        $dato["iddonacion"] = $valor["iddonacion"];
        $dato["idusuario"] = $valor["idusuario"];
        $dato["idstatusdonacion"] = $valor["idstatusdonacion"];
        $dato["fecha"] = $valor["fecha"];
        $dato["nreferencia"] = $valor["nreferencia"];
        $dato["monto"] = $valor["monto"];
        
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
