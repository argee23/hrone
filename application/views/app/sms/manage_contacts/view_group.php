<?php

    /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $add_grouped_contact=$this->session->userdata('add_grouped_contact');
    $del_grouped_contact=$this->session->userdata('del_grouped_contact');
    $edit_grouped_contact=$this->session->userdata('edit_grouped_contact');
    $en_dis_grouped_contact=$this->session->userdata('en_dis_grouped_contact');
    $enroll_emp_grouped_contact=$this->session->userdata('enroll_emp_grouped_contact');
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */  


?>
<input type="hidden" name="company_id" id="company_id" value="<?php echo $myComp->company_id;?>">
<div class="col-md-12" id="add_grouped_contact">


</div>
<div class="col-md-12">
	<div class="panel panel-success">
	<!-- Default panel contents -->
	<div class="panel-heading"><strong><?php echo $myComp->company_name;?>
		
<a onclick="add_grouped_contact()" type="button"  class="<?php echo $add_grouped_contact;?> btn btn-default btn-xs pull-right" title="Add">
<?php echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>	
</a>

	</strong></div>

		<div class="panel panel-body">

			<div class="table-responsive">
				<table class="table table">
					<thead>
						<tr>
							<th>Group Name</th>
							<th>Description</th>
							<th>Action</th>
						</tr>
					</thead>
				<tbody>
					<?php
					if(!empty($MyGroupeCont)){
						foreach($MyGroupeCont as $m){
							$gn=$m->group_name;
							$gd=$m->group_desc;

		$enroll_emp = '<i class="'.$enroll_emp_grouped_contact.' fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" data-toggle="tooltip" data-placement="left" title="Click to Enroll Employees to this group" onclick="enroll_emp_grouped_contact('.$m->id.')"></i>';

		$edit = '<i class="'.$edit_grouped_contact.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_grouped_contact('.$m->id.')"></i>';

		$delete = anchor('app/sms/del_grouped_contact/'.$m->id.'/'.$m->group_name,'<i class="'.$del_grouped_contact.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$m->group_name."?')"));

		$enable =anchor('app/sms/en_dis_grouped_contact/'.$m->id.'/'.$m->InActive.'/'.$m->group_name,'<i class="'.$en_dis_grouped_contact.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Enable','onclick'=>"return confirm('Are you sure you want to Enable ".$m->group_name."?')"));

		$disable =anchor('app/sms/en_dis_grouped_contact/'.$m->id.'/'.$m->InActive.'/'.$m->group_name,'<i class="'.$en_dis_grouped_contact.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Disable Instead of Delete','onclick'=>"return confirm('Are you sure you want to Disable ".$m->group_name."?')"));







		if($m->InActive>0){
			$edit="";
			$delete="";
			$disable="";
			$enroll_emp="";
		}else{
			$enable="";
		}

							echo '
								<tr>
									<td>'.$gn.'</td>
									<td>'.$gd.'</td>
									<td>'.$edit.$delete.$enable.$disable.$enroll_emp.'</td>
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