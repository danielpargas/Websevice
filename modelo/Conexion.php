<?php

/**
 * Clase para establecer la conexion a la base de datos
 *
 */
class Conexion {

    //Usuario de la Base de Datos
    protected $usuario = "dulcirech";
    //Clave del Usuario
    protected $clave = "dcr211091";
    //Host asociado a la Base de Datos
    protected $host = "localhost";
    //Nombre de la Base de Datos
    protected $db = "asoguau";
    
    protected $dsn = "";
    //Objeto PDO
    protected $conexion;

    public function __construct() {
        $this->dsn = "mysql:host=$this->host; dbname=$this->db; charset=UTF8";
        $this->conexion = new PDO($this->dsn, $this->usuario, $this->clave);        
    }
/**
 * 
 * @return type
 */
    function getConexion() {
        return $this->conexion;
    }

}
