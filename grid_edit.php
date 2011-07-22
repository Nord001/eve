<?php require_once('authenticate.php'); ?>

<!-- EVE Online Information System Project
     Written By: Andy Lo -->

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/grid.css" />
    <title>EVE Online Integrated Information Systems</title>
</head>
<body>
    <div id="wrapper"> <!-- Begin Wrapper -->
        <!-- Header Section -->
        <div id="header">
            <img src="img/eve-online-logo.png" alt="" />
        </div>
        <div id="content"> <!-- Begin Content -->
            <!-- Content Header Title -->
            <div id="content-header">
                <p>DATABASE QUERY</p>
            </div>
            <!-- Main Content -->
            <div id="content-box"></div>
        </div> <!-- End Content -->
        <div id="sidebar"> <!-- Begin Navigation -->
            <div>
                <ul>
                    <li class="header">NAVIGATION</li>
                    <li><a href="query.php">Database Query</a></li>
                    <li><a href="paycalc.php">Calculators</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </div> <!-- End Navigation -->
        <div class="clear"</div>
    </div> <!-- End Wrapper -->
    <!-- Load script to generate dynamic spreadsheet table from XML data. -->
    <script type="text/javascript" src="/eve/js/AddOnloadEvent.js"></script>
    <script type="text/javascript" src="/eve/js/grid.js"></script>
</body>
</html>