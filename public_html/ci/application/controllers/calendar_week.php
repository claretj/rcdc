<?php
include ("funcs.php");

class Calendar_week extends CI_Controller {

function __construct() {
  parent::__construct();
  $this->load->database();
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

function view($monday){

  $week_distance=0;
  for ($i=0; $i<=6; $i++) {
    $this_date=$monday+$i*86400;

    $day_stat = array("day"=>date('Y-m-d',$this_date),
                                "dayMD"=>date('D, M j',$this_date),
                                "course"=>"",
                                "run_type"=>"",
                                "distanceStr"=>"",
                                "timeStr"=>"",
                                "paceStr"=>"",
                                "comments"=>"" );


    $sql="SELECT c.descr course_descr, rt.descr rt_descr, run.distance, run.time_sec, run.comments ".
        "FROM run, course c, run_type rt ".
        "WHERE run.rundate = '".date('Y-m-d',$this_date)."' ".
        "AND run.run_type_id=rt.id ".
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
        $day_stat['run_type']=$row['rt_descr'];
        $day_stat['distanceStr']=$distanceStr;
        $day_stat['timeStr']=$timeStr;
        $day_stat['paceStr']=$paceStr;
        $day_stat['comments']=$row['comments'];
      }
    }
    $week_arr[]=$day_stat;
  }
  $data['monday_str']=date("F d Y",$monday);
  $data['monday_prev_str']=date("Y-m-d",$monday-7*86400);
  $data['monday_next_str']=date("Y-m-d",$monday+7*86400);
  $data['week_arr']=$week_arr;
  $data['week_distance']=$week_distance;
  $this->load->view('calendar_week_view', $data);
}
}
?>