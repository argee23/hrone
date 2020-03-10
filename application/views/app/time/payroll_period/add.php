<div class="well">
<!-- form start -->
<?php $company_id=$this->uri->segment('4'); 

$cname=$this->general_model->get_company_info($company_id);
$comp_name=$cname->company_name;

?>

<div class="box-header">
<i class="fa fa-info-circle"></i> <?php echo $comp_name;?> <i class="fa fa-arrow-right"></i> 
<strong> Create New Payroll Period </strong>

 </div>
<div class="box-body">
<form name="" method="post" action="<?php echo base_url()?>app/time_payroll_period/save_add" >
<input type="hidden" id="company_id" value="<?php echo $company_id?>" name="company_id">


		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">Pay Type<?php echo $system_defined_icons->required_marked;?></label>
				<div class="col-sm-7" >
					<select name="pay_type" class="form-control" id="pay_type"  required onchange="comp_pay_type_group();">
					<option disabled selected="">Select Pay Type</option>
					<?php
					 foreach($paytypeList_dtr as $pay_type){
					 	
			echo '<option value="'.$pay_type->pay_type_id.'">'.$pay_type->pay_type_name.'</option>';
					}
					?>

					</select>
				</div>
		</div>	

		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">Date From<?php echo $system_defined_icons->required_marked;?></label>
				<div class="col-sm-7" >
					<input type="date" name="date_from" placeholder="Date From" class="form-control" required>
				</div>
		</div>
		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">Date To<?php echo $system_defined_icons->required_marked;?></label>
				<div class="col-sm-7" >
					<input type="date" name="date_to" placeholder="Date To" class="form-control" required>
				</div>
		</div>
		<div class="form-group"   >
			<label for="month_cover" class="col-sm-5 control-label">Cover Month<?php echo $system_defined_icons->required_marked;?></label>
				<div class="col-sm-7" >
					<select name="month_cover" id="month_cover" class="form-control"  required="" onchange="check_cutoff();">
					<option value="" selected disabled>Select (<span>make sure this is correct.</span>)</option>
					<?php
					for($M =1;$M<=12;$M++){
					echo "<option value='".$M."'>". date("F", mktime(0, 0, 0, $M, 10))."</option>";
					}
					?>
					</select> 
				</div>
		</div>
		<div class="form-group"  >
			<label for="cover_year" class="col-sm-5 control-label">Cover Year<?php echo $system_defined_icons->required_marked;?></label>
				<div class="col-sm-7" >
				
					<select name="year_cover" class="form-control"  required="" id="cover_year" onchange="check_cutoff()" >
					<option value="" selected disabled>Select (<span>make sure this is correct.</span>)</option>
					<?php
					$current_year=date("Y");
					$next_year=$current_year+1;
					if(!empty($oldestPayPeriod)){
						$startyear = $oldestPayPeriod->year_cover;
	           
						for($i =$next_year; $i >= $startyear ;$i--){
							echo '<option value='.$i.' '.$selected.'>'.$i.'</option>';
						}

					}else{
						echo '<option value="'.$current_year.'">'.$current_year.'</option>';
						echo '<option value="'.$next_year.'">'.$next_year.'</option>';
					}



					?>
					</select> 
				</div>
		</div>	

		<div class="form-group"   id="comp_pay_type_group">
				<label for="next" class="col-sm-5 control-label">Employee Group<?php echo $system_defined_icons->required_marked;?></label>
					<div class="col-sm-7" >
						<select name="pay_type_group" class="form-control" id="pay_type_group"  required >
						<option disabled selected="">Select Group</option>
						
						</select>
					</div>
		</div>	

		<div class="form-group"  id="pay_type_cutoff" ></div>

		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">Cut-Off Day<?php echo $system_defined_icons->required_marked;?></label>
				<div class="col-sm-7" >
					<input type="number" name="cut_off_day" placeholder="" class="form-control" required>
				</div>
		</div>

		<div class="form-group"   >
			<label for="pay_date" class="col-sm-5 control-label ">Pay Date</label>
				<div class="col-sm-7" >
					<input type="date" name="pay_date" placeholder="" class="form-control" required>
				</div>
		</div>
		<div class="form-group"   >
			<label for="pay_date" class="col-sm-5 control-label ">Description</label>
				<div class="col-sm-7" >
					<input type="text" name="description" placeholder="Description" class="form-control" required>
				</div>
		</div>




		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">&nbsp;&nbsp;&nbsp;</label>
				<div class="col-sm-7" >
				
					<button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
					<?php
					  echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Save';
					?>

					</button>
				</div>
		</div>
		

</div>

</div>


