<?php
# EVE Online Information System Project
# Written By: Andy Lo

# Clears the session.
session_start();
session_unset();
session_destroy();

header("Location: index.html");
?>