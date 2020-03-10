<div class="col-md-6">
	<div class="form-group">
	<label for="company">Select a Department</label>
		<select class="form-control" name="department" id="department" onchange="getSectionDepartment(this.value)" required>
		<option selected="selected" value="" disabled>~select a department~</option>
		<?php
			foreach($company_department as $department){
				if($_POST['department'] == $department->department_id){
					$selected = "selected='selected'";
				}else{
					$selected = "";
				}
			?>
			<option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
		<?php }?>
		</select>
	</div>
</div>