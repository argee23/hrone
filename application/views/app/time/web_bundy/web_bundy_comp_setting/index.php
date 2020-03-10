<?php

if(!empty($my_web_bundy)){
	$my_current_setting=$my_web_bundy->web_bundy_setting;
}else{
	$my_current_setting="";
}

?>


<form method="post" action="<?php echo base_url()?>app/time_web_bundy/save_comp_setting/<?php echo $this->uri->segment("4");?>" >


<div class="form-group col-md-6">
  <label for="company">Web Bundy Function Setting</label>
  <select class="form-control" name="web_bundy_setting" id="web_bundy_setting" required>
	<option selected="selected" value="" disabled>~Select Setting~</option>
    <?php

if(!empty($web_bundy_functionList)){
	foreach($web_bundy_functionList as $w){
		if($my_current_setting==$w->param_id){
			$sel="selected";
		}else{
			$sel="";
		}
		echo '<option value="'.$w->param_id.'" '.$sel.'>'.$w->cValue.'</option>';
	}
}else{

}


      ?>

  </select>
</div>


<div class="form-group col-md-12">
<?php
if($time_wb_update_settings=="hidden "){
?>
<button type="button" class="btn btn-success btn" disabled title="Not Allowed. Check Access Rights."><i class="fa fa-warning"></i> Save Policys</button>
<?php
}else{
?>
<button type="submit" class="btn btn-success btn"><i class="fa fa-floppy-o"></i> Save Policy</button>
<?php	
}
?>


</div>

</div>

</form>