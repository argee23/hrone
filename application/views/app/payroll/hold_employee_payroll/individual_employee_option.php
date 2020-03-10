        <?php

		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");

		$comp_details=$this->general_model->get_company_info($company_id);
		$division_setting=$comp_details->wDivision;

        ?>

<div class="form-group"   >
		<label for="next" class="col-sm-5 control-label">Payrol Period</label>
	<div class="col-sm-7">
		<select name="pay_period" class="form-control" id="pay_period"  required >
		<?php
		if(!empty($pay_per_dtr)){
			foreach($pay_per_dtr as $pay_period){
				$df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
				$dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
				echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';
			}
		}else{
			echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';		

		}
		?>
		</select>
	</div>
</div>  


<div class="form-group col-sm-12" >
 <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Generate</button>
</div>
