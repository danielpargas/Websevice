<?php

/*
 * Script PHP para obtener un usuario en la base de datos
 * Recibe idusuario
 * Imprime Formato Json
 *  estatus 0: Operacion Incorrecta 1: Operacion Correcta
 *  mensaje : Justifica el Estatus
 * idtiposuario : identificador del tipo de usuario
 * idstatususuario : estatus actual del usuario (activ, inactivo).
 * nombre : Nombre que corresponde al idusuario
 * apellido : Apellido que corresponde al idusuario
 * correo : Correo que corresponde al idusuario
 * telefono : Telefono que corresponde al idusuario
 * pass : Clave que corresponde al idusuario
 */

$mensaje = array();
//Se inicializa Bandera de Error
$error = TRUE;
//Comprueba si el Script es llamado por un Metodo POST
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Se incluye la Clase para Validar Datos
    require_once "../utilidades/Validaciones.php";
//Se comprueba si las Variables estan definidas, caso contrario se asigna NULL
    $idusuario = isset($_POST["idusuario"]) ? Validar::filtrar_texto($_POST["idusuario"]) : NULL;
    
    $correo = (is_null($idusuario) && isset($_POST["correo"])) ? Validar::validar_correo($_POST["correo"]) : NULL;
    
    $idusuario = NULL;
    $correo = "dulcirechipre@gmail.com";                     
    
    if ((!is_null($idusuario) || !is_null($correo))) {
//Clase con los metodos Genericos para el CRUB
        require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
        $modelo = new Crud();
//Se inicializan los atributos para el Select            
        //Columnas que se van a obtener 
        $modelo->setSelect("*");
        //Tabla de donde se van a obtener los datos
        $modelo->setFrom("usuario");
        //Condicion que establece que para obtener el usuario
        if(!is_null($idusuario)){
            $modelo->setCondition("idusuario = $idusuario");
        }else{
            $modelo->setCondition("correo = '$correo'");
        }
        

        $datos = array();
        if ($modelo->Read()) {
            $dato = array();
            $dato["idusuario"] = $modelo->getRows()[0]["idusuario"];
            $dato["idtipousuario"] = $modelo->getRows()[0]["idtipousuario"];
            $dato["idstatususuario"] = $modelo->getRows()[0]["idstatususuario"];
            $dato["nombre"] = $modelo->getRows()[0]["nombre"];
            $dato["apellido"] = $modelo->getRows()[0]["apellido"];
            $dato["correo"] = $modelo->getRows()[0]["correo"];
            $dato["telefono"] = $modelo->getRows()[0]["telefono"];

            $error = FALSE;
        }
    }
//}
//Si existe un error el estatus es 0
if ($error) {
    $mensaje["estatus"] = 0;
    $mensaje["mensaje"] = "Ocurrio un error al Obtener el Usuario";
} else {
//Caso contrario es 1    
    $mensaje["estatus"] = 1;
    $mensaje["mensaje"] = "Usuario Obtenido con Exito";
}
//Se usa la funcion json_encode para obtener el formato json del array
array_push($datos, $dato);
array_push($datos, $mensaje);
echo json_encode($datos);
