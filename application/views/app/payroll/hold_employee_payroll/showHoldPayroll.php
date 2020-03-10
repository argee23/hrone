
<table class="table">
<thead>
    <tr>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Payroll Period</th>
        <th>Reason to Hold Employee Payroll</th>
        <th>Last Pay Status</th>

    </tr>
</thead>
<tbody>


<?php
if(!empty($showHoldPayroll)){
	foreach($showHoldPayroll as $s){
		$active_table=$this->payroll_hold_employee_model->checkActiveEmp($s->employee_id);
		if(!empty($active_table)){
			$name=$active_table->first_name." ".$active_table->last_name;

		}else{
			$inactive_table=$this->payroll_hold_employee_model->checkInActiveEmp($s->employee_id);
			if(!empty($inactive_table)){
				$name=$inactive_table->first_name." ".$inactive_table->last_name;
			}else{
				$name="unknown employee";
			}
		}

echo '
	<tr>
		<td>'.$s->employee_id.'</td>
		<td>'.$name.'</td>
		<td>'.$s->complete_from.' TO '.$s->complete_to.'</td>
		<td>'.$s->reason_name.'</td>
		<td></td>

	</tr>

';


	}
}else{

}


?>

</tbody>

</table>