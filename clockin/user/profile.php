<?php

// Start Session
session_start();

// check user login
if(empty($_SESSION['user_id']))
{
    header("Location: index.php");
}

// Users Database connection
require __DIR__ . '/config/db_connection.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/library/library.php';
$app = new DemoLib($db);
$user = $app->UserDetails($_SESSION['user_id']);
$badgeid=$user->badge;

date_default_timezone_set('Asia/Jerusalem');
//$date = date('m/d/Y H:i:s a', time());

$DateRecord = date('Y-m-d 00:00:00.000', time());
$BadgeNum = $user->badge; 
$ENT_Date = date('Y-m-d', time());
$TypeInOut = "0";

if(empty($BadgeNum)){
     echo 'Something went wrong. Please refer to help@cglms.com with this issue. Thank you!';
     } else {
       $user_badge = $app->isSelect($BadgeNum, $DateRecord, $TypeInOut); // check user login
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
         $user_log_attend = $app->CheckLogAttend($BadgeNum, $TypeInOut);
         $last_login_attend_time = $user_log_attend->TimeRecord;
         //*current_date = Y-m-d
         $DateRecord = date('Y-m-d 00:00:00.000', time());
         //*last_login_date = Y-m-d
         $last_login_attend_date = $user_log_attend->DateRecord;
         //* if (current_date=last_login_date)
         if ($DateRecord == $last_login_attend_date){
          //* do nothing
          echo "None taken";
          //*else
         } else {
           //* Subtract Time
           $arr = explode(":", $last_login_attend_time, 2);
           $first = $arr[0];
           $to_mid = 24-$first;
           $arrlogin = explode(":", $TimeRecord, 2);
           $firstlogin = $arrlogin[0];
           $time_sub = $firstlogin + $to_mid;
           if ( $firstlogin < "6" && $time_sub > "16"){
              echo "Non Taken";
           } elseif ( $time_sub > "10" && $firstlogin > "6" ){
               $user_id = $app->Attend($DateRecord, $TimeRecord, $TypeInOut, $IdEmp, $BadgeNum, $ClockNum, $ManualRec, $EventId, $Event_Time, $Note, $ProjectId, $Meal);
               $Username = $user->username;
               $ENT_Time = $TimeRecord;
               $ENT_Date = date('Y-m-d', time());
               $user_ent = $app->Entrance($Username, $ENT_Time, $ENT_Date);
           } else {
              $Username = $user->username;
              $user_ent_fun = $app->UserEnter($Username);
              $user_ent = $user_ent_fun->ENT_Time;
           } 
         } 
       } else { 
         $Username = $user->username; 
         $user_ent_fun = $app->UserEnter($Username);
         $user_ent = $user_ent_fun->ENT_Time; 
      }
}

// function BreakStart() {
  // $servername = "127.0.0.1";
  // $username = "academy";
  // $password = "Dc4HjjtBWp";
  // $dbname = "clockin";
  
  // // Create connection
  // $conn = new mysqli($servername, $username, $password, $dbname);
  // // Check connection
  // // if ($conn->connect_error) {
  // //     die("Connection failed: " . $conn->connect_error);
  // // }

  $TimeRecord = date('H:i', time());
  $TypeInOut = "0";
  $DateRecord = date('Y-m-d 00:00:00.000', time());
  $Yesterday = date('Y-m-d 00:00:00.000', time() - (60 * 60 * 24));
  $user_break_in = $app->CheckLogBreak($BadgeNum, $TypeInOut);
  $user_break_time = $user_break_in->TimeRecord;

  $arr_b = explode(":", $user_break_time, 2);
  $first_b = $arr_b[0];
  $to_mid_b = 24-$first_b;

  $arrlogin_b = explode(":", $TimeRecord, 2);
  $firstlogin_b = $arrlogin_b[0];

  $time_sub_b = $first_b - $firstlogin_b;
  $time_sub_c = $to_mid_b + $firstlogin_b;
  
  $user_break_date = $user_break_in->DateRecord;

  if ($user_break_date == $DateRecord && $time_sub_b < "9"){
      $BreakStart = $user_break_time;
  } else if ($user_break_date == $Yesterday && $time_sub_c < "9"){
    $BreakStart = $user_break_time;
  } else {  $BreakStart = " ";
  }

  $TimeRecord = date('H:i', time());
  $TypeInOut = "1";
  $DateRecord = date('Y-m-d 00:00:00.000', time());
  $Yesterday = date('Y-m-d 00:00:00.000', time() - (60 * 60 * 24));
  $user_break_in = $app->CheckLogBreak($BadgeNum, $TypeInOut);
  $user_break_time = $user_break_in->TimeRecord;

  $arr_b = explode(":", $user_break_time, 2);
  $first_b = $arr_b[0];
  $to_mid_b = 24-$first_b;

  $arrlogin_b = explode(":", $TimeRecord, 2);
  $firstlogin_b = $arrlogin_b[0];

  $time_sub_b = $first_b - $firstlogin_b;
  $time_sub_c = $to_mid_b + $firstlogin_b;
  
  $user_break_date = $user_break_in->DateRecord;

  if ($user_break_date == $DateRecord && $time_sub_b < "9"){
      $BreakEnd = $user_break_time;
  } else if ($user_break_date == $Yesterday && $time_sub_c < "9"){
    $BreakEnd = $user_break_time;
  } else {  $BreakEnd = " ";
  }


// $sql = "SELECT TimeRecord, DateRecord, TypeInOut, BadgeNum FROM clockin.break";
// $result = $conn->query($sql);

