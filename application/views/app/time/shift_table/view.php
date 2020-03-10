<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_shift=$this->session->userdata('add_shift');
$edit_shift=$this->session->userdata('edit_shift');
$delete_shift=$this->session->userdata('delete_shift');

/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>


<div class="row">
	<div class="col-md-8">
		<div class="panel panel-success">
		  <!-- Default panel contents -->
		  <div class="panel-heading">   <strong>
		  <i class="fa fa-<?php echo $system_defined_icons->icon_info.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_info_color.';"';?> "></i>
			<?php 
			//$key_location="1";
			   $company_id =$this->uri->segment('4');
			   $current_comp=$this->time_shift_table_model->get_company($company_id);
			   if(!empty($current_comp)){
			   		echo $company_name = $current_comp->company_name;
			   }else{
			   		echo $company_name="classification not exist";
			   }
			
		   ?>
		</strong>

<br>
<a onclick="add_cf(<?php echo $company_id;?>)" type="button" class="<?php echo $add_shift;?> btn btn-xs btn-default pull-right" data-toggle="tooltip" data-placement="right" title="Add Working Schedule (Controlled Flexi)"><i class="fa fa-<?php echo $system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';"';?>"></i> Controlled Flexi</a>

<a onclick="add_ws_rd_hol(<?php echo $company_id;?>)" type="button" class="<?php echo $add_shift;?> btn btn-xs btn-default pull-right " data-toggle="tooltip" data-placement="right" title="Add Working Schedule -Rest day/Holiday"><i class="fa fa-<?php echo $system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';"';?>"></i> Rest day/Holiday</a>

<a onclick="add_wshd(<?php echo $company_id;?>)" type="button" class="<?php echo $add_shift;?> btn btn-xs btn-default pull-right" data-toggle="tooltip" data-placement="right" title="Add Working Schedule (Half Day)"><i class="fa fa-<?php echo $system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';"';?>"></i> Half Day</a>

<a onclick="add_wsc(<?php echo $company_id;?>)" type="button" class="<?php echo $add_shift;?> btn btn-xs btn-default pull-right" data-toggle="tooltip" data-placement="right" title="Add Working Schedule (Regular/Wholeday)"><i class="fa fa-<?php echo $system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';"';?>"></i> Regular/Wholeday</a>



<!--  -->

		  </div>

<div class="panel-body">

