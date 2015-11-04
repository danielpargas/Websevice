<?php

/* Script PHP para Actualizar un usuario en la base de datos
 * Recibe el idusuario, tipousuario, idstatususuario, nombre, apellido, correo,
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
    $idusuario = isset($_POST["idusuario"]) ? Validar::filtrar_texto($_POST["idusuario"]) : NULL;
    //$idtipousuario = isset($_POST["idtipousuario"]) ? Validar::filtrar_texto($_POST["idtipousuario"]) : NULL;
    //$idstatususuario = isset($_POST["idstatususuario"]) ? Validar::filtrar_texto($_POST["idstatususuario"]) : NULL;
    $nombre = isset($_POST["nombre"]) ? Validar::filtrar_texto($_POST["nombre"]) : NULL;
    $apellido = isset($_POST["apellido"]) ? Validar::filtrar_texto($_POST["apellido"]) : NULL;
    $correo = isset($_POST["correo"]) ? Validar::validar_correo($_POST["correo"]) : NULL;
    $telefono = isset($_POST["telefono"]) ? Validar::filtrar_texto($_POST["telefono"]) : NULL;
    //$clave = isset($_POST["clave"]) ? Validar::filtrar_texto($_POST["clave"]) : NULL;


    //$idusuario = 4;
    //$nombre = "Daniel";
    //$apellido = "Perez";
    //$correo = "danielperez@danielperez.com";
    //$telefono = "4114141";
    
    
    if (!is_null($nombre) && !is_null($apellido) && !is_null($correo) && !is_null($telefono) && !is_null($idusuario)) {
        if (!Validar::esta_vacio($nombre) && !Validar::esta_vacio($apellido) && !Validar::esta_vacio($telefono) && Validar::es_numero($idusuario, true)) {


//Clase con los metodos Genericos para el CRUB
            require_once '../modelo/Crud.php';
//Se instancia un objeto de tipo CRUB
            $modelo = new Crud();
            
        $modelo->setSelect("count(*) as existe");
        $modelo->setFrom("usuario");
        $modelo->setCondition("correo = '$correo' and idusuario != '$idusuario'");

        $modelo->Read();

        if ($modelo->getRows()[0]["existe"] == 0) {
//Se inicializan los atributos para el Insert            
            //Tabla a la que se le van a insertar los datos
            $modelo->setUpdate("usuario");
            //Datos que se Actualizaras
            $modelo->setSet("nombre = '$nombre', apellido = '$apellido', correo = '$correo', telefono = '$telefono'");

            $modelo->setCondition("idusuario = $idusuario");

            if ($modelo->Update()) {
                $error = FALSE;
            }
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