  
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="table_home">
          <thead>
            <tr>
              <th width="10%">COVERED DATE</th>       
              <th width="10%">TIME IN DATE</th>             
              <th width="10%">TIME IN</th>                  
              <th width="10%">BREAK OUT</th>                
              <th width="10%">BREAK IN</th>                  
              <th >LUNCH OUT</th>                
              <th >LUNCH IN</th>   
              <th >BREAK OUT</th>                
              <th >BREAK IN</th>                         
              <th >TIME OUT DATE</th>                      
              <th >TIME OUT</th>
              <th>FILED(OB/TK)</th>
            </tr>
          </thead>
          <tbody>
<?php
if(!empty($cdlogs)){
		foreach($cdlogs as $cdlogs){
	echo '
	<tr>
	<td>'.$cdlogs->covered_date.'</td>
	<td>'.$cdlogs->time_in_date.'</td>
	<td>'.$cdlogs->time_in.'</td>
	<td>'.$cdlogs->break_1_out.'</td>
	<td>'.$cdlogs->break_1_in.'</td>
	<td>'.$cdlogs->lunch_break_out.'</td>
	<td>'.$cdlogs->lunch_break_in.'</td>
	<td>'.$cdlogs->break_2_out.'</td>
	<td>'.$cdlogs->break_2_in.'</td>
	<td>'.$cdlogs->time_out_date.'</td>
	<td>'.$cdlogs->time_out.'</td>
	<td>';
/*
ob
*/
$ob_forms=$this->my_dtr_model->check_ob($employee_id,$cdlogs->covered_date);
if(!empty($ob_forms)){
	$table_name="emp_official_business";
	$form_name="HR015";
	foreach ($ob_forms as $ob ) {
		$stat=$ob->status;
		if($stat=="approved"){
			$ob_class='class="text-success"';
		}else{
			$ob_class='class="text-danger"';
		}
			echo '<a href="'.base_url().'employee_portal/employee_transactions/view/'.$ob->doc_no.'/'.$table_name.'/'.$form_name.'" target="_blank" '.$ob_class.' >OB</a>';		
	}
}
/*
tk
*/

$tk_forms=$this->my_dtr_model->check_tk($employee_id,$cdlogs->covered_date);
if(!empty($tk_forms)){
	$table_name="emp_time_complaint";
	$form_name="HR025";
	foreach ($tk_forms as $tk ) {
		$stat=$tk->status;
		if($stat=="approved"){
			$ob_class='class="text-success"';
		}else{
			$ob_class='class="text-danger"';
		}
			echo '<a href="'.base_url().'employee_portal/employee_transactions/view/'.$tk->doc_no.'/'.$table_name.'/'.$form_name.'" target="_blank" '.$ob_class.' >TK</a>';		
	}
}







	echo '</td>
	</tr>
	';

}
}
?>
          </tbody>
        </table>
     
      </div><!--end of .table-responsive-->
    </div> <!-- row -->


  </div>