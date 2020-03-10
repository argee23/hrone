<div class="modal-header bg-info">
<!-- 	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
	</span></button> -->

<!-- <a class="pull-right" href="<?php //echo base_url()?>app/payroll_formula/view_formula_setup/<?php //echo $company_id."/".$location_id."/".$classification_id."/".$employment_id."/".$pay_type_id."/".$salary_rate_id?>">&times;</a> -->

<a class="pull-right" href="<?php echo base_url()?>app/payroll_formula/view_formula_setup/<?php echo $company_id."/".$employment_id."/".$pay_type_id."/".$salary_rate_id?>">&times;</a>


	<h4 class="modal-title" id="myModalLabel">Edit <strong><?php echo $tier_name->formula_tier_name ?></strong> for <strong><?php echo strtoupper($company->company_name) ?></strong></h4>
</div>
<div class="modal-body">

<form action="<?php echo base_url()?>app/payroll_formula/update_setup_formula" method="post" id="edit_setup_formula">
	<input type="hidden" name="setup_id" id="setup_id" value="<?php echo $setup ?>">
	<input type="hidden" name="setup_formula" id="setup_formula" value="<?php echo $setup_formula ?>">
	<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id ?>">
<!-- 	<input type="hidden" name="location_id" id="location_id" value="<?php //echo $location_id ?>">
	<input type="hidden" name="classification_id" id="classification_id" value="<?php //echo $classification_id ?>"> -->
	<input type="hidden" name="employment_id" id="employment_id" value="<?php echo $employment_id ?>">
	<input type="hidden" name="pay_type_id" id="pay_type_id" value="<?php echo $pay_type_id ?>">
	<input type="hidden" name="salary_rate_id" id="salary_rate_id" value="<?php echo $salary_rate_id ?>">

	<div class="form-group">
		<?php if (!$tier_formulas): ?>
			<center><strong class="text-danger">NO FORMULAS AVAILABLE FOR <?php echo $tier_name->formula_tier_name ?></strong></center>
			<center><small>click <a href="#" data-toggle="modal" data-target="#payroll_formula" data-dismiss="modal">here</a> to add formula</small></center>
		<?php else: ?>
			<label for="<?php echo $setup_formula ?>">Select Formula</label>
			<select name="<?php echo $setup_formula ?>" id="<?php echo $setup_formula ?>" class="form-control">
				<option value="0" disabled="disabled" <?php if($id == 0){ echo "selected = 'selected'";} ?>>- None -</option>
				<?php foreach ($tier_formulas as $tier_formula): 
					if($tier_formula->formula_id == $id){
						$selected = "selected = 'selected'";
					}else{
						$selected = "";
					}
				?>
				<option value="<?php echo $tier_formula->formula_id?>" <?php echo $selected ?>><?php echo $tier_formula->formula_description?></option>					
				<?php endforeach ?>
			</select>
			<br>
			<a id="btnEditSetup" class="btn btn-sm btn-primary pull-right" onclick="edit_formula_setup()">Modify Formula</a>
		<?php endif ?>
	</div>

</form>
</div>
<div class="modal-footer"></div>