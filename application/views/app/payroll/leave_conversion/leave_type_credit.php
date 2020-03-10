
<form method="post" action="<?php echo base_url()?>app/leave_conversion/convert_credit/<?php echo $covered_year?>" target="_blank">
	<input type="hidden" value="<?php echo $leave_id;?>" name="leave_id">
	<input type="hidden" value="<?php echo $company_id;?>" name="company_id">
	<input type="hidden" value="<?php echo $payroll_period_group_id;?>" id="payroll_period_group_id">

	<div class="form-group">
	<label>Leave Conversion Covered Year</label>
<!-- 	<input type="text" class="form-control" disabled value="<?php //echo $covered_year;?>" name="covered_year"> -->
	<label class="text-danger">Release Type</label>
	<select class="form-control" name="releasing_type" onchange="fetch_parameter(this.value)">
		<option value="sep_payroll">Release Separately from regular payroll</option>	
		<option value="reg_payroll">Include in regular payroll</option>	
	</select>
	<label>Choose Other Addition Type <small><i>(Payroll > File Maintenance > Other Additions)</i></small></label>
	<select class="form-control" name="other_add_typ">
		<?php
		if(!empty($oa_typ)){
			foreach($oa_typ as $o){
				echo '
				<option value="'.$o->id.'">'.$o->other_addition_type.'</option>
				';
			}
		}else{}
		?>
		
	</select>
	
	<div id="processingVary">
		<label>Pay Date</label>
		<input type="date" class="form-control" name="pay_date" value="<?php echo date('Y-m-d');?>">	
	</div>
	


	<label>Choose System Action</label><br>
	<input type="radio" name="action" value="review" checked> Review Computation
	<input type="radio" name="action" value="save"> Save Computation	
	<input type="radio" name="action" value="reset"> Reset Computation
	</div>

	<table class="table">
		<thead>
			<tr>
				<th>Check Checkbox of Employees <br><input type="checkbox" name="case1" class="checkbox_stat" id="check_uncheck" onclick="toggle(this);"><span class="text-danger">Check | Uncheck All</span></th>
				<th>Name</th>
				<th>Available Credit</th>
				<th>For Cash Conversion</th>
				<th>Salary Information<br>
					<small><i>System will choose the last salary with effectivity date within the 'covered year' selected ,but you may change the salary reference by changing the selected.</i></small>
				</th>
			</tr>
		</thead>	
	<tbody>
	<?php
	$salary_amount=0;
	if(!empty($leave_credit)){
		foreach($leave_credit as $c){

			echo '
			<tr>
			<td><input type="checkbox" name="employeeselected[]" class="case" name="case" value="'.$c->employee_id."/".$c->first_name." ".$c->last_name."/".$c->pay_type."/".$c->employment."/".$c->taxcode.'"></td>
			<td><strong>'.$c->last_name.' '.$c->first_name.'</strong><br>dept:'.$c->dept_name.'<br>section:'.$c->section_name.'<br>classification:'.$c->classification_name.'</td>
			<td><input type="number" name="credit'.$c->employee_id.'" split="any" value="'.$c->available.'"></td>
			<td><input type="number" name="cash_convert'.$c->employee_id.'" split="any" value="'.$c->available.'" max="'.$c->available.'"></td>
			<td>';

			$sal_info=$this->leave_conversion_model->get_salary($c->employee_id);
		
			if(!empty($sal_info)){
				foreach($sal_info as $s){
					$salary_id=$s->salary_id;
					$date_effective=$s->date_effective;
					$salary_rate=$s->salary_rate;
					$salary_rate_name=$s->salary_rate_name;
					$salary_amount=$s->salary_amount;
					$no_of_hours=$s->no_of_hours;
					$no_of_days_monthly=$s->no_of_days_monthly;
					$no_of_days_yearly=$s->no_of_days_yearly;

					$salary_details="$salary_rate/$salary_rate_name/$salary_amount/$no_of_hours/$no_of_days_monthly/$no_of_days_yearly/$salary_id";

					echo '<input type="radio" value="'.$salary_details.'" name="salary_details'.$c->employee_id.'" checked>
					Salary Amount: '.$salary_amount.' | 
					Salary Rate: '.$salary_rate_name.'<br>
					';
				}
			}else{
				echo '<label class="text-danger">Notice: No found salary, <small><i>Review it at Payroll > Compensation </small></i></label>';
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
		<div class="col-md-9"></div>
		
		<div class="col-md-3">

			<button type="submit" onclick="return confirm('Are you sure you want to proceed?');" class="btn btn-success btn pull-right"><i class="fa fa-folder"></i> Generate</button>	
		</div>
	
</form>	