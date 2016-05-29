<html>
<head>
<?php
  include("header.php");
  $this->load->helper('url');
?>
  <title>Month</title>
</head>
<body>

<div id="header">
<h1><a>Month</a></h1>
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

<form name="MyForm" action="<?php echo site_url("/run_entry/view_date"); ?>" method="post">
<input type="hidden" name="date">
</form>

<form name="NavForm" action="<?php echo site_url("/calendar_week/view_date"); ?>" method="post">
<input type="hidden" name="monday">
</form>


<!-- with table -->
<table  class="table" width="100%"  cellspacing="0"  >
  <tr>
    <td class="sec row nw" align="left" style="border-right: 1px solid #CFCFCF;">Week</td>
    <td  class="sec row nw" align="right">Mo</td>
    <td  class="sec row nw" align="right">Tu</td>
    <td  class="sec row nw" align="right">We</td>
    <td  class="sec row nw" align="right">Th</td>
    <td  class="sec row nw" align="right">Fr</td>
    <td  class="sec row nw" align="right">Sa</td>
    <td  class="sec row nw" align="right">Su&nbsp;</td>
    <td  class="sec row nw" align="right" style="border-left: 1px solid #CFCFCF;">&Sigma;&nbsp;</td>
  </tr>
<?php
  $iRow=0;
  foreach ($month_arr as $iWeek){
    if ($iRow++ % 2 ==0) {$tdclass="ind nw tL";}else{$tdclass="ind alt tL";}
    $week_arr=$iWeek['week_arr'];
    $week_distance=$iWeek['week_distance'];
?>
  <tr>
    <td class="<?php echo $tdclass ?>" align="left" style="border-right: 1px solid #CFCFCF;">
      <a href='javascript:getCal("<?php echo $iWeek['mondayYmd']; ?>")'><?php echo $week_arr[0]['dayMD'];?></a>
    </td>
<?php
  for ($i=0; $i<=6; $i++) {
    $today_style=$week_arr[$i]['is_today']=="Y"?"style='background-color: yellow;color: #780000;text-decoration:none'":"style='text-decoration:none'";
?>
    <td align="right" class="<?php echo $tdclass ?>">
    <a href='javascript:runEntry("<?php echo $week_arr[$i]['day'] ?>")'  <?php echo $today_style; ?>>
      <?php echo $week_arr[$i]['distanceStr']>0?round($week_arr[$i]['distanceStr'],1):"&nbsp;&nbsp;&nbsp;"; ?></a>
    </td>
<?php
  } //loop over days
?>
<?php
  //calc background color
  if (floor($week_distance)>=40) {$sum_color="background-color: gold; font-weight:bold;";}
  else if (floor($week_distance)>=30) {$sum_color="background-color: gold;";}
  else if (floor($week_distance)>=20) {$sum_color="background-color: silver;";}
  else{$sum_color="";}
?>
<td align="right" class="<?php echo $tdclass ?>" style="<?php echo $sum_color ?>border-left: 1px solid #CFCFCF;"><?php echo floor($week_distance); ?>&nbsp;</td>
</tr>
<?php
  } //loop over weeks
?>
</table>

</div>
</body>
</html>