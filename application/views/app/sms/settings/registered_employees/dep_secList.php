<div class="form-group"  >
		<label for="section" class="col-sm-5 control-label">Section</label>
	<div class="col-sm-7">
		<select name="section" class="form-control" id="section_id"  required onchange="fetch_subsection(this.value)">
		
<?php
if(!empty($comp_dept_sect)){

			echo '<option value="All" selected>All</option>';
			foreach($comp_dept_sect as $sec){
				echo '<option value="'.$sec->section_id.'">'.$sec->section_name.'</option>';
			}
}else{

			echo '<option value="no_data_yet" selected>warning : no section created yet.</option>';	
}

?>

		</select>
	</div>
</div>
