<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class DatabaseConnection {
    private $t_db_dsn;
    private $t_db_username;
    private $t_db_password;

    public function __construct() {
        // Configure database connection.
        $this->t_db_dsn = 'mysql:host=localhost;dbname=eve';
        $this->t_db_username = 'eve';
        $this->t_db_password = 'B968AHTjZZK7NVDx';
        
        // Attempts to set up connection to database.
        try {
            $dbconnection = new PDO($t_db_dsn, $t_db_username, $t_db_password);
        } catch(PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        
        return $dbconnection;
    }
}

?>
