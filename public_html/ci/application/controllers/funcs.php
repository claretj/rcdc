<?php
function getHoursMinutesSeconds($time_sec,&$hours,&$minutes,&$seconds) {
  $hours=floor($time_sec/3600);
  $time_sec=$time_sec-3600*$hours;
  $minutes=floor($time_sec/60);
  $time_sec=$time_sec-60*$minutes;
  $seconds=$time_sec;
}

function getTimeStr($time_sec,&$timeStr){
  $timeStr="";
  getHoursMinutesSeconds($time_sec,$hours,$minutes,$seconds);
  if ($hours>0){
    $timeStr=$timeStr.$hours.":";
  }      
  if ($minutes<10 && $hours>=1){
    $timeStr=$timeStr."0";
  }
  $timeStr=$timeStr.$minutes.":";
  if ($seconds<10){
    $timeStr=$timeStr."0";
  }
  $timeStr=$timeStr.$seconds;
}

function YmdToDate($date_str, &$date){
  $date_arr = explode("-",$date_str);
  $date=mktime(0,0,0,(int)$date_arr[1],(int)$date_arr[2],(int)$date_arr[0]);
}
?>