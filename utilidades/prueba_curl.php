<?php

require_once './ConexionCurl.php';
require_once './UrlWebservice.php';
//Se instancia un Objeto de Tipo Servidor Curl
$ConexionHttp = new ConexionCurl();

//Url asociada al Webservice
$ConexionHttp->setUrl($url["obtenertodo"]["usuario"]);
//Parametros que seran pasado
$ConexionHttp->setParametros("");
//Se realiza la peticion
$ConexionHttp->realizarPeticion();
//Se obtiene un array con los datos
$datos = $ConexionHttp->getArray();

//Se obtienen y muestran los Datos
foreach ($datos as $dato) {

    if (!isset($dato["estatus"])) {
        echo $dato["nombre"] . ":";
        echo $dato["apellido"] . "<br>";
    } else {
        echo $dato["estatus"] . "<br>";
        echo $dato["mensaje"];
    }
}


echo "<br><h1>Otra Prueba</h1> <br>";

$ConexionHttp->setUrl($url["obtener"]["usuario"]);
$idusuario = 1;
//Formato de los Datos clave=valor&clave=valor
$ConexionHttp->setParametros("idusuario=$idusuario");
$ConexionHttp->realizarPeticion();

$usuario = $ConexionHttp->getArray();


echo "Hola Me llamo " . $usuario[0]["nombre"] . "<br>";
echo 'Y me puedes llamar a ' . $usuario[0]["telefono"] . " ;) <br>";

echo "<br><h1>Ahora Vamos a Insertar un usuario</h1> <br>";


$ConexionHttp->setUrl($url["insertar"]["usuario"]);

$ConexionHttp->addParametro("idtipousuario", 1);
$ConexionHttp->addParametro("idstatususuario", 1);
$ConexionHttp->addParametro("nombre", "Prueba2");
$ConexionHttp->addParametro("apellido", "Prueba1");
$ConexionHttp->addParametro("correo","prueba@prueba.com");
$ConexionHttp->addParametro("telefono", "3131414");
$ConexionHttp->addParametro("clave", "unaclave");

$ConexionHttp->realizarPeticion();

$respuesta = $ConexionHttp->getArray();
echo $respuesta["mensaje"];
