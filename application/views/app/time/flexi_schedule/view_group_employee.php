<!-- VIEW MEMBER OF GROUP -->
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_flexi_group_mem=$this->session->userdata('add_flexi_group_mem');
$deac_act_flexi_group_mem=$this->session->userdata('deac_act_flexi_group_mem');
$del_flexi_group_mem=$this->session->userdata('del_flexi_group_mem');
$view_flexi_member_sched=$this->session->userdata('view_flexi_member_sched');
$edit_flexi_group_mem_sched=$this->session->userdata('edit_flexi_group_mem_sched');
$master_edit_flexi_group_mem_sched=$this->session->userdata('master_edit_flexi_group_mem_sched');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>

<div class="row">
<div class="col-md-12">
<div class="box box-success">
<div class="panel panel-success">

  <div class="panel-heading"><strong><?php echo $group_employee[0]->group_name; ?></strong> (<?php if($group_employee[0]->group_type === 'full_flexi'){ echo 'Full flexi'; } else if($group_employee[0]->group_type === 'controlled_flexi'){ echo 'Controlled flexi'; }?> ) <?php if($group_name->InActive === '1'){ echo 'Inactive';} ?>

  <input type="hidden" id="company_id" value="<?php echo $group_employee[0]->company_id;?>">

  <!-- //======= ONE TIME PLOT ALL MEMBER SCHED-->
    <a onclick="master_plot('<?php echo $this->uri->segment("4"); ?>')" type="button" class="<?php echo $master_edit_flexi_group_mem_sched;?>" data-toggle="tooltip" data-placement="right" title="Click to Plot Schedule Effective for all enrolled employees to the group.">
<?php
echo '<i class="fa fa-calendar fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>
    </a>
  <!-- //======= VIEW COMPANY GROUP-->
    <a onclick="view_company_group('<?php echo $group_employee[0]->company_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="View Group list"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>

    <?php if($group_name->InActive === '0'){?>

  <!-- //======= ADD GROUP MEMBER-->
    <a onclick="add_employee('<?php echo $group_employee[0]->company_id; ?>','<?php echo $this->uri->segment("4"); ?>')" type="button" class="<?php echo $add_flexi_group_mem;?> pull-right" data-toggle="tooltip" data-placement="left" title="Add/Enroll Employee">
<?php
echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>
    </a>

    <?php } ?>
  </div>

      <div class="box-body">
      <div class="panel panel-success">
         <div class="box-body">
         <div class="row">

             <div class="col-md-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Employee id</th>
                    <th>Employee name</th>
                    <th>Location/Classification</th>
                    <th>Standard shift in and out</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($employee_group as $employee){ ?>
                  <tr>
                    <td><?php echo $employee->employee_id; ?></td>
                    <td><?php echo $employee->first_name; ?> <?php echo $employee->middle_name; ?> 
                      <?php echo $employee->last_name; ?> <?php echo $employee->name_extension; ?>
                    </td>
                    <td><?php echo $employee->location_name."/".$employee->classification; ?></td>
                    <td><?php echo $employee->standard_shift_in; ?> - <?php echo $employee->standard_shift_out; ?></td>
                    <td>
                    <?php if($group_name->InActive === '0'){?>
                      <?php if($employee->InActive === '0'){ ?>

                      <!-- //======= DEACTIVATE MEMBER -->

                    <a href="<?php echo site_url('app/time_flexi_schedule/inactivate_employee/'. $employee->employee_id.'/'.$group_name->flexi_group_id); ?>" onClick="return confirm('Are you sure you want to Deactivate employee as a member of this group?')">
                    <?php
                    echo '<i class="'.$deac_act_flexi_group_mem.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';" "  data-toggle="tooltip" data-placement="left" title="Click to deactivate employee as a member of this group"></i>';
                    ?>
                    </a>
                      <?php }
                      if($employee->InActive === '1'){ ?>

                      <!-- //======= ACTIVATE MEMBER -->

                    <a href="<?php echo site_url('app/time_flexi_schedule/activate_employee/'. $employee->employee_id.'/'.$group_name->flexi_group_id); ?>" onClick="return confirm('Are you sure you want to activate employee as a member of this group?')">
                    <?php
                    echo '<i class="'.$deac_act_flexi_group_mem.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';" "  data-toggle="tooltip" data-placement="left" title="Click to activate employee as a member of this group"></i>';
                    ?>
                    </a>

                      <?php } ?>
                    <?php } ?>
                    <?php if($group_name->InActive === '1'){ echo 'InActive'; } ?>
                    </td>
                    <td>

                    <!-- //======= REMOVE MEMBER -->

                    <?php if($employee->InActive === '0'){ ?>
                    <a  href="<?php echo site_url('app/time_flexi_schedule/remove_employee/'. $employee->employee_id.'/'.$group_name->flexi_group_id); ?>" onClick="return confirm('Are you sure you want to  remove employee?')">
                    <?php
                    echo '<i class="'.$del_flexi_group_mem.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';" "  data-toggle="tooltip" data-placement="left" title="Click to remove/delete employee as a member of this group"></i>';
                    ?>                      
                    </a>

                    <!-- //======= EDIT MEMBER SCHED-->
                    <i class='<?php echo $edit_flexi_group_mem_sched;?> fa fa-<?php echo $system_defined_icons->icon_edit." fa-".$system_defined_icons->icon_size."x";?>' <?php echo 'style="color:'.$system_defined_icons->icon_edit_color.';"';?> data-toggle='tooltip' data-placement='left' title='Edit Schedule' onclick="view_edit_employee('<?php echo $employee->employee_id; ?>')"></i>

                      <?php 
                      }else{
                      ?>
                   <i class='fa fa-<?php echo $system_defined_icons->icon_edit.'  fa-'.$system_defined_icons->icon_size.'x'; ?> text-muted'   data-toggle='tooltip' data-placement='left' title='cannot edit: enable first' ></i>&nbsp;

                   <a  class='fa fa-<?php echo $system_defined_icons->icon_delete.'  fa-'.$system_defined_icons->icon_size.'x'; ?> text-muted'   data-toggle="tooltip" data-placement="left" title="cannot delete: enable first"></a>&nbsp;                      
                      <?php
                      }
                      ?>
                      <!-- //======= VIEW MEMBER SCHED -->
                  <i class='<?php echo $view_flexi_member_sched;?> fa fa-calendar<?php echo " fa-".$system_defined_icons->icon_size."x";?>' <?php echo 'style="color:'.$system_defined_icons->icon_view_color.';"';?> data-toggle='tooltip' data-placement='left' title='View Employee Schedule' onclick="view_employee_schedule('<?php echo $employee->employee_id; ?>')"></i>



                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              </div>


         </div> 
         </div><!-- /.box-body --> 
      </div>
      </div>


    


</div><!-- panel-success --> 
</div><!-- box-success --> 
</div><!-- col-md-12 --> 
</div><!-- row --> 
