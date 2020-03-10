<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_fs_group=$this->session->userdata('add_fs_group');
$edit_fs_group=$this->session->userdata('edit_fs_group');
$delete_fs_group=$this->session->userdata('delete_fs_group');
$view_fs_group_mem=$this->session->userdata('view_fs_group_mem');
$deactivate_activate_fs_group=$this->session->userdata('deactivate_activate_fs_group');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>


<div class="row">
<div class="col-md-12">

<div class="box box-default">
<div class="panel panel-default">
  <div class="panel-heading">
  <strong><?php echo $company_name->company_name; ?></strong>
 
    <a onclick="add_group('<?php echo $this->uri->segment("4"); ?>')" type="button" class="<?php echo $add_fs_group;?> pull-right" data-toggle="tooltip" data-placement="left" title="Add Group">


<?php
echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>
    </a>
<!--     <br>
 <i class="fa fa-navicon"> Access Info </i>  -->
  </div>
  <div class="box-body">
  <div class="panel panel-default">
         <div class="box-body">
         <div class="row">

          <div class="col-md-12">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Group ID</th>
                <th>Group Name</th>
                <th>Created By</th>
                <th>Status</th>
                <th style="text-align:center;">Options</th>
              </tr>
            </thead>
            <tbody>
              <?php $check = false;
              foreach($company_group as $group){ ?>
              <tr 
              <?php 
              if($group->InActive==0){

              }else{
                echo 'class="text-danger"';
              }
              ?>
              >
                <input type="hidden" name="company_id" id="company_id" value="<?php echo $group->company_id; ?>">
                <td><?php echo $group->id; ?></td>
                <td><?php echo $group->group_name; ?></td>
                <td><?php 
                        $emp_id = $group->system_user;
                        $comp_id = $group->company_id;
                        $get_emp = $this->time_fixed_schedule_model->get_employee_name($comp_id,$emp_id);
                        if($get_emp == True){

                        echo $get_emp->last_name.','.$get_emp->first_name;
                        }else{
                          echo "";
                        }
                 ?></td>
                 <td><?php if($group->InActive == '0'){
                            echo "Active";      
                          }else{ echo "InActive"; } ?></td>
                <td style="text-align:center;float: center;">
                
                    <?php if($group->InActive === '0'){ ?>
                    <a href="<?php echo site_url('app/time_fixed_schedule/inactivate_group/'. $group->id.''); ?>" onClick="return confirm('Are you sure you want to inactivate group?')">
                    <i  class="<?php echo $deactivate_activate_fs_group;?> fa fa-<?php echo $system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x " style="color:'.$system_defined_icons->icon_disable_color.';"' ?>" data-toggle="tooltip" data-placement="left" title="Click to Disable/Deactivate"></i></a>&nbsp;
                  <?php }
                  if($group->InActive === '1'){ 
                    ?>
                    <a href="<?php echo site_url('app/time_fixed_schedule/activate_group/'. $group->id.''); ?>" onClick="return confirm('Are you sure you want to activate group?')">
                    <i  class="<?php echo $deactivate_activate_fs_group;?> fa fa-<?php echo $system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x " style="color:'.$system_defined_icons->icon_enable_color.';"' ?>" data-toggle="tooltip" data-placement="left" title="Click to Activate"></i></a>&nbsp;
                  <?php } ?>
                   &nbsp;
                  
                   <?php if($group->InActive === '0'){ ?>

                   <i class='fa fa-<?php echo $system_defined_icons->icon_view.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_view_color.';"';?> data-toggle='tooltip' data-placement='left' title='View member(s)' onclick="view_group_employee('<?php echo $group->id; ?>')"></i>&nbsp; 


                <i class='<?php echo $view_fs_group_mem;?> fa fa-calendar<?php echo " fa-".$system_defined_icons->icon_size."x";?>' <?php echo 'style="color:'.$system_defined_icons->icon_view_color.';"';?> data-toggle='tooltip' data-placement='left' title='View Employee(s) Schedule' onclick="employees_schedule('<?php echo $group->id; ?>')"></i>


                   <i class='<?php echo $edit_fs_group;?> fa fa-<?php echo $system_defined_icons->icon_edit.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_edit_color.';"';?> data-toggle='tooltip' data-placement='left' title='Edit group name' onclick="edit_group('<?php echo $group->id; ?>')"></i>&nbsp;

                   <a  class='<?php echo $delete_fs_group;?> fa fa-<?php echo $system_defined_icons->icon_delete.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_delete_color.';"';?> data-toggle="tooltip" data-placement="left" title="Delete Group" href="<?php echo site_url('app/time_fixed_schedule/delete_group/'. $group->id.''); ?>" onClick="return confirm('Are you sure you want to permanently delete group? note: All employee member will be removed as well.')"></a>&nbsp;

                    <?php }else{ ?>

                  <i class='fa fa-<?php echo $system_defined_icons->icon_view.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_view_color.';"';?> data-toggle='tooltip' data-placement='left' title='View member(s)' onclick="view_group_employee('<?php echo $group->id; ?>')"></i>&nbsp; 

                   <i class='fa fa-<?php echo $system_defined_icons->icon_edit.'  fa-'.$system_defined_icons->icon_size.'x'; ?> text-muted'   data-toggle='tooltip' data-placement='left' title='cannot edit: enable first' ></i>&nbsp;

                   <a  class='fa fa-<?php echo $system_defined_icons->icon_delete.'  fa-'.$system_defined_icons->icon_size.'x'; ?> text-muted'   data-toggle="tooltip" data-placement="left" title="cannot delete: enable first"></a>&nbsp;

                     <?php } ?>
                  
                  
                    

                </td>
              </tr>
              <?php $check = true; }
              if($check == false){?>
              <td>
                <p style="color:#ff0000;" class='text-center'><strong>No Group(s) yet.</strong></p>
              </td>
             <?php } ?>
            </tbody>
          </table>
          </div>


     </div> 
         </div><!-- /.box-body --> 
   </div>
   </div>


   <!-- <div id="philhealth_table_search">
   </div> -->


