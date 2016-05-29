<?php
class Shoe extends CI_Controller {

function view(){
  $this->load->database();

  $sql_string="select shoe.descr,round(sum(run.distance)) distance,DATE_FORMAT(max(rundate), '%c/%y') maxdate,DATE_FORMAT(min(rundate), '%c/%y') mindate, max(rundate) ".
  "from shoe, run ".
  "where shoe.id=run.shoe_id ".
  "and shoe.status='A' ".
  "group by shoe.id ".
  "union select shoe.descr,0,'N/A','N/A',null from shoe where id not in (select shoe_id from run)".
  "order by 5 desc ";

  $query = $this->db->query($sql_string);
                 
  $data['shoe_array']=$query->result_array();
  $this->load->view('shoeview', $data);
}
}
?>