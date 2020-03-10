<?php
    /*
    -----------------------------------
    start : user role restriction access checking.
    get the below variable at table "pages" field page_name
    -----------------------------------
    */
    $add_ot_meal_table=$this->session->userdata('add_ot_meal_table');
    $edit_ot_meal_table=$this->session->userdata('edit_ot_meal_table');
    $delete_ot_meal_table=$this->session->userdata('delete_ot_meal_table');
    $enable_disable_ot_meal_table=$this->session->userdata('enable_disable_ot_meal_table');
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>



<div class="col-md-12">
	<table id="ot_allowance" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>OT Type</th>
      <th>Location</th>
      <th>Classification</th>
      <th>Employement Type</th>
      <th>Number of Hour</th>
      <th>Start</th>
      <th>End</th>
      <th>Amount</th>
      <th>Status</th>
      <th>
      <a onclick="ot_meal_table_add('<?php echo $company_info->company_id; ?>')" type="button" class="<?php echo $add_ot_meal_table;?> pull-right" data-toggle="tooltip" data-placement="left" title="Add"><?php
        echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
        ?></a></th>
    </tr>
  </thead>
  <tbody>
    <?php $check = false;
    foreach($company_table as $company){ ?>

    <tr>
      <td><?php echo $company->cValue; ?></td>
      <td><?php echo $company->location_name; ?></td>
      <td><?php echo $company->classification; ?></td>
      <td><?php echo $company->employment_name; ?></td>
      <td><?php echo $company->every_hour; ?></td>
      <td><?php echo $company->from_hour; ?></td>
      <td><?php echo $company->to_hour; ?></td>
      <td><?php echo $company->amount; ?></td>
      <td>
        <?php if($company->InActive == 1){ 
          echo "InActive";
        }else{
          echo "Active";
        }
        ?>

      </td>
      <td>
      <?php

        $edit = '<i class="'.$edit_ot_meal_table.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="ot_meal_table_edit('.$company->id.')"></i>';

        $delete = anchor('app/payroll_automatic_ot_meal/ot_meal_delete/'.$company->id,'<i class="'.$delete_ot_meal_table.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ot meal allowance column?')"));

        $disable = anchor('app/payroll_automatic_ot_meal/ot_meal_activate/'.$company->id,'<i class="'.$enable_disable_ot_meal_table.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Deactivate','onclick'=>"return confirm('Are you sure you want to Activate ot meal allowance column?')"));

        $enable = anchor('app/payroll_automatic_ot_meal/ot_meal_inactivate/'.$company->id,'<i class="'.$enable_disable_ot_meal_table.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Activate','onclick'=>"return confirm('Are you sure you want to Deactivate ot meal allowance column?')"));

        if($company->InActive == 1){
          echo "$edit $delete $disable";
        }else{
          echo "$enable";
        }
        
      ?>
        
      </td>
    </tr>
    <?php $check = true; }
    if($check == false){?>
   <?php } ?>
  </tbody>
</table>
</div>
