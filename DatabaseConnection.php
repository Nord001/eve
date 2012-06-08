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
 * Manages the construction and destruction of a database connection.  Designed
 * for use with the singleton pattern class in Singleton.php.
 * 
 * An example of how to create and use a DatabaseConnection object.
 * 
 * <code>
 * // Create the database connection object.
 * $dbconnection = new DatabaseConnection();
 * 
 * // Set the database connection parameters.
 * $db_dsn = 'mysql:host=localhost;dbname=eve';
 * $db_username = 'eve';
 * $db_password = '********';
 * 
 * // Create the database connection.
 * $dbconnection->setConnection($db_dsn, $db_username, $db_password);
 * 
 * // Get the database connection.
 * $dbconnection = $dbconnection->getConnection();
 * </code>
 * 
 * An example using the Singleton class with the DatabaseConnection class to
 * create a unique connection.
 * 
 * <code>
 * // Set the Singleton class.
 * Singleton::setClass(DatabaseConnection);
 * $dbconnection = Singleton::getInstance()->getConnection();
 * </code>
 */
class DatabaseConnection {
    // Andy Lo: The DSN (data source name), username, and password parameters
    // are useless after establishing a connection, and so are not stored.
    private $_db_connection;
    
    /**
     * Default constructor.  Creates a connection with default arguments.
     */
    public function __construct() {
        // Andy Lo: Default connection parameters.
        $t_db_dsn = 'mysql:host=localhost;dbname=eve';
        $t_db_username = 'eve';
        $t_db_password = 'B968AHTjZZK7NVDx';
        
        $this->setConnection($t_db_dsn, $t_db_username, $t_db_password);
    }

    /**
     * This constructor initializes a connection with the given arguments.
     * 
     * @param string $t_db_dsn
     * @param string $t_db_username
     * @param string $t_db_password 
     */
    public function __construct($t_db_dsn, $t_db_username, $t_db_password) {
        $this->setConnection($t_db_dsn, $t_db_username, $t_db_password);
    }
    
    /**
     * Creates a connection using the given arguments.  Currently does not
     * support driver options.
     * 
     * @param string $p_db_dsn
     * @param string $p_db_username
     * @param string $p_db_password 
     */
    public function setConnection($p_db_dsn, $p_db_username, $p_db_password) {
        // Andy Lo: Attempts to set up connection to database.
        try {
            $this->_db_connection = new PDO($p_db_dsn, $p_db_username,
                $p_db_password);
        } catch(PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    
    /**
     * Returns a reference to the database connection.
     * 
     * @return PDO
     */
    public function getConnection() {
        return $this->_db_connection;
    }
    
    /**
     * Terminates the database connection.
     */
    public function closeConnection() {
        $this->_db_connection = null;
    }
}

?>
