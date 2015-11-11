<?php

/* Script PHP para insertar un usuario en la base de datos
 * Recibe el tipousuario, idstatususuario, nombre, apellido, correo,
 * telefono, pass
 * Imprime en Formato Json
 *  Estatus 0: Operacion Incorrecta 1: Operacion Correcta
 *  Mensaje : Justifica el Estatus
 */


$mensaje = array();
//Se inicializa Bandera de Error
$error = TRUE;
//Comprueba si el Script es llamado por un Metodo POST
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Se incluye la Clase para Validar Datos
require_once "../utilidades/Validaciones.php";
//Se comprueba si las Variables estan definidas, caso contrario se asigna NULL
$idtipousuario = isset($_POST["idtipousuario"]) ? Validar::filtrar_texto($_POST["idtipousuario"]) : NULL;
$idstatususuario = isset($_POST["idstatususuario"]) ? Validar::filtrar_texto($_POST["idstatususuario"]) : NULL;
$nombre = isset($_POST["nombre"]) ? Validar::filtrar_texto($_POST["nombre"]) : NULL;
$apellido = isset($_POST["apellido"]) ? Validar::filtrar_texto($_POST["apellido"]) : NULL;
$correo = isset($_POST["correo"]) ? Validar::validar_correo($_POST["correo"]) : NULL;
$telefono = isset($_POST["telefono"]) ? Validar::filtrar_texto($_POST["telefono"]) : NULL;
$clave = isset($_POST["clave"]) ? md5(Validar::filtrar_texto($_POST["clave"])) : NULL;

if (!is_null($nombre) && !is_null($apellido) && !is_null($correo) && !is_null($telefono) && !is_null($clave) && !is_null($idtipousuario) && !is_null($idstatususuario)) {
    if (!Validar::esta_vacio($nombre) && !Validar::esta_vacio($apellido) && !Validar::esta_vacio($telefono) && !Validar::esta_vacio($clave) && Validar::es_numero($idstatususuario, true) && Validar::es_numero($idtipousuario, true)) {

//Clase con los metodos Genericos para el CRUB
        require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
        $modelo = new Crud();


        $modelo->setSelect("count(*) as existe");
        $modelo->setFrom("usuario");
        $modelo->setCondition("correo = '$correo'");

        $modelo->Read();

        if ($modelo->getRows()[0]["existe"] == 0) {

//Se inicializan los atributos para el Insert            
            //Tabla a la que se le van a insertar los datos
            $modelo->setInserInto("usuario");
            //Columna a la que se le insertaran los datos
            $modelo->setInsertColumns("idtipousuario, idstatususuario, nombre, apellido, correo, telefono, pass");
            //Valores que se le insertaran a la colummna
            $modelo->setInsertValues("'$idtipousuario','$idstatususuario','$nombre','$apellido','$correo','$telefono','$clave'");

            if ($modelo->Create()) {
                $error = FALSE;
            }
        }
    }
}
//}
//Si existe un error el estatus es 0
if ($error) {
    $mensaje["estatus"] = 0;
    $mensaje["mensaje"] = "El Usuario ya esta registrado";
} else {
//Caso contrario es 1    
    $mensaje["estatus"] = 1;
    $mensaje["mensaje"] = "Usuario Insertado con Exito";
}
//Se usa la funcion json_encode para obtener el formato json del array
echo json_encode($mensaje);

