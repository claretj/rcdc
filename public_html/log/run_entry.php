<?php
include("header.php");
include("funcs.php");
?>

<html>
<head>
   <title>Run Entry</title>
</head>
<body>
<?php
$action=$_POST["action"];
if ($action==NULL){
  $action='view';
}
$date=$_POST["date"];
if ($date==NULL){
  $date=date("Y-m-d");
}

$con = mysql_connect('claretj.startlogicmysql.com', 'claret', 'bogota11');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("claret", $con);

if ($action=='post'){
  $distance=$_POST['distance'];

  //delete row with that date
  $sql_string="delete from run where rundate='".$date."'";
  if (!mysql_query($sql_string,$con))  {
    die('Error: ' . mysql_error());
  }

  //insert new row with that date
  if ($distance>0){
    $hours=$_POST['hours'];
    $minutes=$_POST['minutes'];
    $seconds=$_POST['seconds'];
    $time_sec=$hours*3600+$minutes*60+$seconds;
    if ($hours==0){$hours="";}
    $seconds=str_pad($seconds, 2, "0", STR_PAD_LEFT);
    $course_id=$_POST['course_id'];
    $comments=$_POST['comments'];
    $run_type_id=$_POST['run_type_id'];
    $shoe_id=$_POST['shoe_id'];
    $sql_string="insert into run (rundate,distance,time_sec,course_id,comments,run_type_id,shoe_id) ".
      "values ('".$date."',".$distance.",".$time_sec.",".$course_id.", '". 
      $comments."',".$run_type_id.", ".
      $shoe_id."); ";
    if (!mysql_query($sql_string,$con))  {
      die('Error: ' . mysql_error());
    }

  }
}else{ //action=view
  $sql_string="select * from run where rundate='".$date."' ";
  $result = mysql_query($sql_string);
  if ($result){
    $row = mysql_fetch_array($result);
    $distance=$row['distance'];
    getHoursMinutesSeconds($row['time_sec'],$hours,$minutes,$seconds);
    if ($hours==0){$hours="";}
    if ($distance==0 || $distance==""){
      $minutes="";
      $seconds="";
    }else{
      $seconds=str_pad($seconds, 2, "0", STR_PAD_LEFT);
      $course_id=$row['course_id'];
      $comments=$row['comments'];
      $run_type_id=$row['run_type_id'];
      $shoe_id=$row['shoe_id'];
    }
  }else{
    $distance="";
    $hours="";
    $minutes="";
    $seconds="";
  }
}

?>

<h3>Run Entry for <?php echo($date) ?></h3>

<form action=run_entry.php method=post>
<input type="hidden" name="action" value="post">
<input type="hidden" name="date" value="<?php echo $date; ?>">
  Course:
  <select name="course_id">
<?php
$sql_string="SELECT course.id, course.descr, max( rundate ) ".
"FROM course, run ".
"WHERE course.id = run.course_id ".
"AND course.status = 'A' ".
"GROUP BY course.id ".
"ORDER BY 3 DESC ";

$result = mysql_query($sql_string) or die(mysql_error());

while($row = mysql_fetch_array($result))  {
  if ($course_id==$row['id']){$selected=" selected='true'";}else{$selected="";}
  echo "<option value='" . $row['id'] . "'".$selected.">" . $row['descr'] . "</option>";
}

?>
  </select>

  <br>Run Type: 
  <select name="run_type_id">
<?php
$sql_string="SELECT rt.id, rt.descr ".
"FROM run_type rt ".
"ORDER BY sort_order asc ";

$result = mysql_query($sql_string) or die(mysql_error());

while($row = mysql_fetch_array($result))  {
  if ($run_type_id==$row['id']){$selected=" selected='true'";}else{$selected="";}
  echo "<option value='" . $row['id'] . "'".$selected.">" . $row['descr'] . "</option>";
}

?>
  </select>
  <br>Distance: <input type='text' name='distance' maxlength='4' size='4' value='<?php echo $distance ?>'> miles
  <br>Time: <input type='input' maxlength='1' size='1' name='hours' value='<?php echo $hours ?>'>:
            <input type='input' maxlength='2' size='3' name='minutes' value='<?php echo $minutes ?>'>:
				<input type='input' maxlength='2' size='3' name='seconds' value='<?php echo $seconds ?>'>
  <table border='0' cellspacing='0'>
  <tr>
  <td valign='top'>Comments: </td>
  <td><textarea name='comments' rows='1'><?php echo $comments ?></textarea></td>
  </tr>
  </table>
  <br>Shoe: 
  <select name="shoe_id" value="<?php echo($shoe_id) ?>">
<?php
$sql_string="SELECT shoe.id, shoe.descr, max( rundate ) end ".
"FROM shoe, run ".
"WHERE shoe.id = run.shoe_id ".
"AND shoe.status = 'A' ".
"GROUP BY shoe.id ".
"ORDER BY 3 DESC ";

$result = mysql_query($sql_string) or die(mysql_error());

while($row = mysql_fetch_array($result))  {
  if ($shoe_id==$row['id']){$selected=" selected='true'";}else{$selected="";}
  echo "<option value='" . $row['id'] . "'".$selected.">" . $row['descr'] . "</option>";
}

mysql_close($con);
?>
  </select>
<input type='submit' value='Enter'>
</form></body>

</html>