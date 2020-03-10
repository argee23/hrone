<?php

$add_reg_phone=$this->session->userdata('add_reg_phone');
		$edit_reg_phone=$this->session->userdata('edit_reg_phone');
		$del_reg_phone=$this->session->userdata('del_reg_phone');
		$en_dis_reg_phone=$this->session->userdata('en_dis_reg_phone');

?>


<div class="row">
	<div class="col-md-6">
		<div class="panel panel-success">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Manage Registered Mobile Phone</strong> <a onclick="add_reg_phone()" type="button"  class="<?php echo $add_reg_phone;?> btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
		  </a></div>


<table class="table table-hover table-striped">
<thead>
	<tr>
		<th>Phone ID</th>
		<th>Company</th>
		<th>Mobile Type</th>
		<th>Mobile No</th>
		<th>Option</th>
	</tr>
</thead>
<tbody>
	<?php

		foreach($RegPhones as $p){

		$edit = '<i class="'.$edit_reg_phone.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_reg_phone('.$p->id.')"></i>';

		$delete = anchor('app/sms/delete_reg_phone/'.$p->id.'/'.$p->app_mobile_no,'<i class="'.$del_reg_phone.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$p->mobile_type."?')"));


		$enable =anchor('app/sms/enable_disable_reg_phone/'.$p->id.'/'.$p->InActive,'<i class="'.$en_dis_reg_phone.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Enable','onclick'=>"return confirm('Are you sure you want to Enable ".$p->mobile_type."?')"));

		$disable =anchor('app/sms/enable_disable_reg_phone/'.$p->id.'/'.$p->InActive,'<i class="'.$en_dis_reg_phone.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Disable Instead of Delete','onclick'=>"return confirm('Are you sure you want to Disable ".$p->mobile_type."?')"));

		$check_locations='<button data-toggle="collapse" data-target="#demo'.$p->id.'">Click to Check Tagged Locations</button>';


		if($p->InActive=="1"){
			$en_dis=$enable;
		}else{
			$en_dis=$disable;
		}

		$mytaggedLoc=$this->sms_model->phone_locationList($p->id);

		echo '

<tr>
	<td colspan="5" align="center" class="bg-danger">
<div id="demo'.$p->id.'" class="collapse">
';
if(!empty($mytaggedLoc)){
	echo 'Tagged Locations:<br>';
	foreach($mytaggedLoc as $l){
	echo $l->location_name.'<br>';	
	}
}else{
	echo 'No tagged locations yet.';
}

echo '
</div>

		</td>
</tr>

		';

echo '
<tr>
	<td>'.$p->id.'</td>
	<td>'.$p->company_name.'</td>
	<td>'.$p->mobile_type.'</td>
	<td>'.$p->app_mobile_no.'</td>
	<td>'.$edit.' '.$delete.' '.$en_dis.' '.$check_locations.'</td>
</tr>

';
		// $this->table->add_row(
		// 	$p->id,
		// 	$p->company_name,
		// 	$p->mobile_type,
		// 	$p->app_mobile_no,
		// 	$edit.' '.$delete. ' '.$en_dis.' '.$check_locations
		// 	);
		// }
}

	?>

</tbody>
</table>



		</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
