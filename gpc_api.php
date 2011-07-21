<?php

/**
 * @author Andy Lo <Andy_Lo@tamu-commerce.edu>
 */

/**
 * @param string $p_variable_name Variable name to be retrieved.
 * @return mixed Value of the retrieved variable. Returns null if no variable
 *     could be found.
 * @author Andy Lo
 */
function gpc_get($p_variable_name) {
    if(isset($_POST[$p_variable_name])) {
        $t_variable_data = $_POST[$p_variable_name];
    } elseif(isset($_GET[$p_variable_name])) {
        $t_variable_data = $_GET[$p_variable_name];
    } else {
        $t_variable_data = null;
    }
    
    return $t_variable_data;
}


/**
 * @param string $p_variable_name Variable name to check existence for.
 * @return bool Existence of the variable.
 * @author Andy Lo
 */
function gpc_isset($p_variable_name) {
    if(isset($_POST[$p_variable_name]) || isset($_GET[$p_variable_name])) {
        return true;
    } else {
        return false;
    }
}
?>
