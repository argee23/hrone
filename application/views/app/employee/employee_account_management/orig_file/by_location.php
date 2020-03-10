<div class="col-md-12">
<div class="col-md-6">
	<div class="form-group">
	<label for="company">Select a Company</label>
		<select class="form-control" name="company" id="company" onchange="getLocation(this.value)" required>
		<option selected="selected" value="" disabled>~select a company~</option>
		<?php
			foreach($companyList as $company){
				if($_POST['company'] == $company->company_id){
					$selected = "selected='selected'";
				}else{
					$selected = "";
				}
			?>
			<option value="<?php echo $company->company_id;?>" <?php echo $selected;?>><?php echo $company->company_name;?></option>
		<?php }?>
		</select>
	</div>
</div>
</div>

<div id="location">
</div>