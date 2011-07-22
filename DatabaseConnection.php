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
    private static $dbconnection = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance() {
        if($this->dbconnection = null) {
            $this->dbconnection = new DatabaseConnection();
        }
        
        return $this->dbconnection;
    }
}

?>
