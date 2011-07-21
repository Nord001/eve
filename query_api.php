<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$t_adodb_path = '';

include($t_adodb_path . 'adodb.inc.php');


/**
 * Description of query_api
 *
 * @author loandy
 */
class c_Query_API {
    private $m_connection;
    private $m_query;
    
    function __construct($p_host, $p_username, $p_password, $p_database)
    {
        $this->m_connection = NewADOConnection('mysql');
        $this->m_connection->Connect($p_host, $p_username, $p_password,
            $p_database);
    }
    
    # Destructor
    function __destruct()
    {
        $this->m_connection->close();
    }
    
    function select($p_fetch_columns, $p_fetch_table) {
        // Sanitize input.
        $c_fetch_columns = $this->m_connection->real_escape_string(
            implode(", ", $p_fetch_columns));
        $c_fetch_tables = $this->m_connection->real_escape_string(
            implode(", ", $p_fetch_tables));
        
        // Write query.
        $this->m_query = 'SELECT ' . $c_fetch_columns . ' FROM ' .
            implode(' INNER JOIN ', $p_fetch_table);
        
        // Perform query.
        $t_result = $this->m_connection->query($m_query);
        
        return $t_result;
    }
    
    function insert() {
        
    }
}

?>
