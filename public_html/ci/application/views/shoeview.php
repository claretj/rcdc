<html>
<head>
<?php include("header.php"); ?>
  <title>Shoes</title>
</head>
<body>
<div id="container">

<div id="header">
<h1><a>Shoes</a></h1>
</div>

<table  class="table" width="100%"  cellspacing="0">
  <tr>
    <td  class="sec row nw" width="5%">&nbsp;</td>
    <td  class="sec row nw" width="65%">Shoe</td>
    <td  class="sec row nw" width="10%" align="right">Miles</td>
    <td  class="sec row nw" width="10%" align="right">From</td>
    <td  class="sec row nw" width="10%" align="right">To&nbsp;</td>
  </tr>
<?php
  $iRow=0;
  foreach ($shoe_array as $row){
    if ($iRow % 2 ==0) {$tdclass="ind nw tL";}else{$tdclass="ind alt tL";}
    if ($row['distance']>450){
      $color='red';
    }else if ($row['distance']>350){
      $color='yellow';
    }else{
      $color='#00FF00';
    }
?>
  <tr>
    <td class="<?php echo $tdclass; ?>"  style="background:<?php echo $color; ?>">&nbsp;</td>
    <td class="<?php echo $tdclass; ?>"><?php echo $row['descr'] ;?></td>
    <td class="<?php echo $tdclass; ?>" align="right"><?php echo $row['distance'];?></td>
    <td class="<?php echo $tdclass; ?>" align="right"><?php echo $row['mindate'];?></td>
    <td class="<?php echo $tdclass; ?>" align="right"><?php echo $row['maxdate'];?>&nbsp;</td>
  </tr>
<?php
    $iRow++;
  }		
?>
</table>


<div id="container">
</body>
</html>