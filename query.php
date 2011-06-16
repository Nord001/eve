<?php require_once('authenticate.php'); ?>

<!-- EVE Online Information System Project
     Written By: Andy Lo
     Last Modified: 2011-05-05 -->

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/grid.css" />
<title>EVE Online Integrated Information Systems</title>
</head>
<body>
<div id="wrapper">
  <!-- Header Section -->
  <div id="header">
    <img src="img/eve-online-logo.png" alt="" />
  </div>
  <div id="content">
    <!-- Content Header Title -->
    <div id="content-header">
      <p>DATABASE QUERY</p>
    </div>
    <!-- Main Content -->
    <div id="content-box">
    </div>
  </div>
  <!-- Navigation -->
  <div id="sidebar">
    <div>
      <ul>
        <li class="header">NAVIGATION</li>
        <li><a href="query.php">Database Query</a></li>
        <li><a href="paycalc.php">Calculators</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </div>
  </div>
  <div class="clear"</div>
</div>
<!-- Load script to generate dynamic spreadsheet table from XML data. -->
<script type="text/javascript" src="/js/grid.js"></script>
</body>
</html>