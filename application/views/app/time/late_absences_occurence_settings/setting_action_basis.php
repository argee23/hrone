<div class="col-md-12" style="margin-top: 40px;">

	<div class="col-md-1"></div>
	<div class="col-md-10">
	<hr>
	<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/late_absences_occurence_settings/save_basis/<?php echo $company;?>">

		<table class="table table-bordered" id="setting">
				<thead>
						<tr class="danger">
							<th>Type</th>
							<th>Late</th>
							<th>Absence</th>
						</tr>
				</thead>

				<tbody>
						<tr>
							<td>Occurances</td>
							<td>
								<select class="form-control" name="occurance_late">
									<option <?php if(empty($setting_value) || $setting_value->occurence_late==0){ echo "selected"; }?> >no_setting</option>
									<?php foreach($setting as $s)
									{?>
										<option value='<?php echo $s->id;?>' <?php if(!empty($setting_value)){ if($setting_value->occurence_late==$s->id){ echo "selected"; } } ?> ><?php echo $s->setting;?></option>
									<?php }
									?>
								</select>
							</td>
							<td>
								<select class="form-control" name="occurance_absence">
									<option <?php if(empty($setting_value) || $setting_value->occurence_absence==0){ echo "selected"; }?> >no_setting</option>
									<?php foreach($setting as $s)
									{?>
										<option value='<?php echo $s->id;?>' <?php if(!empty($setting_value)){ if($setting_value->occurence_absence==$s->id){ echo "selected"; } } ?> ><?php echo $s->setting;?></option>
									<?php }
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Total</td>
							<td>
								<select class="form-control" name="total_late">
									<option <?php if(empty($setting_value) || $setting_value->total_late==0){ echo "selected"; }?> >no_setting</option>
									<?php foreach($setting as $s)
									{?>
										<option value='<?php echo $s->id;?>' <?php if(!empty($setting_value)){ if($setting_value->total_late==$s->id){ echo "selected"; } } ?> ><?php echo $s->setting;?></option>
									<?php }
									?>
								</select>
							</td>
							<td>
								<select class="form-control" name="total_absence">
									<option <?php if(empty($setting_value) || $setting_value->total_absence==0){ echo "selected"; }?> >no_setting</option>
									<?php foreach($setting as $s)
									{?>
										<option value='<?php echo $s->id;?>' <?php if(!empty($setting_value)){ if($setting_value->total_absence==$s->id){ echo "selected"; } } ?> ><?php echo $s->setting;?></option>
									<?php }
									?>
								</select>
							</td>
						</tr>
				</tbody>
		</table>
		<?php
		if($time_late_abs_mng_settings=="hidden "){
			echo '<i class="btn btn-success fa fa-warning btn-sm pull-right" style="margin-top: 10px;" title="Not Allowed. Check Access Rights.">Save Changes</i>';
		}else{
			echo '<button class="btn btn-success btn-sm pull-right" style="margin-top: 10px;">Save Changes</button>';
		}
		?>
		
	</form>
	</div>

	<div class="col-md-1"></div>

</div>