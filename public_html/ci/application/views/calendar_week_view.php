<html>
<head>
<?php
  include("header.php");
  $this->load->helper('url');
?>
  <title>Calendar</title>
</head>
<body>

<div id="header">
<h1><a>Week</a></h1>
</div>

<script language="Javascript">
  function runEntry(dateStr) {
    document.MyForm.date.value=dateStr;
    document.MyForm.submit();
  }
  function getCal(dateStr) {
    document.NavForm.monday.value=dateStr;
    document.NavForm.submit();
  }
</script>

<div mode="nowrap"  class="sec row" style="white-space: nowrap;"  >
<a  class="white" id="Cal" >
  <a href='javascript:getCal("<?php echo $monday_prev_str ?>")'>&lt;</a>
  Week of <?php echo $monday_str; ?>
  <a href='javascript:getCal("<?php echo $monday_next_str ?>")'>&gt;</a>
</a>
</div>


<form name="MyForm" action="<?php echo site_url("/run_entry/view_date"); ?>" method="post">
<input type="hidden" name="date">
</form>

<form name="NavForm" action="<?php echo site_url("/calendar_week/view_date"); ?>" method="post">
<input type="hidden" name="monday">
</form>

<?php
  for ($i=0; $i<=6; $i++) {
    if ($i % 2 ==0){
      echo '<div class="ind" style="white-space: nowrap;"  >';
    }else{
      echo '<div class="ind alt" style="white-space: nowrap;"  >';
    }
?>
    <a href='javascript:runEntry("<?php echo $week_arr[$i]['day'] ?>")' >[<?php echo $week_arr[$i]['dayMD'] ?>]</a>&nbsp;&nbsp;<?php echo $week_arr[$i]['distanceStr']>0?$week_arr[$i]['course'].":&nbsp;".$week_arr[$i]['run_type']:"" ?><br>
          <?php echo $week_arr[$i]['distanceStr']>0?$week_arr[$i]['distanceStr']." miles @ ".$week_arr[$i]['paceStr']." min/mile = ".$week_arr[$i]['timeStr']:"" ?><br>
          <?php echo $week_arr[$i]['distanceStr']>0?$week_arr[$i]['comments']:"" ?>
  </div>
<?php
  }
  ?>
<hr>Total: <?php echo $week_distance ?>&nbsp;miles

</div>
</body>
</html>