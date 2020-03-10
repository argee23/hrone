<div class="form-group"  >
		<label for="department" class="col-sm-5 control-label">Department</label>
	<div class="col-sm-7">
		<select name="department" class="form-control" id="department_id"  required onchange="fetch_dep_sect(this.value)">
		
<?php
if(!empty($comp_div_dept)){

			echo '<option value="All" selected>All</option>';
			foreach($comp_div_dept as $dept){
				echo '<option value="'.$dept->department_id.'">'.$dept->dept_name.'</option>';
			}
}else{

			echo '<option value="no_data_yet" selected>warning : no department created yet.</option>';	
}

?>

		</select>
	</div>
</div>