//   if ($result->num_rows > 0) {

//     while($row = $result->fetch_assoc()) {

//       if ($row["BadgeNum"] = $BadgeNum && $row["TypeInOut"] == "0" && $row["DateRecord"] == $DateRecord){
//             $string = $row["TimeRecord"];
//             echo $string;
//            } } }else {
//        echo " ";
//    }
//   $conn->close();
  // }

  function BreakEnd() {
    $servername = "127.0.0.1";
    $username = "academy";
    $password = "Dc4HjjtBWp";
    $dbname = "clockin";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
  
    $TimeRecord = date('H:i', time());
  $TypeInOut = "1";

  $DateRecord = date('Y-m-d 00:00:00.000', time());
  $sql = "SELECT TimeRecord, DateRecord, TypeInOut, BadgeNum FROM clockin.break";
  $result = $conn->query($sql);
 
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
            if ($row["BadgeNum"] == $BadgeNum && $row["TypeInOut"] == "1" && $row["DateRecord"] == $DateRecord){
              $string = $row["TimeRecord"];
              echo $string;
          } } }else {
         echo " ";
     }
    $conn->close();
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
.buttonstart {
         background-color: green;
         border: none;
         color: white;
         padding: 7% 10%;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 100%;
         margin: 2% 2%;
         cursor: pointer;
         }
         .buttonend {
         background-color: red;
         border: none;
         color: white;
         padding: 7% 10%;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 100%;
         margin: 2% 2%;
         cursor: pointer;
         }
         @media only screen and (max-width:620px) {
  /* For mobile phones: */
  .body, div.opacity, .buttonstart, .buttonend, .opacity, .container, .jumbotron, .col-md-12, .row {
    width:100%;
  }
}
</style>
    <meta charset="UTF-8">
    <title>ClockIn - Shift Started</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
<div class="opacity">

<!-- 
            <div class="row jumbotron" >
        <div class="col-md-12">
        <h2>Attendance panel</h2>
                <h3><?php echo $ENT_Date; ?> </h3>
            

        </div>
    </div> -->
    <div class="row">
        <div class="col-md-4 col-md-offset-4 well" >
        <h3><?php echo $ENT_Date; ?> </h3>
             <h2>Welcome aboard<b> <?php echo $user->name; ?>!</b></h2>
            <h3><b>Shift started: <?php echo $user_ent; ?></b></h3>
            <h4><b>Break started: </b><?php echo $BreakStart; ?></h4>
            <h4><b>Break ended: </b><?php echo $BreakEnd; ?></h4><br><br>
            <a href="startbreak.php" class="buttonstart">Start Break</a>
            <a href="endbreak.php" class="buttonend">End Break</a>
            <br>
            <h4><b>***Logout when shift is finished!!!***</b></h4>
            <br>
            Click here to <a href="logout.php">Logout</a>
        </div>

        <div align="center">
<canvas id="canvas" width="400" height="400" style="background-color:#333">
</canvas>
</div>
<div class="container">
<script>
var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");
var radius = canvas.height / 2;
ctx.translate(radius, radius);
radius = radius * 0.90
setInterval(drawClock, 1000);

function drawClock() {
  drawFace(ctx, radius);
  drawNumbers(ctx, radius);
  drawTime(ctx, radius);
}

function drawFace(ctx, radius) {
  var grad;
  ctx.beginPath();
  ctx.arc(0, 0, radius, 0, 2*Math.PI);
  ctx.fillStyle = 'white';
  ctx.fill();
  grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
  grad.addColorStop(0, '#333');
  grad.addColorStop(0.5, 'white');
  grad.addColorStop(1, '#333');
  ctx.strokeStyle = grad;
  ctx.lineWidth = radius*0.1;
  ctx.stroke();
  ctx.beginPath();
  ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
  ctx.fillStyle = '#333';
  ctx.fill();
}

function drawNumbers(ctx, radius) {
  var ang;
  var num;
  ctx.font = radius*0.15 + "px arial";
  ctx.textBaseline="middle";
  ctx.textAlign="center";
  for(num = 1; num < 13; num++){
    ang = num * Math.PI / 6;
    ctx.rotate(ang);
    ctx.translate(0, -radius*0.85);
    ctx.rotate(-ang);
    ctx.fillText(num.toString(), 0, 0);
    ctx.rotate(ang);
    ctx.translate(0, radius*0.85);
    ctx.rotate(-ang);
  }
}

function drawTime(ctx, radius){
    var now = new Date();
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    //hour
    hour=hour%12;
    hour=(hour*Math.PI/6)+
    (minute*Math.PI/(6*60))+
    (second*Math.PI/(360*60));
    drawHand(ctx, hour, radius*0.5, radius*0.07);
    //minute
    minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
    drawHand(ctx, minute, radius*0.8, radius*0.07);
    // second
    second=(second*Math.PI/30);
    drawHand(ctx, second, radius*0.9, radius*0.02);
}

function drawHand(ctx, pos, length, width) {
    ctx.beginPath();
    ctx.lineWidth = width;
    ctx.lineCap = "round";
    ctx.moveTo(0,0);
    ctx.rotate(pos);
    ctx.lineTo(0, -length);
    ctx.stroke();
    ctx.rotate(-pos);
}
</script>
</div>
       
    </div>

    <hr>
    <div class="row">
        <div class="col-md-12 alert alert-warning">
           Have a GREAT shift! :)
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 alert alert-success">
You must logout at the end of the shift!
<br>
If logged-out already, please login and out again.
        </div>
    </div>
</div>

</body>
</html>