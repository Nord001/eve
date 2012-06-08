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

require_once('DatabaseConnection.php');
require_once('DatabaseQuery.php');
session_start();

// Andy Lo: Checks whether or not the user was directed from the correct page.
// Also checks whether the username field is empty.
if(isset($_POST['username'], $_POST['password']) && !empty($_POST['username'])) {
    // Andy Lo: Initialize the authentication 
    $_SESSION['authenticated'] = false;

    // Andy Lo: Gets form authentication data.
    $t_username = $_POST['username'];
    $t_password = $_POST['password'];
    
    // Andy Lo: Clears form authentication data.
    unset($_POST['username'], $_POST['password']);

    // Andy Lo: Set up authentication query and query parameters.
    $t_db_query = new DatabaseQuery();
    $t_fetch_columns = array(0 => "username", 1 => "password");
    $t_fetch_tables = array(0 => "eve_user_table");
    $t_fetch_where = array("username" => $t_username);

    if($t_result = $t_db_query->select($t_fetch_columns, $t_fetch_tables,
        $t_fetch_where)) {
        // Andy Lo: Matches the session data against the results from the
        // database.  Note that currently the result set is returned by
        // PDOStatement->fetchAll.
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
