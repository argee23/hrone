<div class="well">
<!-- form start -->
<?php $company_id=$pay_per_group->company_id; 

$cname=$this->general_model->get_company_info($company_id);
$comp_name=$cname->company_name;

?>

<div class="box-header">

<i class="fa fa-info-circle"></i> <?php echo $comp_name;?> <i class="fa fa-arrow-right"></i> 
<strong> Modify Payroll Period Employee Group </strong>


 </div>
<div class="box-body">
<form name="" method="post" action="<?php echo base_url()?>app/time_payroll_period/modify_payroll_period_group" >
<input type="hidden" value="<?php echo $this->uri->segment('4');?>" name="payroll_period_group_id">
<input type="hidden" value="<?php echo $company_id?>" name="company_id">
		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">Pay Type</label>
				<div class="col-sm-7" >
					<select name="pay_type" class="form-control" id="pay_type"  required >
					<option  value="<?php echo $pay_per_group->pay_type;?>" selected=""><?php echo $pay_per_group->pay_type_name;?></option>
<!-- 					<option disabled >&nbsp;</option> -->
					<?php
			// 		 	foreach($paytypeList_dtr as $pay_type){					 	
			// echo '<option value="'.$pay_type->pay_type_id.'">'.$pay_type->pay_type_name.'</option>';
			// 			}
					?>

					</select>
				</div>
		</div>	

		<div class="form-group"   >
			<label for="pay_date" class="col-sm-5 control-label ">Group Name</label>
				<div class="col-sm-7" >
					<input type="text" name="group_name" placeholder="group_name" class="form-control" required value="<?php echo $pay_per_group->group_name;?>">
				</div>
		</div>
		<div class="form-group"   >
			<label for="pay_date" class="col-sm-5 control-label ">Description</label>
				<div class="col-sm-7" >
					<input type="text" name="group_description" placeholder="Group Description" class="form-control" required value="<?php echo $pay_per_group->group_description;?>">
				</div>
		</div>

		<div class="form-group"   >
			<label for="next" class="col-sm-5 control-label">&nbsp;&nbsp;&nbsp;</label>
				<div class="col-sm-7" >
					<!-- <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button> -->
			
					<button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
					<?php
					  echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Modify';
					?>

					</button>


				</div>
		</div>
		</form>
</div>




</div>