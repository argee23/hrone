<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Settings</h4></ol>

<div class="col-md-12" style="margin-top: 30px;">

		<div class="col-md-12">
			<div class="col-md-3"></div>	
			<div class="col-md-6">
				<input type="text" name="setting_name" id="setting_name" class="form-control" placeholder="Input Setting Name : Only Serttech Can Manage This">
				<input type="hidden" id="setting_name_final">
				<button class="col-md-12 btn btn-sm btn-success" style="margin-top: 5px;" onclick="save_setting();">SAVE</button>
			</div>
			<div class="col-md-3"></div>
		</div>

		<br><br><br><br><br>
		<div class="box box-danger" class='col-md-12'></div>

<div class="col-md-12" id="action_view" style="margin-top:20px;">
	<table class="table table-bordered" id="setting">
		<thead>
				<tr class="danger">
					<th>ID</th>
					<th>Setting</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
		</thead>
		<tbody>
			<?php foreach($setting as $s)
			{?>
				<tr>
					<td><?php echo $s->id;?></td>
					<td>
						<div id="orig_setting<?php echo $s->id;?>">
							<?php echo $s->setting;?>
						</div>	
						<div id="upd_setting<?php echo $s->id;?>" style='display: none;'>
							<input type="text" class="form-control" id="setting<?php echo $s->id;?>" value="<?php echo $s->setting;?>">
							<input type="hidden" id="settingfinal<?php echo $s->id;?>">
						</div>
					</td>
					<td><?php if ($s->InActive==1){ echo "InActive"; } else{ echo "Active"; }?></td>
					<td>
						<div id="orig_action<?php echo $s->id;?>">
							<a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  onclick="action_setting('edit','<?php echo $s->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Update Setting'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

							<a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  onclick="action_setting('delete','<?php echo $s->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Downloadable Form'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

                            <?php if($s->InActive==1)
                            {?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to Enable Setting' onclick="action_setting('enable','<?php echo $s->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>' aria-hidden='true' data-toggle='tooltip' title='Click to Disable Setting' onclick="action_setting('disable','<?php echo $s->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } ?>
                        </div>

                        <div id="upd_action<?php echo $s->id;?>" style='display: none;'>
                        		<a style='cursor:pointer;color:green;'  onclick="action_setting('save_update','<?php echo $s->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to save setting changes'><i  class="fa fa-check fa-lg  pull-left"></i></a>
                        		<a style='cursor:pointer;color:red;'  onclick="action_setting('cancel','<?php echo $s->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  ><i  class="fa fa-times fa-lg  pull-left"></i></a>
                        </div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

</div>