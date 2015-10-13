<?php

/*
 * Clase para el manejo de Webservice mediante CURL
 */

class ConexionCurl {

//Referencia CURL
    private $ch;
//Direccion del WebService   
    private $url;
//Parametros a enviar    
    private $parametros;
//Resultado Obtenido    
    private $resultado;
//Tiempo maximo de duracion de una peticion HTTP
    private $maximoTiempo = 120;

    function __construct() {
        
    }

    /*
     * Metodo que preinicializa la Cabezera de la peticion Http
     */

    function iniciar() {

        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_POST, true);

        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->maximoTiempo);

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($this->ch, CURLOPT_URL, $this->url);

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->parametros);
    }

    /*
     * Realiza la peticion http y obtiene el resultado de esta
     */

    function realizarPeticion() {
//Inicializamos la conexion y la cabezera
        $this->iniciar();
//Se Obtiene el resultado
        $this->resultado = curl_exec($this->ch);
//Se reinicia la Variable Parametros y se Cierra la Conexion
        $this->terminar();
        
        return $this->resultado;
    }

    /*
     * Añade 1 parametro a la cadena de parametros
     */
    function addParametro($clave, $valor) {
        if ($this->parametros != "") {
            $this->parametros .= "&$clave=$valor";
        } else {
            $this->parametros = "$clave=$valor";
        }
    }

    /*
     * Finaliza el servidor CURL
     */

    function terminar() {
        $this->parametros = "";
        curl_close($this->ch);
    }

    /*
     * Realiza un Parse de la peticion en Formato Json a un array asociativo
     */

    function getArray() {
        return json_decode($this->resultado, true);        
    }

    function getUrl() {
        return $this->url;
    }

    function getParametros() {
        return $this->parametros;
    }

    function getResultado() {
        return $this->resultado;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setParametros($parametros) {
        $this->parametros = $parametros;
    }

    function getMaximoTiempo() {
        return $this->maximoTiempo;
    }

    function setMaximoTiempo($maximoTiempo) {
        $this->maximoTiempo = $maximoTiempo;
    }

}
