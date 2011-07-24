<?php
/* EVE Online Information System Project
 * Written By: Andy Lo
 */

require_once('Singleton.php');
session_start();

/* Checks whether or not the user was directed from the correct page.
 * Also checks whether the username field is empty.
 */
if(isset($_POST['username'], $_POST['password']) && !empty($_POST['username'])) {
    $_SESSION['authenticated'] = false;
    
    // Configure database connection.
    $t_db_dsn = 'mysql:host=localhost;dbname=eve';
    $t_db_username = 'eve';
    $t_db_password = 'B968AHTjZZK7NVDx';

    // Gets POST data.
    $t_username = $_POST['username'];
    $t_password = $_POST['password'];
    
    // Cleans POST data.
    unset($_POST['username'], $_POST['password']);
    
    // Sets up connection to database.
    try {
        $db = new PDO($t_db_dsn, $t_db_username, $t_db_password);
    } catch(PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    
    // Set up authentication query.
    $eve_user_table = 'eve_user_table';
    $query = "SELECT username, password FROM $eve_user_table WHERE username =
        :username";
    
    if(!$stmt = $db->prepare($query)) {
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
                header("Location: grid_edit.php");
            } else {
                echo "Authentication failed."; // Strictly for debugging.
                //header("Location: logout.php");
            }
        }
    }
}
?>
