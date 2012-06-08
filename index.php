<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- EVE Online Information System Project
     Written By: Andy Lo -->

<!-- Script checks visitor browser. If Internet Explorer is detected, the
     visitor is redirected. -->
<?php include('browser.php'); ?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <title>EVE Online Integrated Information Systems</title>
</head>
<body>
    <div id="wrapper"> <!-- Begin Wrapper -->
        <!-- Header Logo -->
        <div id="header">
            <img src="img/eve-online-logo.png" alt="" />
        </div>
        <div id="content" class="index"> <!-- Begin Content -->
            <!-- Content Header -->
            <div id="content-header">
                <p>LOGIN</p>
            </div>
            <!-- Main Content -->
            <div id="content-box">
                <!-- Login Form -->
                <!-- Once the information is submitted, the script logs the authentication
                     data and authenticates the user. -->
                <form name="login" action="login.php" method="post">
                    <!-- Username Prompt -->
                    <div class="entry">
                        <label>Username:</label>
                        <input type="text" name="username" size="32" maxlength="32" />
                    </div>
                    <!-- Password Prompt -->
                    <div class="entry">
                        <label>Password:</label>
                        <input type="password" name="password" size="32" maxlength="32" />
                    </div>
                    <!-- Remember Information Prompt -->
                    <!-- Note: Not yet fully implemented. -->
                    <div class="entry">
                        <input type="checkbox" name="remember" />Remember login information.
                    </div>
                    <input type="submit" name="submit" value="Submit" />
                </form>
                <!-- Error Message Prints Here -->
                <div>
                    <noscript>You must have JavaScript support enabled to run this application.</noscript>
                </div>
            </div>
            <!-- Footer -->
            <div class="clear"></div>
        </div> <!-- End Content -->
    </div> <!-- End Wrapper -->
</body>
</html>