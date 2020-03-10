<?php
    /*
    -----------------------------------
    start : user role restriction access checking.
    get the below variable at table "pages" field page_name
    -----------------------------------
    */
    $add_ot_meal_emp=$this->session->userdata('add_ot_meal_emp');
    $edit_ot_meal_emp=$this->session->userdata('edit_ot_meal_emp');
    $delete_ot_meal_emp=$this->session->userdata('delete_ot_meal_emp');
    $enable_disable_ot_meal_emp=$this->session->userdata('enable_disable_ot_meal_emp');
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

<div class="col-md-12">
<div id="search_here">
<table id="example1" class="table table-bordered table-striped">
<thead>
  <tr>
    <th>Emp. ID</th>
    <th>Employee Name</th>
    <th>Status</th>
    <th>
        <a onclick="ot_meal_employee_add('<?php echo $company_info->company_id; ?>')" type="button" class="<?php echo $add_ot_meal_emp;?> pull-right" data-toggle="tooltip" data-placement="left" title="Add"><?php
        echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
        ?></a></th>
  </tr>
</thead>
<tbody>
<?php foreach($ot_meal_employee as $employee): ?>
  <tr>
    <td><?php echo $employee->employee_id?></td>
    <td><?php echo $employee->fullname ?></td>
    <td>
      <?php if($employee->InActive === '0'){ 
        echo "Active";
      }else{
        echo "InActive";
      }

        ?>
    </td>
    <td>
    <?php

        $delete = anchor('app/payroll_automatic_ot_meal/remove_employee/'.$employee->id,'<i class="'.$delete_ot_meal_emp.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to remove this employee?')"));

        $disable = anchor('app/payroll_automatic_ot_meal/inactivate_employee/'.$employee->id,'<i class="'.$enable_disable_ot_meal_emp.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Deactivate','onclick'=>"return confirm('Are you sure you want to Deactivate employee as enrolled to OT Meal Allowance?')"));

        $enable = anchor('app/payroll_automatic_ot_meal/activate_employee/'.$employee->id,'<i class="'.$enable_disable_ot_meal_emp.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Activate','onclick'=>"return confirm('Are you sure you want to Activate  employee as enrolled to OT Meal Allowance?')"));

        if($employee->InActive === '0'){
          echo "$delete $disable";
        }else{
          echo "$enable";
        }

    ?>
    </td>
  </tr>
<?php endforeach?>
</tbody>
</table>
</div>
</div>


<script>
$(function () {

  $("#example1").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false
  });
});
</script>



