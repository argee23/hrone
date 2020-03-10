<?php
		if($val=="sep_payroll"){
			echo '
			<label>Pay Date</label>
			<input type="date" class="form-control" name="pay_date" value="" required>';
		}else{
			$PayPeriod=$this->leave_conversion_model->getPayrollPeriod($payroll_period_group_id);
			echo '
			<label>Select Covered Payroll Period</label>
			<select class="form-control" name="pay_date">
			<option>Select Covered Payroll Period</option>
			';

			if(!empty($PayPeriod)){
				foreach($PayPeriod as $p){
					echo '<option value="'.$p->id."/".$p->complete_from." TO ".$p->complete_to.'">'.$p->complete_from.' TO '.$p->complete_to.' (description:'.$p->description.')</option>';
				}
			}else{

			}
			echo '
			</select>
				';
		}
?>