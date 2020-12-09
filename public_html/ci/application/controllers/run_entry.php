<?php
//include ("funcs.php"); //included in calendar.php
include ("calendar_month.php");

class Run_entry extends CI_Controller {

function __construct() {
  parent::__construct();
  $this->load->database();
}

function view_today(){
  $date=date("Y-m-d");
  $this->view($date);
}

function view_date(){
  $this->load->database();
  $date=$_POST['date'];
  $this->view($date);
}

function post_entry(){
  $date=$_POST['date'];
  $distance=$_POST['distance'];

  //delete row with that date
  $this->db->query("delete from claret.run where rundate='".$date."'");

  //insert new row with that date
  if ($distance>0){
    $hours=$_POST['hours']||0;
    $minutes=$_POST['minutes']||0;
    $seconds=$_POST['seconds']||0;
    $time_sec=$hours*3600+$minutes*60+$seconds;
    if ($hours==0){$hours="";}
    $seconds=str_pad($seconds, 2, "0", STR_PAD_LEFT);
    $course_id=$_POST['course_id'];
    $comments=$_POST['comments'];
    $run_type_id=$_POST['run_type_id'];
    $shoe_id=$_POST['shoe_id'];
    $sql_string="insert into claret.run (rundate,distance,time_sec,course_id,comments,run_type_id,shoe_id) ".
      "values ('".$date."',".$distance.",".$time_sec.",".$course_id.", '". 
      $comments."',".$run_type_id.", ".
      $shoe_id."); ";
    $this->db->query($sql_string);
  }
  $cal = new Calendar_month();
  $cal->view_this();
//  $this->view($date);
}

function view($date){
  $sql_string="select * from claret.run where rundate='".$date."' ";
  $query = $this->db->query($sql_string);

  if ($query->num_rows() > 0){
    $row = $query->row_array(); 
    $distance=$row['distance'];
    getHoursMinutesSeconds($row['time_sec'],$hours,$minutes,$seconds);
    if ($hours==0){$hours="";}
    $seconds=str_pad($seconds, 2, "0", STR_PAD_LEFT);
    $course_id=$row['course_id'];
    $comments=$row['comments'];
    $run_type_id=$row['run_type_id'];
    $shoe_id=$row['shoe_id'];
  }else{
    $distance="";
    $hours="";
    $minutes="";
    $seconds="";
    $course_id="";
    $comments="";
    $run_type_id="";
    $shoe_id="";
  }

  YmdToDate($date,$date_date);
  $mdy_str=date("F d Y",$date_date);

  $data['date']=$date;                 
  $data['date_long']=$mdy_str;
  $data['distance']=$distance;
  $data['hours']=$hours;
  $data['minutes']=$minutes;
  $data['seconds']=$seconds;
  $data['course_id']=$course_id;
  $data['comments']=$comments;
  $data['run_type_id']=$run_type_id;
  $data['shoe_id']=$shoe_id;

  $this->get_dropdowns($data['course_arr'],$data['run_type_arr'],$data['shoe_arr'], $data['shoe_id']);
  $this->load->view('run_entry_view', $data);
}

function get_dropdowns(&$course_arr,&$run_type_arr,&$shoe_arr,$shoe_id){
  $sql_string="SELECT course.id, course.descr, max( rundate ) ".
  "FROM claret.course, claret.run ".
  "WHERE course.id = run.course_id ".
  "AND course.status = 'A' ".
  "GROUP BY course.id ".
  "ORDER BY 3 DESC ";
  $query = $this->db->query($sql_string);
  $course_arr=$query->result_array();

  $sql_string="SELECT rt.id, rt.descr ".
  "FROM claret.run_type rt ".
  "ORDER BY sort_order asc ";
  $query = $this->db->query($sql_string);
  $run_type_arr=$query->result_array();

  $sql_string="SELECT shoe.id, shoe.descr, max( rundate ) end ".
  "FROM claret.shoe, claret.run ".
  "WHERE shoe.id = run.shoe_id ".
  "AND shoe.status = 'A' ".
  "GROUP BY shoe.id ".
  "union select id,descr,null from claret.shoe where id not in (select shoe_id from claret.run) and shoe.status='A' ";
  if (!empty($shoe_id)){
  $sql_string=$sql_string." union SELECT shoe.id, shoe.descr, max( rundate ) ".
  " FROM claret.shoe, claret.run ".
  " WHERE shoe.id = ".$shoe_id.
  " AND shoe.status = 'I' ".
  " GROUP BY shoe.id ";
  }
  $sql_string=$sql_string." ORDER BY 3 DESC ";
  $query = $this->db->query($sql_string);
  $shoe_arr=$query->result_array();

}
}
?>
