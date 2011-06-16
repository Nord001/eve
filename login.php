<?php
// EVE Online Information System Project
// Written By: Andy Lo
// Last Modified: 2011-05-05

// Contains functions to sanitize input.
require_once('sanitize.php');
session_start();

// Checks whether or not the user was directed from the correct page.
// Also checks whether or not the username is empty.
if(isset($_POST['username'], $_POST['password'], $_POST['database']) &&
  !empty($_POST['username']))
{
  // Sanitizes form input and initializes session data.
  $_SESSION['username'] = sanitize($_POST['username'], 16);
  $_SESSION['password'] = sanitize($_POST['password'], 32);
  $_SESSION['database'] = sanitize($_POST['database']);
  $_SESSION['authenticated'] = false;

  // Cleans POST data.
  unset($_POST['username'], $_POST['password'], $_POST['database']);

  // Note-to-self: Imperative to add authentication code here later.
  $mysqli = new mysqli('localhost', '281430_admin', 'f6nnrrsb2rjhqh7',
    'andylo_zxq_eve');

  if(mysqli_connect_errno())
  {
    echo 'Connection failed: ' . mysqli_connect_error();
    exit();
  }

  // Prepares the authentication query. Returns a mysqli_stmt object to $query.
  $query = $mysqli->prepare('SELECT User, Password FROM user WHERE User = ?
    AND Password = ? LIMIT 1');
  // Inserts the data to the query.
  $query->bind_param('ss', $_SESSION['username'], $_SESSION['password']);
  // Executes the query and buffer the results.
  $query->execute();
  $query->store_result();

  // Parses the query results.
  $meta = $query->result_metadata();
  while($column = $meta->fetch_field())
  {
    $varArray[] = &$result[$column->name];
  }
  call_user_func_array(array($query, 'bind_result'), $varArray);
  $query->fetch();

  // Authenticates the session data against the results from the database.
  if(!strcmp($result['User'], $_SESSION['username'])
    && !strcmp($result['Password'], $_SESSION['password']))
  {
    $_SESSION['authenticated'] = true;
  }

  // Cleanup.
  $query->close();
  $mysqli->close();
}

// Verifies authentication before redirecting user.
if($_SESSION['authenticated'])
{
  header("Location: query.php");
}
else
{
  header("Location: logout.php");
}
?>