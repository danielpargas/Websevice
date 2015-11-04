<?php

//Script PHP para actualizar una noticia en la base de datos
//Recibe idnoticia, idtiponoticia, idusuario, fecha, hora, titulo, descripcion, resumen
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
    $idnoticia = isset($_POST["idnoticia"]) ? $_POST["idnoticia"] : NULL;
    $idtiponoticia = isset($_POST["idtiponoticia"]) ? $_POST["idtiponoticia"] : NULL;
    $idusuario = isset($_POST["idusuario"]) ? $_POST["idusuario"] : NULL;
    $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : NULL;
    $hora = isset($_POST["hora"]) ? $_POST["hora"] : NULL;
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : NULL;
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : NULL;
    $resumen = isset($_POST["resumen"]) ? $_POST["resumen"] : NULL;
    
    
    $idtiponoticia;
    $resumen = substr($descripcion, 0, 100); 
    $fecha = date("Y-n-j");
    $hora = date("g:i:s");
    
    
//    $idgasto = isset($_POST["idgasto"]) ? 
//    $idanimal= isset($_POST["idanimal"]) ? Validar::filtrar_texto($_POST["idanimal"]) : NULL;
//    $fecha = isset($_POST["fecha"]) ? Validar::filtrar_texto($_POST["fecha"]) : NULL;
//    $monto = isset($_POST["monto"]) ? : NULL;

//    if (!is_null($idgasto) && !Validar::esta_vacio($idgasto)) {
    //Clase con los metodos Genericos para el CRUD
      require_once '../modelo/Crud.php';
      //Se instancia un objeto de tipo CRUB
      $modelo = new Crud();
      //Se inicializan los atributos para el Insert            
      //Tabla a la que se le van a insertar los datos
      $modelo->setUpdate("noticias");
      //Columna a la que se le insertaran los datos
      $modelo->setSet("idtiponoticia='$idtiponoticia',idusuario='$idusuario',fecha='$fecha',hora='$hora',titulo='$titulo',descripcion='$descripcion',resumen='$resumen'");
      
      $modelo->setCondition("idnoticia=$idnoticia");
      
      if ($modelo->Create()) {
        $error = FALSE;
      }
//    }
//}

//Si existe un error el estatus es 0
if ($error) {
    $mensaje["estatus"] = 0;
    $mensaje["mensaje"] = "Ocurrio un error al Insertar noticia";
} else {
//Caso contrario es 1    
    $mensaje["estatus"] = 1;
    $mensaje["mensaje"] = "noticia Insertada con Exito";
}
//Se usa la funcion json_encode para obtener el formato json del array
echo json_encode($mensaje);

	function base64_a_imagen($base64_string)/*Se obtiene el string y lo converte a imegen como un archivo*/
	{	
		$ifp = fopen($image, "wb");
		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
		return $output_file; 
	}
	