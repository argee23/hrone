


<div class="datagrid">
<table  >
	<tbody>
	<?php

$ds=$this->time_dtr_model->get_processed_dtr_summary($company_id,$pay_period,$employee_id,$month_cover);
if(!empty($ds)){
	$dtr_status="Processed";
	$dtr_status_class='style="color:#000 !important;"';
	$absences_total=$ds->absences_total;
	$total_process++;
}else{
	$dtr_status="Not Yet Processed";
	$absences_total="";
	$dtr_status_class='style="color:#ff0000 !important;"';
	$total_unprocess++;
}

	echo '
		<tr >
			<td width="10%" '.$dtr_status_class.'>'.$employee_id.'</td>
			<td width="20%" '.$dtr_status_class.'>'.$name.'</td>
			<td width="10%" '.$dtr_status_class.'>'.$dtr_status.'</td>
		
		</tr>

	';
	//<th width="5%">'.$absences_total.'</th>
	?>


	</tbody>
</table>
</div>