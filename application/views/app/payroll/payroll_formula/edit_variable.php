<div class="modal-header bg-warning">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Edit <?php echo $var->variable_name ?></h4>
</div>
<div class="modal-body">

<form action="<?php echo base_url()?>app/payroll_formula/update_variable" method="post" id="edit_var_form">
	<input type="hidden" name="variable_id" id="variable_id" value="<?php echo $var->variable_id ?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="variable_abbrv">Abbrv</label>
				<input type="text" class="form-control" name="variable_abbrv" id="variable_abbrv_edit" value="<?php echo $var->variable_abbrv?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="variable_name">Variable Name</label>
		<input type="text" class="form-control" name="variable_name" id="variable_name_edit" value="<?php echo $var->variable_name?>">
	</div>
	<div class="form-group">
		<label for="variablee">Variable</label>
		<input type="text" class="form-control" name="variable" id="variable_edit" value="<?php echo $var->variable?>">
	</div>

</form>
</div>