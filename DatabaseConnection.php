<?php

/**
 * Project: EVE Online Information System Project
 * 
 * Title: Database_Connection.php
 * 
 * Author: Andy Lo
 * E-Mail: andy.lo@gmx.com
 */

/**
 * Class: DatabaseConnection
 * 
 * Manages the construction and destruction of a database connection.  Designed
 * for use with the singleton pattern class in Singleton.php.
 * 
 * (begin example)
 * 
 * $dbconnection = new DatabaseConnection();
 * $db_dsn = 'mysql:host=localhost;dbname=eve';
 * $db_username = 'eve';
 * $db_password = '********';
 * // Get the singleton instance.
 * $dbconnection->setConnection($db_dsn, $db_username, $db_password);
 * $dbconnection = $dbconnection->getConnection();
 * 
 * (end example)
 * 
 * An example using the Singleton class with the DatabaseConnection class.
 * 
 * (begin example)
 * 
 * Singleton::setClass(DatabaseConnection)
 * $dbconnection = Singleton::getInstance()->getConnection();
 * 
 * (end example)
 * 
 */
class DatabaseConnection {
    private $_db_connection;
    
    public function __construct() {
        // Configure database connection.
        $t_db_dsn = 'mysql:host=localhost;dbname=eve';
        $t_db_username = 'eve';
        $t_db_password = 'B968AHTjZZK7NVDx';
        
        $this->setConnection($t_db_dsn, $t_db_username, $t_db_password);
    }
    
    public function setConnection($p_db_dsn, $p_db_username, $p_db_password) {
        // Attempts to set up connection to database.
        try {
            $this->_db_connection = new PDO($p_db_dsn, $p_db_username,
                $p_db_password);
        } catch(PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    
    public function getConnection() {
        return $this->_db_connection;
    }
    
    public function closeConnection() {
        $this->_db_connection = null;
    }
}
?>
