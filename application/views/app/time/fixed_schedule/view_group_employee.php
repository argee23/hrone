<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$remove_fs_group_mem=$this->session->userdata('remove_fs_group_mem');
$deactivate_activate_fs_group_mem=$this->session->userdata('deactivate_activate_fs_group_mem');
$edit_fs_group_mem_sched=$this->session->userdata('edit_fs_group_mem_sched');
$add_fs_group_mem=$this->session->userdata('add_fs_group_mem');
$view_fs_group_mem=$this->session->userdata('view_fs_group_mem');
$masterplot_fs_group_sched=$this->session->userdata('masterplot_fs_group_sched');

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

  <div class="panel-heading"><strong><?php echo $group_info->group_name; ?></strong> <?php if($group_name->InActive === '1'){ echo 'Inactive';} ?>

    <a onclick="view_company_group('<?php echo $group_info->company_id; ?>')" type="button" class="" data-toggle="tooltip" data-placement="right" title="Back to View Group list"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>
    <?php if($group_name->InActive === '0'){ ?>

    <a onclick="add_employee('<?php echo $group_info->company_id; ?>','<?php echo $this->uri->segment("4"); ?>')" type="button" class="<?php echo $add_fs_group_mem;?> pull-right" data-toggle="tooltip" data-placement="left" title="Add/Enroll Employee">
<?php
echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>
    </a>
<input type="hidden" id="company_id" value="<?php echo $group_info->company_id; ?>">
    <a onclick="master_plot('<?php echo $group_info->id; ?>','<?php echo $this->uri->segment("4"); ?>')" type="button" class="<?php echo $masterplot_fs_group_sched;?>" data-toggle="tooltip" data-placement="right" title="Click to Plot Schedule Effective for all enrolled employees to the group.">
<?php
echo '<i class="fa fa-calendar fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>
    </a>
    <?php } ?>
  </div>
  <div class="box-body">
  <div class="panel panel-success">
    <div class="box-body">
    <div class="row">
    <div class="col-md-12">

      <div class="col-md-12">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Employee id</th>
            <th>Employee name</th>
            <th>Classification</th>
            <th>Status</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($group_employee as $employee){ 
              $company_id=$employee->company_id;
              $location=$employee->location; //location id
              $classification=$employee->classification_id; //classification id

               //echo "$company_id $location $classification <br>";
              require(APPPATH.'views/include/loc_class_restriction.php');

          if($allowed>0){ // check this variable at loc_class_restriction

            ?>
          <tr
          <?php 
          if($group_name->InActive==0){
            if($employee->InActive==0){

            }else{
              echo 'class="text-danger"';
            }
          }else{
              echo 'class="text-danger"';
          }
          ?>
          >
            <td><?php echo $employee->employee_id; ?></td>
            <td><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
              <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
            </td>
            <td><?php echo $employee->classification; ?></td>
            <td>
            <?php 
            if($group_name->InActive==0){
              if($employee->InActive==0){
                echo "<span class='text-success'>Active</span>";
              }else{
                echo "<span class='text-danger'>InActive</span>";
              } 
            }else{
                echo "<span class='text-danger'>InActive</span>";
            }
              ?>
            </td>
            <td>
          <?php 
          if($group_name->InActive==0){
                if($employee->InActive==0){
          ?>
                    <a href="<?php echo site_url('app/time_fixed_schedule/inactivate_employee/'. $employee->employee_id.'/'.$group_info->id); ?>" onClick="return confirm('Are you sure you want to inactivate employee?')">
                    <?php
                    echo '<i class="'.$deactivate_activate_fs_group_mem.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';" "  data-toggle="tooltip" data-placement="left" title="Click to deactivate employee as a member of this group"></i>';
                    ?>
                    </a>
                    <a  href="<?php echo site_url('app/time_fixed_schedule/remove_employee/'. $employee->employee_id.'/'.$group_info->id); ?>" onClick="return confirm('Are you sure you want to  remove employee?')">
                    <?php
                    echo '<i class="'.$remove_fs_group_mem.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "  data-toggle="tooltip" data-placement="left" title="Click to remove/delete employee as a member of this group"></i>';
                    ?>                      
                    </a>

                    <i class='<?php echo $edit_fs_group_mem_sched;?> fa fa-<?php echo $system_defined_icons->icon_edit." fa-".$system_defined_icons->icon_size."x";?>' <?php echo 'style="color:'.$system_defined_icons->icon_edit_color.';"';?> data-toggle='tooltip' data-placement='left' title='Edit Schedule' onclick="view_edit_employee('<?php echo $employee->employee_id; ?>')"></i>
                <?php
                }else{
                ?>    
                    <a href="<?php echo site_url('app/time_fixed_schedule/activate_employee/'. $employee->employee_id.'/'.$group_info->id); ?>" onClick="return confirm('Are you sure you want to activate employee?')">
                    <?php
                    echo '<i class="'.$deactivate_activate_fs_group_mem.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';" "  data-toggle="tooltip" data-placement="left" title="Click to activate employee as a member of this group"></i>';
                    ?>
                    </a>
                    <i class='fa fa-<?php echo $system_defined_icons->icon_edit." fa-".$system_defined_icons->icon_size."x";?> text-muted' data-toggle='tooltip' data-placement='left' title='Not allowed. Activate the employee first'></i>
                    <i class='fa fa-<?php echo $system_defined_icons->icon_delete." fa-".$system_defined_icons->icon_size."x";?> text-muted' data-toggle='tooltip' data-placement='left' title='Not allowed. Activate the employee first'></i>

                <?php
                } 
          }else{
                echo "<span class='text-danger'>Group is InActive</span>";
          }
          ?>
                <i class='<?php echo $view_fs_group_mem;?> fa fa-calendar<?php echo " fa-".$system_defined_icons->icon_size."x";?>' <?php echo 'style="color:'.$system_defined_icons->icon_view_color.';"';?> data-toggle='tooltip' data-placement='left' title='View Employee Schedule' onclick="view_employee_schedule('<?php echo $employee->employee_id; ?>')"></i>

            </td>
          </tr>
          <?php 
        }else{
          // no access for the employee do not show.
        }

          } ?>
        </tbody>
      </table>
      </div>

    </div>
    </div> 
    </div><!-- /.box-body --> 
   </div>
   </div>

</div>
</div>  
</div>
</div>