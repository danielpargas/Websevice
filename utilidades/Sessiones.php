<?php

class Sesiones {

    public function __construct() {
        @session_start();
    }

    public function agregar_elemento($clave, $valor) {
        $_SESSION[$clave] = $valor;
    }

    public function get_valor($clave) {
        if (isset($_SESSION[$clave])) {
            return $_SESSION[$clave];
        } else {
            return FALSE;
        }
    }

    public function obtener_sesiones() {
        $Datos = Array();
        foreach ($_SESSION as $indice => $valor) {
            $Datos[$indice] = $valor;
        }
        return $Datos;
    }

    public function eliminar_elemento($nombre) {
        if (isset($_SESSION[$nombre])) {
            unset($_SESSION[$nombre]);
        }
    }

    public function eliminar_sesion() {
        $_SESSION = Array();
        session_destroy();
    }

}
