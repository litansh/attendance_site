<?php

// Start Session
session_start();

// Database connection
require __DIR__ . '/config/db_connection.php';
$db = DB();

// Application library ( with demoLib class )
require __DIR__ . '/library/library.php';
$app = new demoLib($db);

$login_error_message = '';

// check Login request
if (!empty($_POST['btnLogin'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "") {
        $login_error_message = 'Username field is required!';
    } else if ($password == "") {
        $login_error_message = 'Password field is required!';
    } else {
        $perm="2";
        $user_id = $app->AdminLogin($username, $password, $perm); // check user login
        if($user_id > 0)
        {
            $_SESSION['user_id'] = $user_id; // Set Session
            header("Location: validate_login.php"); // Redirect user to validate auth code
        }
        else
        {
            $login_error_message = 'Invalid login details!';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<style>
body {
  background-image: url('css/BG01.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
}
div.opacity {
  opacity: 0.8;
  font-weight: 900;
}
</style>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
<div class="opacity">
    <div class="row jumbotron">
        <div class="col-md-12">
        
            <h1>
                ClockIn - Attendance
            </h1>
            <br>
            <p>
            First time? Forgot how?.. Press for <a target="_blank" href="https://clockin/instructions.php">Instructions</a>
            </p>
        </div>
        </div>
   
    <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
            <h4>Login</h4>
            <?php
            if ($login_error_message != "") {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
            }
            ?>
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="">Username/Email</label>
                    <input type="text" name="username" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>
                </div>
            </form>
        </div>
    </div>

    <hr>
    <!-- <div class="row">
        <div class="col-md-12 alert alert-success">
            Go to home - <a target="_blank" href="http://home/">Home</a>
        </div>
    </div> -->
</div>
</div>
</body>
</html>