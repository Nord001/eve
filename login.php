<?php
// EVE Online Information System Project
// Written By: Andy Lo

// Contains functions to sanitize input.
require_once('sanitize.php');
session_start();

// Checks whether or not the user was directed from the correct page.
// Also checks whether or not the username is empty.
if(isset($_POST['username'], $_POST['password'], $_POST['database']) &&
    !empty($_POST['username'])) {
    // Sanitizes form input and initializes session data.
    $_SESSION['username'] = sanitize($_POST['username'], 32);
    $_SESSION['password'] = sanitize($_POST['password'], 32);
    $_SESSION['database'] = sanitize($_POST['database']);
    $_SESSION['authenticated'] = false;

    // Cleans POST data.
    unset($_POST['username'], $_POST['password'], $_POST['database']);

    // Note-to-self: Imperative to add authentication code here later.
    // Arguments: Host, User, Password, Database
    $mysqli = new mysqli('localhost', 'eve', 'M5wsbSMTnnjrDjz3',
        'eve');

    if(mysqli_connect_errno()) {
        echo 'Connection failed: ' . mysqli_connect_error();
        exit();
    }

    $eve_user_table = 'eve_user_table';
    
    // Prepares the authentication query. Returns a mysqli_stmt object to $query.
    $query = $mysqli->prepare("SELECT username, password FROM $eve_user_table
        WHERE username = ? AND password = MD5(?) LIMIT 1");
    // Inserts the data to the query.
    $query->bind_param('ss', $_SESSION['username'], $_SESSION['password']);
    // Executes the query and buffer the results.
    $query->execute();
    $query->store_result();

    // Parses the query results.
    $meta = $query->result_metadata();
    while($column = $meta->fetch_field()) {
        $varArray[] = &$result[$column->name];
    }
    call_user_func_array(array($query, 'bind_result'), $varArray);
    $query->fetch();

  // Authenticates the session data against the results from the database.
    if(!strcmp($result['User'], $_SESSION['username'])
        && !strcmp($result['Password'], $_SESSION['password'])) {
        $_SESSION['authenticated'] = true;
        header("Location: dbquery.php");
    } else {
        header("Location: logout.php");
    }

  // Cleanup.
  $query->close();
  $mysqli->close();
}
?>
