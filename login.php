<?php
/* EVE Online Information System Project
 * Written By: Andy Lo
 */

// Contains functions to sanitize input.
require_once('sanitize.php');
session_start();

/* Checks whether or not the user was directed from the correct page.
 * Also checks whether the username field is empty.
 */
if(isset($_POST['username'], $_POST['password']) && !empty($_POST['username'])) {
    // Sets up connection to database.
    $mysqli = new mysqli('localhost', 'eve', 'jBymeV3UYEZJu4wE', 'eve');

    if(mysqli_connect_errno()) {
        echo 'Connection failed: ' . mysqli_connect_error();
        exit();
    }

    /* Sanitizes form input and initializes session data.  Unnecessary with the
     * prepared statements, but I left the code in.
     */
    $c_username = $mysqli->real_escape_string($_POST['username']);
    $c_password = $mysqli->real_escape_string($_POST['password']);
    $_SESSION['authenticated'] = false;

    // Cleans POST data.
    unset($_POST['username'], $_POST['password']);
    
    $eve_user_table = 'eve_user_table';
    
    // Prepared statement for the authentication query.
    $stmt  = $mysqli->stmt_init();
    $query = "SELECT username, password FROM $eve_user_table WHERE username = ?";
    
    if(!$stmt->prepare($query)) {
        echo 'Failed to prepare statement.';
        exit();
    } else {
        // Binds the data to the query.
        $stmt->bind_param('s', $c_username);

        // Executes the query and buffers the results.
        if(!$stmt->execute()) {
            echo 'Query failed.';
        } else {
            $stmt->bind_result($result['username'], $result['password']);
        
            // Parses the query results.
            while($stmt->fetch()) {
                var_dump($result);
                /* Authenticates the session data against the results from the
                 * database.
                 */
                if(!strcmp($result['username'], $c_username)
                    && !strcmp($result['password'], md5($c_password))) {
                    $_SESSION['authenticated'] = true;
                    header("Location: grid_edit.php");
                } else {
                    echo "Authentication failed."; // Strictly for debugging.
                    //header("Location: logout.php");
                }
            }
        }
    }
}
?>
