<?php
/* EVE Online Information System Project
 * Written By: Andy Lo
 */

require_once('Singleton.php');
require_once('DatabaseConnection.php');
session_start();

/* Checks whether or not the user was directed from the correct page.
 * Also checks whether the username field is empty.
 */
if(isset($_POST['username'], $_POST['password']) && !empty($_POST['username'])) {
    $_SESSION['authenticated'] = false;
    
    // Sets up and returns a PDO database connection object.
    Singleton::setClass(DatabaseConnection);
    $dbconnection = Singleton::getInstance()->getConnection();

    // Gets form authentication data.
    $t_username = $_POST['username'];
    $t_password = $_POST['password'];
    
    // Clears form authentication data.
    unset($_POST['username'], $_POST['password']);

    // Set up authentication query.
    $eve_user_table = 'eve_user_table';
    $query = "SELECT username, password FROM $eve_user_table WHERE username =
        :username";
    
    if(!$stmt = $dbconnection->prepare($query)) {
        echo 'Failed to prepare statement.';
        exit();
    } else {
        $stmt->bindParam(':username', $t_username);

        // Executes the query and buffers the results.
        try {
            $stmt->execute();
        } catch(PDOException $e) {
            echo 'Query failed: ' . $e->getMessage();
        }

        // Parses the query results.
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            /* Authenticates the session data against the results from the
             * database.
             */
            if(!strcmp($result['username'], $t_username)
                && !strcmp($result['password'], md5($t_password))) {
                $_SESSION['authenticated'] = true;
                echo "Authentication success."; // Strictly for debugging.
            } else {
                echo "Authentication failed."; // Strictly for debugging.
                //header("Location: logout.php");
            }
        }
    }
}
?>
