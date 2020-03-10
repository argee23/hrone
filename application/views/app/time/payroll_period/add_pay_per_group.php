<div class="well">
<!-- form start -->
<?php $company_id=$this->uri->segment('4'); 

$cname=$this->general_model->get_company_info($company_id);
$comp_name=$cname->company_name;

?>

<div class="box-header"><i class="fa fa-plus text-danger"></i> <strong>Create New Payroll Period Employee Group
<i class="fa fa-arrow-circle-right"></i> <?php echo $comp_name;?> 
</strong>
 </div>
<div class="box-body">
<form name="" method="post" action="<?php echo base_url()?>app/time_payroll_period/save_add_payroll_period_group" >
<input type="hidden" id="company_id" value="<?php echo $company_id?>" name="company_id">
		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">Pay Type</label>
				<div class="col-sm-7" >
					<select name="pay_type" class="form-control" id="pay_type"  required>
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
			<label for="pay_date" class="col-sm-5 control-label ">Group Name</label>
				<div class="col-sm-7" >
					<input type="text" name="group_name" placeholder="group_name" class="form-control" required>
				</div>
		</div>
		<div class="form-group"   >
			<label for="pay_date" class="col-sm-5 control-label ">Description</label>
				<div class="col-sm-7" >
					<input type="text" name="group_description" placeholder="Group Description" class="form-control" required>
				</div>
		</div>

		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">&nbsp;&nbsp;&nbsp;</label>
				<div class="col-sm-7" >
					<button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
				</div>
		</div>
		</form>
</div>




</div>