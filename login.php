<?php
/**
 * Project: EVE Online Information System Project
 * 
 * Title: login.php
 * 
 * Author: Andy Lo
 * E-Mail: andy.lo@gmx.com
 */

require_once('Singleton.php');
require_once('DatabaseConnection.php');
require_once('DatabaseQuery.php');
session_start();

/* Checks whether or not the user was directed from the correct page.
 * Also checks whether the username field is empty.
 */
if(isset($_POST['username'], $_POST['password']) && !empty($_POST['username'])) {
    $_SESSION['authenticated'] = false;

    // Gets form authentication data.
    $t_username = $_POST['username'];
    $t_password = $_POST['password'];
    
    // Clears form authentication data.
    unset($_POST['username'], $_POST['password']);

    // Set up authentication query and query parameters.
    $t_db_query = new DatabaseQuery();
    $t_fetch_columns = array(0 => "username", 1 => "password");
    $t_fetch_tables = array(0 => "eve_user_table");
    $t_fetch_where = array("username" => $t_username);

    if($t_result = $t_db_query->select($t_fetch_columns, $t_fetch_tables,
        $t_fetch_where)) {
        /* Matches the session data against the results from the database.
         * Note that currently the result set is returned by
         * PDOStatement->fetchAll.
         */
        if(!strcmp($t_result[0]['username'], $t_username)
            && !strcmp($t_result[0]['password'], md5($t_password))) {
            $_SESSION['authenticated'] = true;
            echo "Authentication success.<br />";
            header("Location: grid_edit.php");
        } else {
            header("Location: logout.php");
        }
    }
}
?>
