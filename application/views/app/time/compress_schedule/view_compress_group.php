 <?php

    /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $add_time_compress_group=$this->session->userdata('add_time_compress_group');
    $edit_time_compress_group=$this->session->userdata('edit_time_compress_group');
    $del_time_compress_group=$this->session->userdata('del_time_compress_group');
    $en_dis_time_compress_group=$this->session->userdata('en_dis_time_compress_group');
    $enroll_emp_time_compress=$this->session->userdata('enroll_emp_time_compress');
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */  


?>  
<input type="hidden" name="company_id" id="company_id" value="<?php echo $myComp->company_id;?>">


<div class="row">



    <div class="box box-primary">
        <div class="panel-heading"><strong>Compress Schedule Group
<a onclick="add_time_compress_group(<?php echo $myComp->company_id;?>)" type="button"  class="<?php echo $add_time_compress_group;?> btn btn-default btn-xs pull-right" title="Add">
<?php echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>	
</a>

        </div>
      <div class="panel-body">

<div class="table-responsive">
<table class="table table">
	<thead>
		<tr>
			<th>Group Name</th>
			<th>No Of Hrs</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php
if(!empty($CompGroup)){
	foreach($CompGroup as $c){

		$view_emp = '<i class="'.$enroll_emp_time_compress.' fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" data-toggle="tooltip" data-placement="left" title="Click to View Employees to this group" onclick="viewEnrolled('.$c->c_group_id.')"></i>';

		$enroll_emp = '<i class="'.$enroll_emp_time_compress.' fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" data-toggle="tooltip" data-placement="left" title="Click to Enroll Employees to this group" onclick="enroll_emp_time_compress('.$c->c_group_id.')"></i>';

		$edit = '<i class="'.$edit_time_compress_group.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_time_compress_group('.$c->c_group_id.')"></i>';

		$delete = anchor('app/time_compress_schedule/del_time_compress_group/'.$c->c_group_id.'/'.$c->compress_group_name,'<i class="'.$del_time_compress_group.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$c->compress_group_name."?')"));

		$enable =anchor('app/time_compress_schedule/en_dis_time_compress_group/'.$c->c_group_id.'/'.$c->InActive.'/'.$c->compress_group_name,'<i class="'.$en_dis_time_compress_group.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Enable','onclick'=>"return confirm('Are you sure you want to Enable ".$c->compress_group_name."?')"));

		$disable =anchor('app/time_compress_schedule/en_dis_time_compress_group/'.$c->c_group_id.'/'.$c->InActive.'/'.$c->compress_group_name,'<i class="'.$en_dis_time_compress_group.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Disable Instead of Delete','onclick'=>"return confirm('Are you sure you want to Disable ".$c->compress_group_name."?')"));

		if($c->InActive>0){
			$edit="";
			$delete="";
			$disable="";
			$enroll_emp="";
		}else{
			$enable="";
		}

		if($c->allow_per_hour_filing==1){ $setting = 'yes'; } else{ $setting = 'no'; }

	echo '
		<tr>
			<td>'.$c->compress_group_name.'</td>
			<td>
<button data-toggle="collapse" class="btn btn-primary" data-target="#demo_'.$c->c_group_id.'">View Hrs No.</button>

<div id="demo_'.$c->c_group_id.'" class="collapse">
			Mon: <span class="text-danger">'.$c->c_mon.'</span><br>
			Tue: <span class="text-danger">'.$c->c_tue.'</span><br>
			Wed: <span class="text-danger">'.$c->c_wed.'</span><br>
			Thu: <span class="text-danger">'.$c->c_thu.'</span><br>
			Fri: <span class="text-danger">'.$c->c_fri.'</span><br>
			Sat: <span class="text-danger">'.$c->c_sat.'</span><br>
			Sun: <span class="text-danger">'.$c->c_sun.'</span><br><br>
			Number of hours to count tardiness as half day absent: <span class="text-danger">'.$c->count_as_halfday_due_to_late.'</span><br><br>
			Number of hours to count under time as half day absent: <span class="text-danger">'.$c->count_as_halfday_due_to_ut.'</span><br><br>
			Required Actual Hrs rendered of halfday employees: <span class="text-danger">'.$c->halfday_required_hrs.'</span><br><br>
			Allow per hour leave filing: <span class="text-danger">'.$setting.'</span><br>
</div>



			</td>
			<td>'.$edit.' '.$delete.' '.$enable.' '.$disable.' '.$enroll_emp.' '.$view_emp.'</td>
		</tr>
	';
	}

}else{
	echo '
	<tr><td colspan="8">No Group Yet.</td></tr>
	';
}

?>

		<tr>
			<td></td>
		</tr>
	</tbody>

</table>
</div>


      </div>
    </div>

    </div>