<?php 
	$counter=0;
	foreach ($company_classifications as $classification){
	$counter++;
	$cl_name=$classification->classification;
	$cl_id=$classification->classification_id;

if($this->session->userdata('user_role')=="serttech"){
	$allowed=1;
}else{

	 $class_role=$this->general_model->check_classification_restriction($company_id,$cl_id);
	    if(!empty($class_role)){
	     		$allowed=1;
        }else{
                $allowed=0;
        }
}

if($allowed>0){
?>




	<div class="col-md-12">
		<div class="box box-default">
			<div class="box-header" >
			<strong>

<a class="btn btn-default" data-toggle="collapse" href="#collapse_manage_pp_<?php echo $cl_id;?>" aria-expanded="false" aria-controls="collapseExample" title="Click to view shift references"><i class="fa fa-<?php echo $system_defined_icons->icon_collapse.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_collapse_color.';"';?>"></i> Classification: <?php echo $cl_name; ?>
</a>

</strong>
			</div>
				<div class="box-body">
<div class="table-responsive">
<div class="col-md-12 collapse" id="collapse_manage_pp_<?php echo $cl_id;?>">

			<!-- //=====================regular schedule -->
			<table id="example<?php echo $counter;?>1" class="table table-hover table-striped">
				<thead >
				<tr>
					<th colspan="5" ><i class="fa fa-clock-o"></i> <span class="text-danger">Regular Schedules</span>
					</th>
				</tr>
					<tr>
						<th>Shift </th>
						<th>Break(s)</th>
						<th>Registered Hours</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$regular= $this->time_shift_table_model->view_working_sched_complete($company_id,$cl_id);

				if(!empty($regular)){
				foreach($regular as $w_sched_complete){?>
					<tr>
						<td><?php echo $w_sched_complete->time_in." to ".$w_sched_complete->time_out;?></td>

						<td width="30%">
						<?php echo "lunch break: ".$w_sched_complete->lunch_break;?>min(s).<br>
						<?php echo "1st break: ".$w_sched_complete->break_1;?>min(s).<br>
						<?php echo "2nd break: ". $w_sched_complete->break_2;?>min(s).<br>
						</td>
			
						<td><?php echo $w_sched_complete->no_of_hours;?> hr(s)</td>
						<td><?php echo $w_sched_complete->description;?></td>
						<td><?php 
						echo $edit = '<i class="'.$edit_shift.'fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" " data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_wsc('.$w_sched_complete->id.')"></i>';


						echo $delete = anchor('app/time_shift_table/delete_wsc/'.$w_sched_complete->id,'<i class="'.$delete_shift.'fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$w_sched_complete->time_in." to ".$w_sched_complete->time_out." working schedule?')"));
						?></td>
						
					</tr>	
				<?php } }
				else{
					?>				

					<?php } ?>	
				</tbody>
			</table>


			<!-- //=====================half schedule -->
			<table  id="example<?php echo $counter;?>2" class="table table-hover table-striped">
				<thead>
				<tr>
					<th colspan="5"><i class="fa fa-clock-o"></i> <span class="text-danger">Half Day Schedules</span>
						<!--// add_wshd: add working schedule reference half day -->
					<!-- 	<a onclick="add_wshd(<?php //echo $key_location;?>)" type="button" class="btn btn-sm btn-warning pull-right" data-toggle="tooltip" data-placement="left" title="Add Schedule"><i class="fa fa-plus"></i></a> -->
						</th>
				</tr>
					<tr>
						<th>Shift</th>
						<th>Break</th>
						<th>Registered Hours</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$wsr_half_day= $this->time_shift_table_model->view_working_sched_half($company_id,$cl_id);

				if(!empty($wsr_half_day)){
				 foreach($wsr_half_day as $w_sched_complete){?>
					<tr>
						<td><?php echo $w_sched_complete->time_in." to ".$w_sched_complete->time_out;?></td>
						<td><?php echo $w_sched_complete->break_1;?>min(s).</td>
						<td><?php echo $w_sched_complete->no_of_hours;?> hr(s)</td>
						<td><?php echo $w_sched_complete->description;?></td>
						<td><?php 
						echo $edit = '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" " data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_wshd('.$w_sched_complete->id.')"></i>';
						echo $delete = anchor('app/time_shift_table/delete_wshd/'.$w_sched_complete->id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$w_sched_complete->time_in." to ".$w_sched_complete->time_out." working schedule?')"));
						?></td>
						
					</tr>	
				<?php }
				}else{

					 ?>	
		
					<?php } ?>		
				</tbody>
			</table>

			<!-- //=====================Rest day auto match schedule -->
			<table  id="example<?php echo $counter;?>3" class="table table-hover table-striped">
				<thead>
				<tr>
					<th colspan="5" ><i class="fa fa-clock-o"></i> <span class="text-danger"> Rest day auto match schedule references</span>
					</th>
				</tr>
					<tr>
						<th>Shift</th>
						<th>Break(s)</th>
						<th>Registered Hours</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$wsr_rd_hol= $this->time_shift_table_model->view_working_sched_restday_holiday($company_id,$cl_id);

				if(!empty($wsr_rd_hol)){
				foreach($wsr_rd_hol as $w_sched_complete){?>
					<tr>
						<td><?php echo $w_sched_complete->time_in." to ".$w_sched_complete->time_out;?></td>
						<td>
						<?php echo "Lunch break: ". $w_sched_complete->lunch_break;?>min(s). <br>
						<?php echo "1st break: ".$w_sched_complete->break_1;?>min(s).<br>
						<?php echo "2nd break: ".$w_sched_complete->break_2;?>min(s).
						</td>
						<td><?php echo $w_sched_complete->no_of_hours;?> hr(s)</td>
						<td><?php echo $w_sched_complete->description;?></td>
						<td><?php 
						echo $edit = '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" " data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_ws_rd_hol('.$w_sched_complete->id.')"></i>';
						echo $delete = anchor('app/time_shift_table/delete_ws_rd_hol/'.$w_sched_complete->id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';""></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$w_sched_complete->time_in." to ".$w_sched_complete->time_out." working schedule?')"));
						?></td>
						
					</tr>	
				<?php } }
				else{
					?>				

					<?php } ?>	
				</tbody>
			</table>

			<!-- //=====================Rest day auto match schedule -->
			<table  id="example<?php echo $counter;?>3" class="table table-hover table-striped">
				<thead>
				<tr>
					<th colspan="5" ><i class="fa fa-clock-o"></i> <span class="text-danger"> Controlled Flexi Shift References</span>
					</th>
				</tr>
					<tr>
						<th>Shift</th>
						<th>Break(s)</th>
						<th>Registered Hours</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$wsr_cf_hol= $this->time_shift_table_model->view_working_sched_controlled_flexi($company_id,$cl_id);

				if(!empty($wsr_cf_hol)){
				foreach($wsr_cf_hol as $w_sched_complete){?>
					<tr>
						<td><?php echo $w_sched_complete->time_in." to ".$w_sched_complete->time_out;?></td>
						<td>
						<?php echo "Lunch break: ". $w_sched_complete->lunch_break;?>min(s). <br>
						<?php echo "1st break: ".$w_sched_complete->break_1;?>min(s).<br>
						<?php echo "2nd break: ".$w_sched_complete->break_2;?>min(s).
						</td>
						<td><?php echo $w_sched_complete->no_of_hours;?> hr(s)</td>
						<td><?php echo $w_sched_complete->description;?></td>
						<td><?php 
						
echo $edit = '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" " data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_controlled_flexi('.$w_sched_complete->id.')"></i>';

echo $delete = anchor('app/time_shift_table/delete_controlled/'.$w_sched_complete->id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';""></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$w_sched_complete->time_in." to ".$w_sched_complete->time_out." working schedule?')"));

						?></td>
						
					</tr>	
				<?php } }
				else{
					?>				

					<?php } ?>	
				</tbody>
			</table>




</div>

		</div>

<!--  -->
				</div>
		</div>
	</div>

<?php 
}else{

}


}// end foreach classification



?>

		
		</div>

		</div>
	</div>

	<div class="col-md-4" id="col_3">
		
	</div>
</div>
