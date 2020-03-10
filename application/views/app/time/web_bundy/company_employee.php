
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

<div class="col-md-12">
<div id="search_here">
<table id="example1" class="table table-bordered table-striped">
<thead>
  <tr>
    <th>Employee ID</th>
    <th>Employee Name</th>
    <th>Web Bundy Code</th>
    <th>Date Added</th>
    <th>Action  
    <?php
    if($time_wb_mng_emp=="hidden "){
        echo '<i class="text-danger fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" title="Not Allowed. Check Access Rights."></i>';
    }else{
    ?>
        <a onclick="web_bundy_employee_add('<?php echo $company_info->company_id; ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><?php
        echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
        ?></a>
    <?php
    }
    ?> 


    </th>
  </tr>
</thead>
<tbody>
<?php foreach($web_bundy_employee as $employee): ?>
  <tr>
    <td><?php echo $employee->employee_id?></td>
    <td><?php echo $employee->fullname ?></td>
    <td><?php echo $employee->code ?></td>
    <td><?php $date = new DateTime($employee->date_added); echo $date->format('Y-m-d'); ?></td>
    <td>
    <?php

        $delete = anchor('app/time_web_bundy/remove_employee/'.$employee->id.'/'.$employee->employee_id,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to remove this employee?')"));

    if($time_wb_mng_emp=="hidden "){
        echo '<i class="text-danger fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" title="Not Allowed. Check Access Rights."></i>';
    }else{

         echo $delete;
    }
       
    ?>
    </td>
  </tr>
<?php endforeach?>
</tbody>
</table>
</div>
</div>
