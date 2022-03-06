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

    $to      = 'litan.shamir@cglms.com';
    $subject = 'Enter the attendance site';
    $message = 'Hi' . "$user->username" . "\r\n"  . 
    ' In order to register, please follow these steps:' . "\r\n"  . 
    '1 Download Google Authenticator App from Play Store on your MOBILE!' . "\r\n"  . 'Link:' ."urlencode($googleauth)" . "\r\n"  . 
    '2 Scan the barcode from the link below to the app downloaded under “scan barcode” at the bottom of the app:' . "\r\n"  . 
    "urlencode($qr_code)" . "\r\n"  . '3 Login details to attendance site (also on Android):' . "\r\n"  . 
    'Username:' . "$user->username" . "\r\n"  . 
    'Password: Will be sent separately.' . "\r\n"  . 
    'Authentication code: from Google Authentication Application.' . "\r\n"  . 
    'Link to attendance site: . "urlencode($clockinaddr);" . "\r\n"  . 
    'Enjoy!' . "\r\n"  . 
    'Do Not reply to this message!';
    $headers = 'From: HelpDesk@colmex.com' . "\r\n" .
               'CC: litan.shamir@cglms.com';
               'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
    header("Location: adminpanel.php");

  
?>
