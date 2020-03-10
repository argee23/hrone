<div class="modal-header bg-danger">
	<h4 class="modal-title">Add Table for <strong><?php echo $company->company_name ?></strong></h4>
</div>

<div class="modal-body">
	<center><label for="" class="bg-info">SELECT PAY TYPE/S TABLE</label></center>
	<table class="table table-hover" id="mytable">
	<?php foreach ($paytypeList as $pay_type): ?>
		<tr>
		  <td align="center">
			 <label>
			  <input type="checkbox" name="pay_type[]" id="pay_type[]" value="<?php echo $pay_type->pay_type_id ?>"> <?php echo $pay_type->pay_type_name ?>
			 </label>
		  </td>
		</tr>
	<?php endforeach ?>
	</table>

	<center><label for="" class="bg-info">SELECT SALARY RATE/S</label></center>
	<table class="table table-hover" id="mytable">
	<?php foreach ($salaryRateList as $salary_rate): ?>
		<tr>
		  <td align="center">
			 <label>
			  <input type="checkbox" name="salary_rate[]" id="salary_rate[]" value="<?php echo $salary_rate->salary_rate_id ?>"> <?php echo $salary_rate->salary_rate_name ?>
			 </label>
		  </td>
		</tr>
	<?php endforeach ?>
	</table>

	<input type="hidden" name="company_id" id="company_id" value="<?php echo $company->company_id ?>">
</div>




