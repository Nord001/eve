<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatabaseConnection
 *
 * @author loandy
 */
class DatabaseConnection {
    private static $connection;
    
    public static function get() {
        if($connection = null) {
            $connection = new DatabaseConnection();
        }
        
        return $connection;
    }
}

?>
