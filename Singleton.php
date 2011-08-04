<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Class: Singleton
 *
 * @author Andy Lo
 */
class Singleton {
    private static $instance = null;
    private static $class = null;
    
    private function __construct() {
        
    }
    
    public static function setClass($setClass) {
        Singleton::$class = $setClass;
    }
    
    public static function getClass() {
        return Singleton::$class;
    }
    
    public static function getInstance() {
        if(Singleton::$instance == null) {
            Singleton::$instance = new Singleton::$class;
        }
        
        return Singleton::$instance;
    }
}

?>
