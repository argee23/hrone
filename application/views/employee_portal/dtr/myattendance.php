<style type="text/css">
  h2 {
  text-align: center;
}

table caption {
  padding: .5em 0;
}

@media screen and (max-width: 767px) {
  table caption {
    border-bottom: 1px solid #ddd;
  }
}

.p {
  text-align: center;
  padding-top: 140px;
  font-size: 14px;
}
</style>
<div class="col-md-12">
 	<div class="panel panel-success">
	</div>
</div>

<div class="col-md-12">
 	<div class="panel panel-success">
 		<div class="panel-heading">
 		<b>My Attendance(s)</b>
 		</div>
 		<div class="panel-body">


		<div class="form-group"   >
				<label for="next" class="col-sm-2 control-label">Covered Year </label>
			<div class="col-sm-10">
				<select name="covered_year" class="form-control" id="covered_year" >
						<?php
						$cy=date('Y');
							if(!empty($sysYears)){
								foreach($sysYears as $s){
									if($cy==$s->year_cover){
										$sel="selected";
									}else{
										$sel="";
									}
									echo '<option value="'.$s->year_cover.'" '.$sel.'>'.$s->year_cover.'</option>';
								}
							}
						?>

				</select>
			</div>			
		</div>  
		<div class="form-group"   >
				<label for="next" class="col-sm-2 control-label">Covered Month </label>
			<div class="col-sm-10">
				<select name="covered_month" class="form-control" id="covered_month" >
					<?php
					for($m=1; $m<=12; ++$m){
						$cm=date('m');
						if($cm==$m){
							$selected="selected";
						}else{
							$selected="";
						}
    echo '<option value="'.sprintf("%02d", $m).'" '.$selected.'>'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
								}

					?>

				</select>
			</div>			
		</div>  
		<div class="form-group"   >
				<label for="next" class="col-sm-2 control-label">Covered Day </label>
			<div class="col-sm-10">
				<select name="covered_day" class="form-control" id="covered_day" >
					<?php
	echo '<option value="all">All</option>';				
					for($m=1; $m<=31; ++$m){
						$m=sprintf("%02d", $m);
						$cd=date('d');
						if($cd==$m){
							$selected="selected";
						}else{
							$selected="";
						}
    echo '<option value="'.$m.'" '.$selected.'>'.$m.'</option>';
								}

					?>
				</select>
			</div>			
		</div>  


			<div class="form-group"   >
			<label for="next" class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-10">
			<button onclick="view_my_attendance();" class="btn btn-success align-right col-md-2">
			Filter
			</button>
			</div>

 			</div>


<div id="show_att" >
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
?>
          </tbody>
        </table>
     
      </div><!--end of .table-responsive-->
    </div> <!-- row -->


  </div>

</div>





 		</div>

</div>