</div>
</div>  
</div>




<!-- <div class="row">
<div class="col-md-12">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong><?php echo $company_name->company_name; ?></strong>
    <a onclick="add_group('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add Group"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
    <a onclick="view_employee('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="View employee"><i class="fa fa-user fa-2x text-primary pull-right"></i></a>
    </div>
  <div class="box-body">
  <div class="panel panel-success">
         <div class="box-body">
         <div class="row">

          <div class="col-md-12">
         	<table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Group name</th>
                <th>Division</th>
                <th>Department</th>
                <th>Section</th>
                <th>Subsection</th>
                <th>Status</th>
                <th>Options</th>
              </tr>
            </thead>
            <tbody>
              <?php $check = false;
              foreach($company_group as $group){ ?>
              <tr>
                <td><?php echo $group->group_name; ?></td>
                <td><?php if($group->division_id!='0'){ echo $group->division_name; } else if($group->division_id==='0'){ echo 'All division';} else{ echo 'not applicable'; } ?></td>
                <td><?php if($group->department!='0'){ echo $group->dept_name; } else{ echo 'All department';} ?></td>
                <td><?php if($group->section!='0'){ echo $group->section_name;} else{ echo 'All section';} ?></td>
                <td><?php if($group->subsection_id!='0'){ echo $group->subsection_name;} else if($group->subsection_id==='0'){ echo 'All subsection';} else{ echo 'not applicable'; } ?></td>
                <td>
                  <?php if($group->InActive === '0'){ ?>
                    <a href="<?php echo site_url('app/time_fixed_schedule/inactivate_group/'. $group->id.''); ?>" onClick="return confirm('Are you sure you want to inactivate group?')">
                    <i  class="fa fa-power-off fa-lg" style="color:green;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Active"></i></a>
                  <?php }
                  if($group->InActive === '1'){ ?>
                    <a href="<?php echo site_url('app/time_fixed_schedule/activate_group/'. $group->id.''); ?>" onClick="return confirm('Are you sure you want to activate group?')">
                    <i  class="fa fa-power-off fa-lg" style="color:red;" class="hidden"  data-toggle="tooltip" data-placement="left" title="Inactive"></i></a>
                  <?php } ?>
                </td>
                <td>
                  <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/time_fixed_schedule/delete_group/'. $group->id.''); ?>" onClick="return confirm('Are you sure you want to permanently delete group? note: All employee will be removed.')"></a>

                  <?php if($group->InActive === '0'){ ?>
                    <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="edit_group('<?php echo $group->id; ?>')"></i>
                  <?php } ?>
                    <i class='fa fa-tasks fa-lg text-info pull-right' data-toggle='tooltip' data-placement='left' title='View member(s)' onclick="view_group_employee('<?php echo $group->id; ?>')"></i>
                  
                    

                </td>
              </tr>
              <?php $check = true; }
              if($check == false){?>
              <td>
                <p style="color:#ff0000;" class='text-center'><strong>No Group(s) yet.</strong></p>
              </td>
             <?php } ?>
            </tbody>
          </table>
          </div>


		 </div> 
         </div><!-- /.box-body --> 
   </div>
   </div>


   <!-- <div id="philhealth_table_search">
   </div> -->


</div>
</div>  
</div>
