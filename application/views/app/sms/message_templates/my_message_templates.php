<?php

    /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $add_mess_temp=$this->session->userdata('add_mess_temp');
    $edit_mess_temp=$this->session->userdata('edit_mess_temp');
    $en_dis_mess_temp=$this->session->userdata('en_dis_mess_temp');
    $del_mess_temp=$this->session->userdata('del_mess_temp');
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */  


?>
<input type="hidden" name="company_id" id="company_id" value="<?php echo $myComp->company_id;?>">
<div class="col-md-12" id="add_mess_temp">


</div>
<div class="col-md-12">
	<div class="panel panel-success">
	<!-- Default panel contents -->
	<div class="panel-heading"><strong><?php echo $myComp->company_name;?>
		
<a onclick="add_mess_temp()" type="button"  class="<?php echo $add_mess_temp;?> btn btn-default btn-xs pull-right" title="Add">
<?php echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>	
</a>

	</strong></div>

		<div class="panel panel-body">

			<div class="table-responsive">
				<table class="table table">
					<thead>
						<tr>
							<th>Key Topic</th>
							<th>Message Template</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
				<tbody>
					<?php
					if(!empty($messTemp)){
						foreach($messTemp as $m){
							$message_template=$m->message_template;
							$message_key_topic=$m->message_key_topic;


		$edit = '<i class="'.$edit_mess_temp.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_mess_temp('.$m->id.')"></i>';

		$delete = anchor('app/sms/del_mess_temp/'.$m->id.'/'.$m->message_key_topic,'<i class="'.$del_mess_temp.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete?')"));

		$enable =anchor('app/sms/en_dis_mess_temp/'.$m->id.'/'.$m->InActive,'<i class="'.$en_dis_mess_temp.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Enable','onclick'=>"return confirm('Are you sure you want to Enable?')"));

		$disable =anchor('app/sms/en_dis_mess_temp/'.$m->id.'/'.$m->InActive,'<i class="'.$en_dis_mess_temp.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Disable Instead of Delete','onclick'=>"return confirm('Are you sure you want to Disable ?')"));


		if($m->InActive>0){
			$edit="";
			$delete="";
			$disable="";
			$enroll_emp="";
			$status_text="InActive";
		}else{
			$enable="";
			$status_text="Active";
		}

							echo '
								<tr>
									<td>'.$message_key_topic.'</td>
									<td>'.nl2br($message_template).'</td>
									<td>'.$status_text.'</td>
									<td>'.$edit.$delete.$enable.$disable.'</td>
								</tr>
							';
						}
					}else{

					}
					?>
				</tbody>
				</table>
			</div>

		</div>
	</div>
</div>