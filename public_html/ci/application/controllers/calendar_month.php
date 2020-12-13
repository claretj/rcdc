<?php
include ("funcs.php");

class Calendar_month extends CI_Controller {

function __construct() {
  parent::__construct();
  $this->load->database();
}

function index(){
  $this->view_this();
}

function view_this(){
  $monday=time() - (date('N')-1)*86400;
  $this->view($monday);
}

function view_date(){
  $monday_str=$_POST['monday'];
  YmdToDate($monday_str,$monday);
  $this->view($monday);
}

function view($start_monday){

 $month_arr=array();
 for ($iWeek=20; $iWeek>=0; $iWeek--){
  $monday=$start_monday- $iWeek*7*86400;
  $week_distance=0;
  for ($i=0; $i<=6; $i++) {
    $this_date=$monday+$i*86400;

    $day_stat = array("day"=>date('Y-m-d',$this_date),
                                "dayMD"=>date('m/d/y',$this_date),
                                "course"=>"",
                                "distanceStr"=>"0",
                                "timeStr"=>"",
                                "paceStr"=>"",
                                "comments"=>"",
                                "is_today"=>date('m/d/y',$this_date)==date('m/d/y')?"Y":"N" );


    $sql="SELECT c.descr course_descr, run.distance, run.time_sec, run.comments ".
        "FROM claret.run, claret.course c ".
        "WHERE run.rundate = '".date('Y-m-d',$this_date)."' ".
        "AND run.course_id = c.id ";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0){
      $row = $query->row_array(); 
      $distance=$row['distance'];
      if ($distance>0){
        $distanceStr=$distance;
        $week_distance+=$distance;
        $time_sec=$row['time_sec'];
        getTimeStr($time_sec,$timeStr);
        $pace_sec=floor($time_sec/$distance);
        getTimeStr($pace_sec,$paceStr);

        $day_stat['course']=$row['course_descr'];
        $day_stat['distanceStr']=$distanceStr;
        $day_stat['timeStr']=$timeStr;
        $day_stat['paceStr']=$paceStr;
        $day_stat['comments']=$row['comments'];
      }
    }
    $week_arr[$i]=$day_stat;
  }
  $week_stat['monday_str']=date("F d Y",$monday);
  $week_stat['mondayYmd']=date("Y-m-d",$monday);
  $week_stat['week_arr']=$week_arr;
  $week_stat['week_distance']=$week_distance;
  $month_arr[$iWeek]=$week_stat;
 } // end loop over weeks
 $data['month_arr']=$month_arr;
 $this->load->view('calendar_month_view', $data);
} // end function view
} // end class
?>
