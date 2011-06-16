<?php
# EVE Online Information System Project
# Written By: Andy Lo
# Last Modified: September 05, 2010

session_start();

if(!isset($_SESSION['authenticated']) || !$_SESSION['authenticated'])
{
  header("Location: logout.php");
}
?>