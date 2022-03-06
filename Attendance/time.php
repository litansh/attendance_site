<?php

//* login between 00:00 and 06:00
//* no login allowed if there was a login a day before (logout-lastDayLogin<16)
//* entrance equals last login in database


if ( $firstlogin < "6" && $time_sub > "16"){
  echo "Non Taken";
}
else if ( $time_sub > "10" && $firstlogin > "6" ){
  $user_id = $app->Attend($DateRecord, $TimeRecord, $TypeInOut, $IdEmp, $BadgeNum, $ClockNum, $ManualRec, $EventId, $Event_Time, $Note, $ProjectId, $Meal);
  $Username = $user->username;
  $ENT_Time = $TimeRecord;
  $ENT_Date = date('Y-m-d', time());
  $user_ent = $app->Entrance($Username, $ENT_Time, $ENT_Date);
} else {
  $Username = $user->username;
  $user_ent_fun = $app->UserEnter($Username);
  $user_ent = $user_ent_fun->ENT_Time;
} } } else { 
  $Username = $user->username; 
  $user_ent_fun = $app->UserEnter($Username);
  $user_ent = $user_ent_fun->ENT_Time;
}
}

//* logout gap after 00:00
//* if no logout before and login a day before -> new logout

if ($DateRecord == $last_logout_attend_date){
 $user_out = $app->OutUpdate($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut); // check user logout
 //*else
 } else {
 //* Subtract Time
 $arr = explode(":", $last_logout_attend_time, 2);
 $first = $arr[0];
 $to_mid = 24-$first;

 $arrlogout = explode(":", $TimeRecord, 2);
 $firstlogout = $arrlogout[0];

 $time_sub = $firstlogout + $to_mid;
 //* 
 if ($time_sub < "9"){
 $DateRecord = $last_logout_attend_date;
 $TimeRecord = date('H:i', time());
 $user_out = $app->OutUpdate($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut); // check user logout
 $user_out_date = $app->OutUpdateDate($BadgeNum, $TimeRecord, $DateRecord, $TypeInOut); // check user logout
} 
else {
  $user_id = $app->Attend($DateRecord, $TimeRecord, $TypeInOut, $IdEmp, $BadgeNum, $ClockNum, $ManualRec, $EventId, $Event_Time, $Note, $ProjectId, $Meal);
} } }

?>


