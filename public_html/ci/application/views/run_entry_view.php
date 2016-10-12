<html>
<head>
<?php
  include("header.php");
  $this->load->helper('url');
  $this->load->helper('form');
?>
   <title>Run Entry</title>
</head>

<html>
<body>

<div id="header">
<h1><a>Run Entry</a></h1>
</div>


<div mode="nowrap"  class="sec row" style="white-space: nowrap;"  >
  <a  class="white" id="Run Entry" >
    Run Entry for <?php echo($date_long) ?>
  </a>
</div>

<form action=<?php echo site_url("/run_entry/post_entry"); ?> method=post>
<?php echo form_hidden('date', $date); ?>
  Course:
<?php
foreach($course_arr as $row)  {
  $options[$row['id']]=$row['descr'];
}
echo form_dropdown('course_id', $options, $course_id);
?>

  <br>Run Type: 
<?php
$options=array();
foreach($run_type_arr as $row)  {
  $options[$row['id']]=$row['descr'];
}
echo form_dropdown('run_type_id', $options, $run_type_id);
?>
  <br>Shoe: 
<?php
$options=array();
foreach($shoe_arr as $row)  {
  $options[$row['id']]=$row['descr'];
}
echo form_dropdown('shoe_id', $options, $shoe_id);
?>
  <br>Distance: <input type='text' pattern='[0-9.]*' name='distance' maxlength='6' size='4' value='<?php echo $distance ?>'> miles
  <br>Time: <input type='number' pattern='[0-9]*' inputmode='numeric' max='99' size='1' name='hours' value='<?php echo $hours ?>'>:
            <input type='number' pattern='[0-9]*' inputmode='numeric' maxlength='2' size='3' name='minutes' value='<?php echo $minutes ?>'>:
				<input type='number' pattern='[0-9]*' inputmode='numeric' maxlength='2' size='3' name='seconds' value='<?php echo $seconds ?>'>
  <table border='0' cellspacing='0'>
  <tr>
  <td valign='top'>Comments: </td>
  <td><textarea name='comments' rows='1'><?php echo $comments ?></textarea></td>
  </tr>
  </table>
<input type='submit' value='Enter'>
</form>

</div>
</body>
</html>
