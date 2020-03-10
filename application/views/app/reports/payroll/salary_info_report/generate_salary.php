<?php


echo '
	<div class="">
	<table id="table_home" class="">
	<thead>
		<tr>
			<th>Employee ID</th>
			<th>Name</th>';

if($sal_rep_typ=="1" OR $sal_rep_typ=="3"){
echo '		<th>Salary Amount</th>
			<th>Salary Rate</th>
			<th>Date Effective</th>
			<th>Hours A Day</th>
			<th>Days A Month</th>
			<th>Days A Year</th>
			<th>Is Salary Fixed</th>';
}else{

}


echo '			
		</tr>
	</thead>
<tbody>
';
if(!empty($emp_sal)){
	foreach($emp_sal as $s){

if($sal_rep_typ=="1" OR $sal_rep_typ=="3"){		
		if($s->is_salary_fixed=="1"){
			$fix_sal="YES";
		}else{
			$fix_sal="NO";
		}

		if($s->salary_rate=="1"){
			$salary_rate_name="piece rate";
		}elseif($s->salary_rate=="2"){
			$salary_rate_name="hourly rate";
		}elseif($s->salary_rate=="3"){
			$salary_rate_name="daily rate";
		}elseif($s->salary_rate=="4"){
			$salary_rate_name="monthly rate";
		}else{
			$salary_rate_name="";
		}
}else{

}

		echo '
			<tr>
				<td>'.$s->employee_id.'</td>
				<td>'.$s->name_lname_first.'</td>';

if($sal_rep_typ=="1" OR $sal_rep_typ=="3"){
		echo '	<td>'.$s->salary_amount.'</td>
				<td>'.$salary_rate_name.'</td>
				<td>'.$s->date_effective.'</td>
				<td>'.$s->no_of_hours.'</td>
				<td>'.$s->no_of_days_monthly.'</td>
				<td>'.$s->no_of_days_yearly.'</td>
				<td>'.$fix_sal.'</td>';
}else{
	
}
		echo '		</tr>
		';
	}
}else{
echo 'wala';
}

echo '
</tbody>

</table>
</div>';
?>