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
$username_for_email = $user->username;
require_once __DIR__ . '/GoogleAuthenticator/GoogleAuthenticator.php';
$pga = new LIS_GoogleAuthenticator();
$qr_code =  $pga->getQRCodeGoogleUrl($user->email, $user->google_secret_code, 'CGLMS');
$googleauth = 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en';
$clockinaddr = 'https://clockin.cglms.com';
$error_message = '';

$link .= $_SERVER['REQUEST_URI']; 
$userpassword = substr($link, strpos($link, "=") + 1);   

if (isset($_POST['btnValidate'])) {

    $code = $_POST['code'];

    if ($code == "") {
        $error_message = 'Please Scan above QR code to configure your application and enter genereated authentication code to validated!';
    }
    else
    {
        if($pga->verifyCode($user->google_secret_code, $code, 2))
        {
            // success

            header("Location: adminpanel.php");
        }
        else
        {
            // fail
            $error_message = 'Invalid Authentication Code!';
        }
    }
}

    $to      = "$user->email";
    $subject = 'Enter the attendance site';
    $message = 'Hi' . " $user->username !" . "\r\n\r\n"  . 
               ' In order to register, please follow these steps:' . "\r\n"  . 
               '1. Download Google Authenticator App from Play Store on your MOBILE!' . "\r\n"  . 
               'Link:' . "$googleauth" . "\r\n\r\n"  . 
               '2. Scan the barcode from the link below to the app downloaded under “scan barcode” at the bottom of the app:' . "\r\n"  . 
               "$qr_code" . "\r\n\r\n"  . 
               '3. Login details to attendance site (also on Android):' . "\r\n"  . 
               'Username:' . " $user->username" . "\r\n"  . 
               'Password:' . "$userpassword" . "\r\n"  . 
               'Authentication code: from Google Authentication Application.' . "\r\n"  . 
               'Link to attendance site:' . " $clockinaddr" . "\r\n\r\n"  . 
               'Enjoy!' . "\r\n\r\n"  . 
               '*** Do not reply to this email ***';
    $headers = 'From: Help@cglms.com' . "\r\n" .
               'CC: hr-attend@cglms.com';
               'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
    header("Refresh:5; url=adminpanel.php");
 
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
.blink-one {
      animation: blinker-one 1s linear infinite;
      }
      @keyframes blinker-one {  
      0% { opacity: 0; }
      }
</style>
<head>
    <meta charset="UTF-8">
    <title>Confirm User Device</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>


<div class="container">
<div class="opacity">
    <div class="row jumbotron">
        <div class="col-md-12">
        <h1>
                ClockIn - Admin
                <br></h1>
                <h2>
                Send details and Authenticate
</h2>
            
            <!-- <p>
            First time? Forgot how?.. Press for <a target="_blank" href="https://clockinadmin/instructions.php">Instructions</a>

            </p> -->
            </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
            <!-- <h4>Login details sent to user</h4> -->

            <!-- <p>
                Send details to employee. If you did not save the password from the last page, please enter the authentication code and "change user password" at the admin panel and send it to the user. 
            </p> -->



            <form method="post" action="confirm_google_auth.php">
                <?php
                if ($error_message != "") {
                    echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $error_message . '</div>';
                }
                ?>
                <div class="form-group">
                <h4 style="font-weight: bold;"> Email has been sent to <?php echo $user->email ?> </h4> <br> <h4 style="background-color:green;color:white;" class="blink-one"> Redirecting to admin panel in 3,2,1.. </h4>
            
                </div>
                <div class="form-group">
                    <!-- <button type="submit" name="btnValidate" class="btn btn-primary">Validate</button> -->
                </div>
                <!-- <div class="col-md-12 alert alert-success">
                <a href="adminpanel.php">Back to Admin Panel</a>
            </div> -->
            </form>

        </div>
    </div>

    <hr>

</div>

</body>
</html>

<?php   
   $to_email = "systemil@cglms.com";
     $subject = "New user has been registered to Clockin!";
     $body = "Hi, New user " .$user->email. " has been registered to Clockin!";
     $headers = "From: clockin@cglms.com";
   mail($to_email, $subject, $body, $headers);
?>
