<?php

/**
 * Clase con metodos genericos para Insertar, Leer, Actualizar y Eliminar Registros en cualquier
 * tabla de la base de datos
 * @author hanyou
 */

require_once 'Conexion.php';

class Crud extends Conexion {

//Atributos Para Insertar Datos
    protected $inserInto;
    protected $insertColumns;
    protected $insertValues;
//Mensaje de Error  
    protected $mensaje;
//Atributos para lectura de Datos    
    protected $select;
    protected $from;
    protected $condition;
    protected $rows;
//Atributos para Actualizar    
    protected $update;
    protected $set;
//Atributos para Eliminar    
    protected $deleteFrom;

    function __construct() {
        parent::__construct();
    }
/**
 * 
 * @return boolean
 */
    public function Create() {
        $model = new Conexion();
        $conexion = $model->getConexion();
        $insertInto = $this->inserInto;
        $insertColumns = $this->insertColumns;
        $insertValues = $this->insertValues;

        $sql = "INSERT $insertInto ($insertColumns) VALUES ($insertValues)";
        $consulta = $conexion->prepare($sql);

        if (!$consulta) {
            $this->mensaje = "Error";
            return false;
        } else {
            $consulta->execute();
            $this->mensaje = "Regustro Creado";
            return true;
        }
    }
/**
 * 
 * @return boolean
 */
    public function Read() {

        $modelo = new Conexion();
        $conexion = $modelo->getConexion();

        $select = $this->select;
        $from = $this->from;
        $condition = $this->condition;

        if ($condition != "") {
            $condition = "WHERE " . $condition;
        }

        $sql = "SELECT $select FROM $from $condition";

        $consulta = $conexion->prepare($sql);

        if (!$consulta) {
            return false;
        }
        
        $consulta->execute();
        
        $this->rows = array();

        while ($filas = $consulta->fetch()) {
            array_push($this->rows, $filas);
        }
        return TRUE;
    }
/**
 * 
 * @return boolean
 */
    public function Update() {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $update = $this->update;
        $set = $this->set;
        $condition = $this->condition;

        if (!empty($condition)) {
            $condition = " WHERE " . $condition;
        }

        $sql = "UPDATE $update SET $set $condition";
        $consulta = $conexion->prepare($sql);

        if (!$consulta) {
            $this->mensaje = "Ha Ocurrido un Error al Actualizar el Registro";
            return false;
        } else {
            $consulta->execute();
            return true;
        }
    }
/**
 * 
 * @return boolean
 */
    public function Delete() {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $deleteFrom = $this->deleteFrom;
        $condition = $this->condition;

        if (!empty($condition)) {
            $condition = " WHERE " . $condition;
        }

        $sql = "DELETE FROM $deleteFrom $condition";
        $consulta = $conexion->prepare($sql);

        if (!$consulta) {
            $this->mensaje = "Error al eliminar registro";
            return FALSE;
        } else {
            $consulta->execute();
            $this->mensaje = "Eliminado";
            return TRUE;
        }
    }
    
    
    
    //Getter y Setter
    
    function getInserInto() {
        return $this->inserInto;
    }

    function getInsertColumns() {
        return $this->insertColumns;
    }

    function getInsertValues() {
        return $this->insertValues;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function getSelect() {
        return $this->select;
    }

    function getFrom() {
        return $this->from;
    }

    function getCondition() {
        return $this->condition;
    }

    function getRows() {
        return $this->rows;
    }

    function getUpdate() {
        return $this->update;
    }

    function getSet() {
        return $this->set;
    }

    function getDeleteFrom() {
        return $this->deleteFrom;
    }

    function setInserInto($inserInto) {
        $this->inserInto = $inserInto;
    }

    function setInsertColumns($insertColumns) {
        $this->insertColumns = $insertColumns;
    }

    function setInsertValues($insertValues) {
        $this->insertValues = $insertValues;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    function setSelect($select) {
        $this->select = $select;
    }

    function setFrom($from) {
        $this->from = $from;
    }

    function setCondition($condition) {
        $this->condition = $condition;
    }

    function setRows($rows) {
        $this->rows = $rows;
    }

    function setUpdate($update) {
        $this->update = $update;
    }

    function setSet($set) {
        $this->set = $set;
    }

    function setDeleteFrom($deleteFrom) {
        $this->deleteFrom = $deleteFrom;
    }

}
