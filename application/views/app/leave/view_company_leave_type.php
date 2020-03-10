         <?php
		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$add_leave_type=$this->session->userdata('add_leave_type');
		$edit_leave_type=$this->session->userdata('edit_leave_type');
		$delete_leave_type=$this->session->userdata('delete_leave_type');
		$disable_enable_leave_type=$this->session->userdata('disable_enable_leave_type');
		//$system_defined_icons = $this->general_model->system_defined_icons();
		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/

         ?>
          <div class="col-md-12">
              
    <div class="box box-primary">
      <div class="panel-heading"><strong><?php echo $cInfo->company_name;?> <i class="fa fa-arrow-right"></i>Leave Types</strong> 
		 <a onclick="addNewLeaveType()" class="<?php echo $add_leave_type;?> btn btn-default btn-xs pull-right" type="button"  title="Add">
		 	      <?php
		      echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
		      ?>  
		 </a>
 	  </div>

     <table id="user_table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Leave Type</th>
                    <th>Leave Code</th>
                    <th>Color Code</th>
                     <th>Taxable Beyond(for leaqve convertion)</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  
 if(!empty($default_leave_type)){
  foreach ($default_leave_type as $sys_def) {

    echo '
    <tr>
      <td> '.$sys_def->id.' </td>
      <td> '.$sys_def->leave_type.' </td>
      <td> '.$sys_def->leave_code.' </td>
      <td> '.$sys_def->color_code.' </td>
      <td> '.$sys_def->taxable_leave_beyond.' </td>
      <td> ';
    if($sys_def->IsDisabled == 0){ echo 'Enabled';}else{ echo 'Disabled';}
      echo ' </td>
      <td> System Default</td>
    </tr>
    ';
  

  }
 }else{

 }




                  foreach($leave_type as $leave_type){if($leave_type->IsDisabled == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                  <tr <?php if($leave_type->IsDisabled == 1){echo 'style="color:#999;""';}else{echo 'class="text-success"';} ?>>
                    <td><?php echo $leave_type->id?></td>
                    <td><?php echo $leave_type->leave_type; ?></td>
                    <td><a data-toggle="tooltip" data-placement="left" title="This is company id + user encoded leave code"><?php echo $leave_type->leave_code?></a></td>

                    <td style="background-color: <?php echo $leave_type->color_code?>"><?php //echo $leave_type->color_code?></td>
                    <td> <?php echo $leave_type->taxable_leave_beyond?> </td>
                    <td><?php echo $inactive?></td>
                    <td>

                    <?php 

        $edit = '<i class="'.$edit_leave_type.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editLeaveType('.$leave_type->id.')"></i>';

        $disable = anchor('app/leave_type/deactivate_leave_type/'.$leave_type->id,'<i class="'.$disable_enable_leave_type.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Deactivate','onclick'=>"return confirm('Are you sure you want to Deactivate leave type?')"));

        $enable = anchor('app/leave_type/activate_leave_type/'.$leave_type->id,'<i class="'.$disable_enable_leave_type.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'activate','onclick'=>"return confirm('Are you sure you want to Activate leave type?')"));

        $delete = anchor('app/leave_type/delete_leave_type/'.$leave_type->id,'<i class="'.$delete_leave_type.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete leave type?')"));


			if($leave_type->IsDisabled == 0){ 
			   echo $edit." ".$disable." ".$delete;
			}else{
			   echo $enable;
			}


                    ?>
                    </td>
                  </tr>
                  <?php }



                  ?>
                </tbody>
              </table>
           
    </div>

          </div>