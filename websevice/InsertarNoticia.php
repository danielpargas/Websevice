<?php

//Script PHP para insertar una noticia en la base de datos
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
    //$idnoticia = isset($_POST["idnoticia"]) ? $_POST["idnoticia"] : NULL;
    //$idtiponoticia = isset($_POST["idtiponoticia"]) ? $_POST["idtiponoticia"] : NULL;
    $idusuario = isset($_POST["idusuario"]) ? $_POST["idusuario"] : NULL;
   // $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : NULL;
   // $hora = isset($_POST["hora"]) ? $_POST["hora"] : NULL;
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : NULL;
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : NULL;
  //  $resumen = isset($_POST["resumen"]) ? $_POST["resumen"] : NULL;
    $imagen = isset($_POST["imagen"]) ? $_POST["imagen"] : NULL;
//    $idanimal= isset($_POST["idanimal"]) ? Validar::filtrar_texto($_POST["idanimal"]) : NULL;
//    $fecha = isset($_POST["fecha"]) ? Validar::filtrar_texto($_POST["fecha"]) : NULL;

/*
    $imagen = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAK8AAACvAQMAAA
				   CxXBw2AAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAWVJREFUSIn
				   Nlr2Vg0AMhMUjIKQEl0Jpx3ZGKS7BIYHfzukPHevDKVolmO85mBWaWRG0Nhrf8
				   2vZMOprpe4wGMuPwMQlf3vT4/kjD64czJJUMAtUzDq3wPyX+UU9YMA7eInXbvC
				   nwKFKn6kDjDqhaawPROB2Tu7EbhKITlx554ul7sYfAr0GYKcFK7V1Jz6UMX4Ap
				   U47e3wNrO80JOOjnoTAGjvxoGknSsJeHtQ8oRyHVQ8gjZbUlMbSnIVhn9wFlkM
				   gD6McAJaaRZ1FWdhm0Dpoc1DJvITyF49p2N4Dh7n16iuemhQTm4Nj+Nwkmpqz53
				   c2HiMHrQKL2Wm0CVVMeVi2MM1BK73qxFKOPcY3SsQ+fC4wYl3aLv2WRxJ2Sc02c
				   74BJZS2PnArUA6z+P4NP9Wagk8bdVTtEOMacyjJzY3I7zRsX/oKq5fUSfnYG3ja
				   qHGEkuw6OdgkNQLP6y3kyqZ/W+9t+BeB6j/x9fcYdwAAAABJRU5ErkJggg==";
    
  */  

   // $titulo = "hola";
   // $descripcion = "prueba";            
    $idtiponoticia = 2;
    $resumen = substr($descripcion, 0, 100);
    $fecha = date("Y-n-j");
    $hora = date("g:i:s");


//    if (!is_null($idgasto) && !Validar::esta_vacio($idgasto)) {
    //Clase con los metodos Genericos para el CRUD
    require_once '../modelo/Crud.php';
    //Se instancia un objeto de tipo CRUB
    $modelo = new Crud();
    //Se inicializan los atributos para el Insert            
    //Tabla a la que se le van a insertar los datos
    $modelo->setInserInto("noticias");
    //Columna a la que se le insertaran los datos
    $modelo->setInsertColumns("idtiponoticia,idusuario,fecha,hora,titulo,descripcion,resumen");
    //Variables que se le insertaran a la colummna
    $modelo->setInsertValues("'$idtiponoticia', '$idusuario', '$fecha', '$hora', '$titulo', '$descripcion', '$resumen'");
    // $modelo->setInsertValues("'$idespecie','$idestatususuario','$nombre','$fecha','$comentario'");

    if ($modelo->Create()) {
        $modelo->setSelect("MAX(idnoticia) as nombre");
        $modelo->setFrom("noticias");
                
         
        if($modelo->Read()){            
        base64_imagen($imagen,$modelo->getRows()[0]["nombre"]);
        $error = FALSE;
        
        }
        
        
    }
//    }
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

function base64_imagen($Base64Img, $nombre) {
   // list(, $Base64Img) = explode(';', $Base64Img);
    //list(, $Base64Img) = explode(',', $Base64Img);
//Decodificamos $Base64Img codificada en base64.
    $Base64Img = base64_decode($Base64Img);
//escribimos la información obtenida en un archivo llamado 
//unodepiera.png para que se cree la imagen correctamente
    file_put_contents('../imagenes/noticia/'.$nombre.".jpg", $Base64Img);
}
