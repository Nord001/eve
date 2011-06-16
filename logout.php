<?php
# EVE Online Information System Project
# Written By: Andy Lo
# Last Modified: September 05, 2010

# Clears the session.
session_start();
session_unset();
session_destroy();

header("Location: index.html");
?>