<div class="col-md-4">
  <div class="form-group">
    <form action="<?php echo base_url()?>app/payroll_formula/view_formula_setup" method="post" id="view_setup">

<div class="form-group">
	<!-- <label for="">Company</label> -->
	<h4><strong><?php echo $company->company_name ?></strong></h4>
    <input type="hidden" class="form-control" name="company_name" id="company_name" placeholder="<?php echo $company->company_name ?>" value="" readonly="readonly">
	<input type="hidden" class="form-control" name="company_id" id="company_id" value="<?php echo $company->company_id ?>" readonly="readonly">
</div>

<!-- <div class="form-group">
	<?php //if (!$locations): ?>
		<input type="text" class="form-control bg-red" id="location_id" readonly="readonly" value="No Location/s Set">
	<?php //else: ?>
		<select name="location_id" id="location_id" class="form-control">
			<option value="" disabled selected>-Select Location-</option>
			<?php //foreach ($locations as $location): ?>
				<option value="<?php //echo $location->location_id ?>"><?php //echo $location->location_name ?></option>
			<?php //endforeach ?>
		</select>
	<?php//endif ?>
</div> -->

<!-- <div class="form-group">
	<?php //if (!$classifications): ?>
		<input type="text" class="form-control bg-red" id="classification_id" readonly="readonly" value="No Classification/s Set">
	<?php// else: ?>
		<select name="classification_id" id="classification_id" class="form-control">
			<option value="" disabled selected>-Select Classification-</option>
			<?php //foreach ($classifications as $classification): ?>
				<option value="<?php //echo $classification->classification_id ?>"><?php //echo $classification->classification ?></option>
			<?php //endforeach ?>
		</select>
	<?php //endif ?>		
</div> -->

<div class="form-group">
	<select name="employment_id" id="employment_id" class="form-control">
		<option value="" disabled selected>-Select Employment-</option>
		<?php foreach ($employmentList as $employment): ?>
		<option value="<?php echo $employment->employment_id ?>"><?php echo $employment->employment_name ?></option>
		<?php endforeach ?>
	</select>
</div>

<div class="form-group">
	<select name="pay_type_id" id="pay_type_id" class="form-control">
		<option value="" disabled selected>-Select Pay Type-</option>
		<?php foreach ($paytypeList as $pay_type): ?>
		<option value="<?php echo $pay_type->pay_type_id ?>"><?php echo $pay_type->pay_type_name ?></option>
		<?php endforeach ?>
	</select>
</div>

<div class="form-group">
	<select name="salary_rate_id" id="salary_rate_id" class="form-control">
		<option value="" disabled selected>-Select Salary Rate-</option>
		<?php foreach ($salaryRateList as $salary_rate): ?>
		<option value="<?php echo $salary_rate->salary_rate_id ?>"><?php echo $salary_rate->salary_rate_name ?></option>
		<?php endforeach ?>
	</select>
</div>
<?php if (!$classifications || !$locations): ?>
	<a class="btn btn-link pull-right text-warning" data-toggle="modal" data-target="#search_modal">Select Another Company</a>
<?php else: ?>	
	<a class="btn btn-sm bg-maroon pull-right" id="btnView" onclick="getFormulaSetup()"><i class="fa fa-calculator"></i> View Payroll Formula</a> 
	<a class="btn btn-link pull-right text-warning" data-toggle="modal" data-target="#search_modal">Select Another Company</a>
<?php endif ?> 
	</form>
  </div>
</div>

<div class="col-md-8" id="col_8">
  
</div>