<?php
$pay_type_id=$this->uri->segment('4');
$company_id=$this->uri->segment('5'); 

?>		

		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">Employee Group</label>
				<div class="col-sm-7" >
					<select name="pay_type_group" class="form-control" id="pay_type_group"  required onchange="check_cutoff();">
					<option disabled selected="">Select Group</option>
					<?php
					$pay_per_group=$this->time_payroll_period_model->get_active_payroll_period_groups($company_id,$pay_type_id);
					 foreach($pay_per_group as $group){
					 	
			echo '<option value="'.$group->payroll_period_group_id.'">'.$group->group_name.'</option>';
					}
					?>

					</select>
				</div>
		</div>	