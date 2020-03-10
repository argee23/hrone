<div class="col-md-12" style="margin-top: 40px;">

<h4 class="text-danger"><center><?php echo $option;?> Late and Absence Settings </center></h4>

<div class="col-md-12" id="action_view">
	<table class="table table-bordered" id="setting">
		<thead>
				<tr class="danger">
					<th>Classification</th>
					<?php foreach($employmentList as $e){?>
					<th><?php echo $e->employment_name;?></th>
					<?php } ?>
				</tr>
		</thead>

		<tbody>
			<?php foreach($classification as $c){?>
				<tr>
					<td><?php echo $c->classification;?></td>
					<?php foreach($employmentList as $e){
						$checker = $this->late_absences_occurence_settings_model->get_settings_value($val,$company,$c->classification_id,$e->employment_id,$option);
					?>
						<td>
							<?php if(empty($checker)){ echo "0"; } else { echo $checker; }	 ?>
						</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="col-md-12" id="update_" style="margin-top: 10px;">
		<?php
		if($time_late_abs_mng_settings=="hidden "){
			echo '<button class="btn btn-sm pull-right btn-danger" title="Not Allowed. Check Access Rights."><i class="fa fa-warning"></i>&nbsp;Update</button>';
		}else{
			echo '<button class="btn btn-sm pull-right btn-info" onclick="update_settings();"><i class="fa fa-pencil"></i>&nbsp;Update</button>';
		}
		?>
	
	</div>

</div>



<div  id="action_update"  style="display: none;">
<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/late_absences_occurence_settings/save_settings/<?php echo $company."/".$val?>" >
<input type="hidden" name="type" id="type" value="<?php echo $option;?>">
<div class="col-md-12">
	<table class="table table-bordered">
		<thead>
				<tr class="danger">
					<th>Classification</th>
					<?php foreach($employmentList as $e){?>
					<th><?php echo $e->employment_name;?></th>
					<?php } ?>
				</tr>
		</thead>

		<tbody>
			<?php foreach($classification as $c){?>
				<tr>
					<td><?php echo $c->classification;?></td>
					<?php foreach($employmentList as $e){
						$checker = $this->late_absences_occurence_settings_model->get_settings_value($val,$company,$c->classification_id,$e->employment_id,$option);
					?>
						<td>
							<input type="number" class="form-control" name="value_<?php echo $c->classification_id.$e->employment_id;?>" value="<?php if(empty($checker)){ echo "no_setting"; } else{  echo $checker; }?>">
						</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="col-md-12" style="display: none;margin-top: 10px;" id="update_save">
	<a onclick="setting_action('<?php echo $company;?>','<?php echo $val;?>')" class="pull-right" style='margin-left: 5px;cursor:pointer;'><i class='fa fa-arrow-left'></i>Back</a>
	<button  type="submit" class="btn btn-sm pull-right btn-danger"><i class="fa fa-check"></i>&nbsp;Save Changes</button>
</div>
</form>
</div>



</div>