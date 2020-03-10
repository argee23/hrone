<div class="col-md-6">
	<div class="form-group">
	<label for="company">Select a Section</label>
		<select class="form-control" name="section" id="section" onchange="getSubsectionSection(this.value)" required>
		<option selected="selected" value="" disabled>~select a section~</option>
		<?php
			foreach($department_section as $section){
				if($_POST['section'] == $section->section_id){
					$selected = "selected='selected'";
				}else{
					$selected = "";
				}
			?>
			<option value="<?php echo $section->section_id;?>" <?php echo $selected;?>><?php echo $section->section_name;?></option>
		<?php }?>
		</select>
	</div>
</div>