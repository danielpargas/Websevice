<?php

final class Validar {

    public function __construct() {
        
    }

    /**
     * 
     * Funcion para validar correos
     * Recibe:
     *  una Cadena de Texto
     * Retorna:
     *  Una cadena de texto con el correo filtrado
     *  False si el correo no es valido
     * 
     * @param type $correo
     * @return type
     */
    public static function validar_correo($correo) {
        return filter_var($correo, FILTER_VALIDATE_EMAIL);
    }

    /**
     * 
     * @param type $texto
     * @return type
     */
    public static function validar_Clave($texto) {
        $resultado = preg_match("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $texto);
        return $resultado;
    }

    /**
     * 
     * @param type $texto
     * @return type
     */
    public static function filtrar_texto($texto) {
        $texto = trim($texto);
        $texto = stripslashes($texto);
        $texto = htmlspecialchars($texto);
        return $texto;
    }

    /**
     * 
     * @param type $texto
     * @return type
     */
    public static function esta_vacio($texto) {
        return empty($texto) || preg_match("/^\s+$/", $texto);
    }

    /**
     * 
     * @param type $texto
     * @return type
     */
    public static function caracteres_esp($texto) {
        return preg_match("/\W/", $texto);
    }

    /**
     * 
     * @param type $texto
     * @param type $requerido
     * @return type
     */
    public static function es_numero($texto, $requerido = false) {
        if ($requerido) {
            return preg_match("/^\d+$/", $texto);
        } else {
            return preg_match("/^\d*$/", $texto);
        }
    }

    /**
     * 
     * @param type $texto
     * @return type
     */
    public static function parser_utf8($texto) {

        return utf8_decode(iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($texto)));
    }

}
