<?php
/**
 * Project: EVE Online Information System Project
 * 
 * Title: authenticate.php
 * 
 * Author: Andy Lo
 * E-Mail: andy.lo@gmx.com
 */

session_start();

if(!isset($_SESSION['authenticated']) || !$_SESSION['authenticated'])
{
  header("Location: logout.php");
}
?>