<?php
include("header.php");
include("funcs.php");
?>
<html>
<head>
   <title>Shoes</title>
</head>
<body>
<h3>Shoes</h3>

<?php

$con = mysql_connect('claretj.startlogicmysql.com', 'claret', 'bogota11');
if (!$con)  {
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("claret", $con);

//insert new row with that date
$sql_string="select shoe.descr,round(sum(run.distance)) distance,max(rundate) date ".
  "from shoe, run ".
  "where shoe.id=run.shoe_id ".
  "and shoe.status='A' ".
  "group by shoe.id ".
  "order by 3 desc";

$result = mysql_query($sql_string) or die(mysql_error());

while($row = mysql_fetch_array($result))  {
  echo $row['descr'] . ":".$row['distance'] . "<br>";
}


?>

</body>
</html>