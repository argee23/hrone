		<div class="form-group">
			<label>Select Department</label>
		    <select class="form-control select2" name="department" style="width: 100%;" onchange="getSection(this.value)">
		      <option selected="selected" disabled="disabled" value="">-Choose Department-</option>
		      <?php 
		        foreach($departmentList as $department){
		        ?>
		        <option value="<?php echo $department->department_id;?>"><?php echo $department->dept_name;?></option>
		        <?php }?>
		    </select> 
		 </div>
		 <div id="section"></div>