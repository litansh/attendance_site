<?php

// start session
session_start();

// Users Database connection
require __DIR__ . '/config/db_connection.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/library/library.php';
$app = new DemoLib($db);
$user = $app->UserDetails($_SESSION['user_id']);

date_default_timezone_set('Asia/Jerusalem');
//$date = date('m/d/Y H:i:s a', time());

$DateRecord = date('Y-m-d 00:00:00.000', time());
$TimeRecord = date('H:i', time());
$BadgeNum = $user->badge; 
$TypeInOut = "1";
$IdEmp = $user->IdEmp;
$ClockNum = "0";
$ManualRec = "0";
$EventId = "0";
$Event_Time = $DateRecord;
$Note = " ";
$ProjectId = "0";
$Meal =  "0";

$user_badge = $app->isSelectOut($BadgeNum, $DateRecord, $TypeInOut); // check user login

if ($user_badge > 0){
  $user_log_attend = $app->CheckLogOut($BadgeNum, $TypeInOut);
  $last_logout_attend_time = $user_log_attend->TimeRecord;
  $arr = explode(":", $last_logout_attend_time, 2);
  $first = $arr[0];
  $to_mid = 24-$first;
  $DateRecord = date('Y-m-d 00:00:00.000', time());
  $last_logout_attend_date = $user_log_attend->DateRecord;
  $arrlogout = explode(":", $TimeRecord, 2);
  $firstlogout = $arrlogout[0];
  $gap = $firstlogout - $first;
  $time_sub = $firstlogout + $to_mid;
  $yesterday =  date('Y-m-d 00:00:00.000', time() - (60*60*24));

    if ($DateRecord == $last_logout_attend_date && $gap < "16"){
        $user_out_date = $app->OutUpdate($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut);
        $user_out = $app->OutUpdateDate($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut); // check user logout
    } elseif ($firstlogout < "6" && $time_sub < "16" && $last_logout_attend_date == $yesterday){
        $user_out_date = $app->OutUpdate($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut);
        $user_out = $app->OutUpdateDate($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut); // check user logout
    } else {
        $user_id = $app->Attend($DateRecord, $TimeRecord, $TypeInOut, $IdEmp, $BadgeNum, $ClockNum, $ManualRec, $EventId, $Event_Time, $Note, $ProjectId, $Meal);
     } 

 }

// Destroy user session
// unset($_SESSION['user_id']);
// session_destroy();

// Redirect to index.php page
header("Location: index.php");
?>