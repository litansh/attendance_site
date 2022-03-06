<?php
// Start Session
session_start();

// Database connection
require __DIR__ . '/config/db_connection.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/library/library.php';
$app = new DemoLib($db);
$user = $app->UserDetails($_SESSION['user_id']);

require_once __DIR__ . '/GoogleAuthenticator/GoogleAuthenticator.php';
$pga = new LIS_GoogleAuthenticator();

$error_message = '';

if (isset($_POST['btnValidate'])) {

    $code = $_POST['code'];

    if ($code == "") {
        $error_message = 'Please enter authentication code to validated!';
    }
    else
    {
        if($pga->verifyCode($user->google_secret_code, $code, 2))
        {
            // success
            header("Location: profile.php");
        }
        else
        {
            // fail
            $error_message = 'Invalid Authentication Code!';
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
@media only screen and (max-width:620px) {
  /* For mobile phones: */
  .body, div.opacity, .buttonstart, .buttonend, .opacity, .container, .jumbotron, .col-md-12, .row {
    width:100%;
  } }
</style>
    <meta charset="UTF-8">
    <title>Validate Login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
<div class="opacity">
    <div class="row jumbotron">
        <div class="col-md-12">
        <h1>
                ClockIn
                <br>
                
            </h1>
            <h2>
            Google Authenticator
</h2>
            <p>
                Enter the code from the Google Authenticator Application
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
            <h4>Multi Factor Authentication</h4>

            <form method="post" action="validate_login.php">
                <?php
                if ($error_message != "") {
                    echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $error_message . '</div>';
                }
                ?>
                <div class="form-group">
                    <input type="text" name="code" placeholder="Enter Authentication Code" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" name="btnValidate" class="btn btn-primary">Validate</button>
                </div>
            </form>


        </div>
    </div>
   
</div>
</div>
</body>
</html>