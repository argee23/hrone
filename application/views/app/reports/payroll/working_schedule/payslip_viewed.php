

<div class="table-responsive">
	<table id="print_table" class="table table">
		<thead>
			<tr>
				<th>Employee ID</th>
				<th>Name</th>
				<th>Viewed By the Employee</th>
			</tr>
		</thead>
		<tbody>
<?php
if(!empty($ws_data)){
	foreach($ws_data as $e){
		//pvl : payslip view log
		$pvl=$this->reports_payroll_model->check_payslip_view_log($e->employee_id,$type,$covered_month_from,$covered_month_to,$covered_year,$payroll_period);
		echo '
		<tr>
			<td>'.$e->employee_id.'</td>
			<td>'.$e->name.'</td>
			<td>';
				if(!empty($pvl)){
					foreach($pvl as $p){
						if(($p->viewed_by_employee=="")AND($p->viewed_by_admin!="")){//admin view
							$who_view="Admin :".$p->viewed_by_admin;
						}else{
							$who_view="Employee Itself";
						}
						echo $p->complete_from.' to '.$p->complete_to.' view on: '.$p->date_viewed.' by '.$who_view.'| ';
					}
				}else{
					echo "no details yet.";
				}

		echo '</td>
		</tr>
		';
	}
}else{

}
?>			
		</tbody>

	</table>	
</div>



