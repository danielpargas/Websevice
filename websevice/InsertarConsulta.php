<?php

//Script PHP para insertar una consulta en la base de datos
//Recibe id del animal (idanimal), id del veterinario (idveterinario), id del pasante (idpasante),
// fecha de ingreso de la consulta (fecha), observaciones de la consulta (observaciones)
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
    $idanimal= isset($_POST["idanimal"]) ? Validar::filtrar_texto($_POST["idanimal"]) : NULL;
    $idveterinario = isset($_POST["idveterinario"]) ? Validar::filtrar_texto($_POST["idveterinario"]) : NULL;
    $idpasante = isset($_POST["idpasante"]) ? Validar::filtrar_texto($_POST["idpasante"]) : NULL;
    $fecha = isset($_POST["fecha"]) ? Validar::filtrar_texto($_POST["fecha"]) : NULL;
    $observaciones = isset($_POST["observaciones"]) ? : NULL;

    if (!is_null($idanimal) && !is_null($idveterinario) && !is_null($idpasante) && !is_null($fecha) && !is_null($observaciones)) {

        if (!Validar::esta_vacio($idanimal) && !Validar::esta_vacio($idveterinario) && !Validar::esta_vacio($idpasante) && !Validar::esta_vacio($fecha) && !Validar::esta_vacio($observaciones)) {
//Clase con los metodos Genericos para el CRUB
            require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
            $modelo = new Crud();
//Se inicializan los atributos para el Insert            
            //Tabla a la que se le van a insertar los datos
            $modelo->setInserInto("consulta");
            //Columna a la que se le insertaran los datos
            $modelo->setInsertColumns("idanimal,idveterinario,idpasante,fecha,observaciones");
            //Valores que se le insertaran a la colummna
            $modelo->setInsertValues("'$idanimal','$idveterinario','$idpasante','$fecha','$observaciones'");

            if ($modelo->Create()) {
                $error = FALSE;
            }
        }
    }
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
