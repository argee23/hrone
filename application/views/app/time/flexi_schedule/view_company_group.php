<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_flexi_group=$this->session->userdata('add_flexi_group');
$edit_flexi_group=$this->session->userdata('edit_flexi_group');
$del_flexi_group=$this->session->userdata('del_flexi_group');
$deac_act_flexi_group=$this->session->userdata('deac_act_flexi_group');

$view_flexi_member_sched=$this->session->userdata('view_flexi_member_sched');
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
  <div class="panel-heading"><strong><?php echo $company_name->company_name; ?></strong>

  <a onclick="add_group('<?php echo $this->uri->segment("4"); ?>')" type="button" class="<?php echo $add_flexi_group;?> pull-right" data-toggle="tooltip" data-placement="left" title="Add Group">
<?php
echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
?>
  </a>


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
                <th>Group Description</th>
                <th>Group Type</th>
                <th>Controlled time limit</th>
                <th>Status</th>
                <th style="text-align:center;">Options</th>
              </tr>
            </thead>
            <tbody>
              <?php $check = false;
              foreach($company_group as $group){ ?>

              <tr>
                 <input type="hidden" name="company_id" id="company_id" value="<?php echo $group->company_id; ?>">
                <td><?php echo $group->group_name; ?></td>
                <td><?php echo $group->group_description; ?></td>
                <td><?php if($group->group_type === 'full_flexi'){ echo 'Full flexi'; } else if($group->group_type === 'controlled_flexi'){ echo 'Controlled flexi'; }?></td>
                <td><?php echo $group->controlled_time_limit; ?></td>
                <td><?php if($group->InActive == '0'){
                          echo "Active";       
                          }else{ echo "InActive"; } ?></td>
                <td style="text-align:center;float: center;">
                
                  <?php if($group->InActive === '0'){ ?>
                  <!-- //============= Deactivate Group -->

                    <a href="<?php echo site_url('app/time_flexi_schedule/inactivate_group/'. $group->flexi_group_id.''); ?>" onClick="return confirm('Are you sure you want to inactivate group?')">
                    <i  class="<?php echo $deac_act_flexi_group;?> fa fa-<?php echo $system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x " style="color:'.$system_defined_icons->icon_disable_color.';"' ?>" data-toggle="tooltip" data-placement="left" title="Click to Disable/Deactivate"></i></a>&nbsp;


                  <?php }
                  if($group->InActive === '1'){ ?>
                  <!-- //============= Activate Group -->

                    <a href="<?php echo site_url('app/time_flexi_schedule/activate_group/'. $group->flexi_group_id.''); ?>" onClick="return confirm('Are you sure you want to activate group?')">
                    <i  class="<?php echo $deac_act_flexi_group;?> fa fa-<?php echo $system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x " style="color:'.$system_defined_icons->icon_enable_color.';"' ?>" data-toggle="tooltip" data-placement="left" title="Click to Activate"></i></a>&nbsp;


                  <?php } ?>
                 
                  <?php if($group->InActive === '0'){ ?>
                  <!-- //============= View Group Members-->
                    <i class='<?php echo $view_flexi_member_sched;?> fa fa-<?php echo $system_defined_icons->icon_view.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_view_color.';"';?> data-toggle='tooltip' data-placement='left' title='View member(s)' onclick="view_group_employee('<?php echo $group->flexi_group_id; ?>')"></i>&nbsp;

                  <!-- //============= Edit Group -->

                    <i class='<?php echo $edit_flexi_group;?> fa fa-<?php echo $system_defined_icons->icon_edit.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_edit_color.';"';?> data-toggle='tooltip' data-placement='left' title='Edit group name' onclick="edit_group('<?php echo $group->flexi_group_id; ?>')"></i>&nbsp;


                  <!-- //============= Remove Group -->
                   <a  class='<?php echo $del_flexi_group;?> fa fa-<?php echo $system_defined_icons->icon_delete.'  fa-'.$system_defined_icons->icon_size.'x'; ?>' <?php echo 'style="color:'.$system_defined_icons->icon_delete_color.';"';?> data-toggle="tooltip" data-placement="left" title="Delete Group" href="<?php echo site_url('app/time_flexi_schedule/delete_group/'. $group->flexi_group_id.''); ?>" onClick="return confirm('Are you sure you want to permanently delete group? note: All employee member will be removed as well.')"></a>&nbsp;


                   <?php }else{ ?>

                   <!-- //============= Not allowed view group member -->
          

                    <i class='<?php echo $view_flexi_member_sched;?> fa fa-<?php echo $system_defined_icons->icon_view.'  fa-'.$system_defined_icons->icon_size.'x'; ?> text-muted pull-center' data-toggle='tooltip' data-placement='left' title='cannot view: enable first'></i>&nbsp;

                    <!-- //============= Not allowed edit group -->

                    <i class='<?php echo $edit_flexi_group;?> fa fa-<?php echo $system_defined_icons->icon_edit.'  fa-'.$system_defined_icons->icon_size.'x'; ?> text-muted pull-center' data-toggle='tooltip' data-placement='left' title='cannot edit: enable first'></i>&nbsp;

                   <!-- //============= Not allowed not allowed delete group -->

                    <i class='<?php echo $del_flexi_group;?> fa fa-<?php echo $system_defined_icons->icon_delete.'  fa-'.$system_defined_icons->icon_size.'x'; ?> text-muted pull-center' data-toggle='tooltip' data-placement='left' title='cannot delete: enable first'></i>&nbsp;

                     <?php } ?>

                     <!-- //============= View all members schedule -->

                    <i class='<?php echo $view_flexi_member_sched;?> fa fa-calendar<?php echo " fa-".$system_defined_icons->icon_size."x";?>' <?php echo 'style="color:'.$system_defined_icons->icon_view_color.';"';?> data-toggle='tooltip' data-placement='left' title='View Employee(s) Schedule' onclick="employees_schedule('<?php echo $group->flexi_group_id; ?>')"></i>

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
