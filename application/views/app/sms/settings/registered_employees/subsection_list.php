<div class="form-group"  >
		<label for="section" class="col-sm-5 control-label">Sub-Section</label>
	<div class="col-sm-7">
		<select name="sub_section" class="form-control" id="section_id"  required onchange="fetch_subsection(this.value)">
		
<?php
if($wSubsection=="1"){
	//echo "subsection is required";
		if(!empty($comp_subsection)){
			echo '<option value="All" selected>All</option>';
					foreach($comp_subsection as $s){
						echo '<option value="'.$s->subsection_id.'">'.$s->subsection_name.'</option>';
					}
		}else{

					echo '<option value="no_data_yet" selected>warning : no sub-section created yet.</option>';	
		}

}else{
	echo '<option value="ignore_me" selected>Just Ignore Me.(Above Section does not require SubSection)</option>';	
}




?>

		</select>
	</div>
</div>


