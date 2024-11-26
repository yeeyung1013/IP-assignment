<?php
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 * @author Tan Chee Fung
 */

class OutputEncoding {
    public static function encodeHtml($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public static function encodeUrl($string) {
        return rawurlencode($string);
    }
}
?>