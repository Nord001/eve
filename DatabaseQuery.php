<?php
/**
 * Project: EVE Online Information System Project
 * 
 * Title: DatabaseQuery.php
 * 
 * Author: Andy Lo
 * E-Mail: andy.lo@gmx.com
 */

class DatabaseQuery {
    private $_db_connection;
    private $_query;
    
    public function __construct()
    {
        // Sets up and returns a PDO database connection object.
        Singleton::setClass(DatabaseConnection);
        $this->_db_connection = Singleton::getInstance()->getConnection();
    }
    
    public function __destruct()
    {
        $this->_db_connection->closeConnection();
    }
    
    public function select($p_fetch_columns = "", $p_fetch_tables = "",
        $p_fetch_where = "") {
        // Constructs query.
        $this->_query = 'SELECT ' . implode(", ", $p_fetch_columns) .
            ' FROM ' . implode(' INNER JOIN ', $p_fetch_tables);
        /* Adds where conditions to query if they exist.  Implodes by array keys
         * instead of array values, so you'll be forced to use WHERE conditions
         * where the variables are equal to bound variables with the same names
         * (i.e. username = :username, item = :item, or id = :id).
         * 
         * This was done in order to reduce the complexity of the arrays I would
         * have to process.
         */
        if(!empty($p_fetch_where)) {
            $this->_query .= ' WHERE ' . key($p_fetch_where) . " = :" .
                implode(", " . key($p_fetch_where) . " = :",
                array_keys($p_fetch_where));
        }
      
        if(!($t_stmt = $this->_db_connection->prepare($this->_query))) {
            echo 'Failed to prepare statement.';
            exit();
        } else {
            // Binds column select parameters to the query.
            /*
            for($i = 0; $i < count($p_fetch_columns); $i++) {
                $t_stmt->bindParam(":$p_fetch_columns[$i]", $p_fetch_columns[$i]);
            }
            
            // Binds table select parameters to the query.
            for($i = 0; $i < count($p_fetch_tables); $i++) {
                $t_stmt->bindParam(":$p_fetch_tables[$i]", $p_fetch_tables[$i]);
            }*/
 
            // Binds where condition select parameters to the query.
            $p_fetch_where_keys = array_keys($p_fetch_where);
            
            for($i = 0; $i < count($p_fetch_where); $i++) {
                $t_stmt->bindParam(":$p_fetch_where_keys[$i]",
                    $p_fetch_where[$p_fetch_where_keys[$i]]);
            }

            
            // Executes the query and buffers the results.
            try {
                $t_stmt->execute();
            } catch(PDOException $e) {
                echo 'Query failed: ' . $e->getMessage();
            }
        
            // Fetches query results.
            if(!($t_result = $t_stmt->fetchAll(PDO::FETCH_ASSOC))) {
                $t_result = false;
            }
        }
        
        return $t_result;
    }
        
    public function insert() {
        
    }
}
?>
