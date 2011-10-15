<?php

/**
 * Project: EVE Online Information System Project
 * 
 * Title: Singleton.php
 * 
 * Author: Andy Lo
 * E-Mail: andy.lo@gmx.com
 */

/**
 * Class: Singleton
 * 
 * General singleton pattern that may be implemented with any class.
 * 
 * (begin example)
 * 
 * // Set the class that you want to use the singleton pattern for.
 * Singleton::setClass(Foo);
 * // Get the singleton instance.
 * $instance = Singleton::getInstance();
 * 
 * (end example)
 * 
 */
class Singleton {
    private static $_instance = null;
    private static $_class = null;
    
    private function __construct() {}
    
    /**
     * Method: setClass
     * 
     * Mutator. Set the class that you want to use the singleton pattern for.
     * 
     * Parameters:
     *     p_className - The name of the class you want to be a singleton.
     *         
     * Returns:
     *     Nothing.
     *
     * See Also:
     *     <getInstance>
     */
    public static function setClass($p_className) {
        Singleton::$_class = $p_className;
    }

    /**
     * Method: getClass
     * 
     * Accessor. Gets the name of the class that set as a singleton.
     * 
     * Parameters:
     *     None.
     * 
     * Returns:
     *     The name of the class that set as a singleton. 
     * 
     */
    public static function getClass() {
        return Singleton::$_class;
    }
    
    /**
     * Method: getInstance
     * 
     * Accessor. Creates the instance of the singleton if it does not already
     * exist and returns the instance of the singleton.
     * 
     * Parameters:
     *     None.
     * 
     * Returns:
     *     The instance of the singleton. 
     * 
     */
    public static function getInstance() {
        if(Singleton::$_instance == null) {
            Singleton::$_instance = new Singleton::$_class;
        }
        
        return Singleton::$_instance;
    }
}

?>
