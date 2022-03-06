<?php

// Start Session
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
$BadgeNum = $user->badge; 

$TypeInOut = "0";
$user_badge = $app->isSelectBreak($BadgeNum, $DateRecord, $TypeInOut); // check user login

if ($user_badge > 0){

  $DateRecord = date('Y-m-d 00:00:00.000', time());
  $TimeRecord = date('H:i', time());
  $TypeInOut = "0";
  $BadgeNum = $user->badge;
  $IdEmp = $user->IdEmp;
  $ClockNum = "0";
  $ManualRec = "0";
  $EventId = "0";
  $Event_Time = $DateRecord;
  $Note = " ";
  $ProjectId = "0";
  $Meal =  "0";

  $Username = $user->name;
  $ENT_Time = date('H:i:m', time());
  $ENT_Date = date('Y-m-d', time());

 //*Current_login_time = H:m
 $TimeRecord = date('H:i', time());

 //*last_login_time = H:m
 $user_log_break = $app->CheckLogBreak($BadgeNum, $TypeInOut);
 $last_login_break_time = $user_log_break->TimeRecord;

 //*current_date = Y-m-d
 $DateRecord = date('Y-m-d 00:00:00.000', time());
 
 //*last_login_date = Y-m-d
 $last_login_break_date = $user_log_break->DateRecord;

 //*if (current_date=last_login_date)
 if ($DateRecord == $last_login_break_date){
 //* do nothing
 echo "None taken";
 //*else
 } else {
 //* Subtract Time
 $arr = explode(":", $last_login_break_time, 2);
 $first = $arr[0];
 $to_mid = 24-$first;


 $arrlogin = explode(":", $TimeRecord, 2);
 $firstlogin = $arrlogin[0];

 $time_sub = $firstlogin + $to_mid;

 //* 
 if ($time_sub > "9"){
 //*  insert to table break
  $user_id = $app->AttendBreak($DateRecord, $TimeRecord, $TypeInOut, $IdEmp, $BadgeNum, $ClockNum, $ManualRec, $EventId, $Event_Time, $Note, $ProjectId, $Meal);
} else {
  header("Location: profile.php"); 
} } }

// Redirect to index.php page
header("Location: profile.php");
?>