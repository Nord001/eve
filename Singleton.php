<?php

/**
 * EVE Online Information System Project
 * 
 * @author Andy Lo <andy.lo@gmx.com>
 * 
 * @copyright 2012 Andy Lo
 * @license GNU General Public License, version 3
 * 
 * Copyright (C) 2012 Andy Lo
 *  
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * A configurable general lazy loading singleton pattern that may be implemented
 * with any class.
 * 
 * An example for how to use the Singleton class.
 * <code>
 * // Set the class that you want to use the singleton pattern for.
 * Singleton::setClass(Foo);
 * // Get the singleton instance.
 * $instance = Singleton::getInstance();
 * </code>
 */
class Singleton {
    private static $_instance = null;
    private static $_class = null;
    
    private function __construct() {}
    
    /**
     * Mutator. Set the class that you want to use the singleton pattern for.
     * 
     * @param string p_className The name of the class you want to be a singleton.
     *
     * @see getInstance
     */
    public static function setClass($p_className) {
        Singleton::$_class = $p_className;
    }

    /**
     * Accessor. Gets the name of the class that set as a singleton.
     */
    public static function getClass() {
        return Singleton::$_class;
    }
    
    /**
     * Accessor. Creates the instance of the singleton if it does not already
     * exist and returns the instance of the singleton.
     * 
     * @return Object Returns an object of the class the Singleton was set to.
     */
    public static function getInstance() {
        if(Singleton::$_instance == null) {
            Singleton::$_instance = new Singleton::$_class;
        }
        
        return Singleton::$_instance;
    }
}

?>
