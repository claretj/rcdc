<?php
include("header.php");
include("funcs.php");
?>
<html>
<head>
<title>Calendar</title>
</head>
<body>
<script language="Javascript">
  function getCal(dateStr) {
    document.MyForm.date.value=dateStr;
    document.MyForm.submit();
  }
</script>

<h3>
<?php
  $monday=time() - (date('N')-1)*86400;
  echo "Week of ".date("F d Y",$monday); 
?></h3>

<form name="MyForm" action="run_entry.php" method="post">
<input type="hidden" name="action" value="view">
<input type="hidden" name="date">
<table border='1'>
  <tr>
  <?php
    $sunday=$monday + 7*86400;
    for ($i=0; $i<=6; $i++) {
      echo "<th>".date('l',$monday+$i*86400)."</th>";
    }
  ?>
  </tr>
  <tr valign='top'>

<?php
  $con = mysql_connect('claretj.startlogicmysql.com', 'claret', 'bogota11');
  if (!$con)  {
    die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("claret", $con);
  $week_distance=0;
  for ($i=0; $i<=6; $i++) {
    $this_date=$monday+$i*86400;
    $sql="SELECT c.descr course_descr, run.distance, run.time_sec, run.comments ".
        "FROM run, course c ".
        "WHERE run.rundate = '".date('Y-m-d',$this_date)."' ".
        "AND run.course_id = c.id ";
    $result = mysql_query($sql);
    if ($result){
      $row = mysql_fetch_array($result);
      $distance=$row['distance'];
      if ($distance>0){
        $distanceStr=$distance." miles";
        $week_distance+=$distance;
        $time_sec=$row['time_sec'];
        getTimeStr($time_sec,$timeStr);
        $pace_sec=floor($time_sec/$distance);
        getTimeStr($pace_sec,$paceStr);

        echo "<td><a href='javascript:getCal(\"".date('Y-m-d',$this_date)."\")'>[".date('M j',$this_date).
             "]</a><br>".$row['course_descr']."<br>".$distanceStr."<br>".$timeStr."<br>".
             $paceStr." min/mile<br>".$row['comments']."<br></td>";
      }else{
        echo "<td><a href='javascript:getCal(\"".date('Y-m-d',$this_date)."\")'>[".date('M j',$this_date)."]</a><br></td>";
      }

    }else{
      echo "&nbsp;";
    }
  }

    mysql_close($con);

  ?>
  </tr>
</table>
</form>
<?php
    echo "Total: ".$week_distance."&nbsp;miles";
?>
</body>
</html>