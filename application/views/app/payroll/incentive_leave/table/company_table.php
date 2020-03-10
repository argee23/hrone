<?php
    /*
    -----------------------------------
    start : user role restriction access checking.
    get the below variable at table "pages" field page_name
    -----------------------------------
    */
    $add_il_table=$this->session->userdata('add_il_table');
    $edit_il_table=$this->session->userdata('edit_il_table');
    $delete_il_table=$this->session->userdata('delete_il_table');
    $enable_disable_il_table=$this->session->userdata('enable_disable_il_table');
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>
<div class="col-md-12">
	<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Start of OT Hour</th>
      <th>End of OT Hour</th>
      <th>Equivalent of Incentive Credit</th>
      <th>Status</th>
      <th>
      <a onclick="incentive_table_add('<?php echo $company_info->company_id; ?>')" type="button" class="<?php echo $add_il_table;?> pull-right" data-toggle="tooltip" data-placement="left" title="Add"><?php
        echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
        ?></a></th>
    </tr>
  </thead>
  <tbody>
    <?php $check = false;
    foreach($company_table as $company){ ?>

    <tr>
      <td><?php echo $company->start_ot_hour; ?></td>
      <td><?php echo $company->end_ot_hour; ?></td>
      <td><?php echo $company->equivalent_incentive_credit; ?></td>
      <td>
        <?php if($company->InActive === '0'){ 
          echo "Active";
        }else{
          echo "InActive";
        }
          ?>

      </td>
      <td>
      <?php

        $edit = '<i class="'.$edit_il_table.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="incentive_table_edit('.$company->incentive_leave_id.')"></i>';

        $delete = anchor('app/payroll_incentive_leave/incentive_leave_delete/'.$company->incentive_leave_id,'<i class="'.$delete_il_table.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete incentive leave column?')"));

        $disable = anchor('app/payroll_incentive_leave/incentive_leave_inactivate/'.$company->incentive_leave_id,'<i class="'.$enable_disable_il_table.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Deactivate','onclick'=>"return confirm('Are you sure you want to Deactivate incentive column?')"));

        $enable = anchor('app/payroll_incentive_leave/incentive_leave_activate/'.$company->incentive_leave_id,'<i class="'.$enable_disable_il_table.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Activate','onclick'=>"return confirm('Are you sure you want to Activate incentive column?')"));

        if($company->InActive === '0'){
          echo "$edit $delete $disable";
        }else{
          echo "$enable";
        }
        
      ?>
        
      </td>
    </tr>
    <?php $check = true; }
    if($check == false){?>
    <td>
      <p style="color:#ff0000;" class='text-center'><strong>No data yet.</strong></p>
    </td>
   <?php } ?>
  </tbody>
</table>
</div>
