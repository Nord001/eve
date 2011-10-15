<?php
/**
 * Project: EVE Online Information System Project
 * 
 * Title: logout.php
 * 
 * Author: Andy Lo
 * E-Mail: andy.lo@gmx.com
 */

# Clears the session.
session_start();
session_unset();
session_destroy();

header("Location: index.html");
?>