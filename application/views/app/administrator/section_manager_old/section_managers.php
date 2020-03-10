<table id="section_managers" class="table table-hover table-striped">
  <thead>
    <tr>
      <th>Company ID</th>
      <th>Manager</th>
      <th>Division</th>
      <th>Department</th>
      <th>Section</th>
      <th>Subsection</th>
      <th>Location</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
      <?php  foreach($sectionmanagerList as $list) { ?>
    <tr>
      <td><?php echo $list->company_id."=".$list->division_name?></td>
      <td><?php echo $list->first_name." ".$list->last_name?></td>
      <td><?php echo $list->division_name?></td>
      <td><?php echo $list->dept_name?></td>
      <td><?php echo $list->section_name?></td>
      <td><?php echo $list->subsection_name?></td>  
      <td><?php  if($list->loc=='All'){ echo"All"; } else{ echo  $list->location_name; } ?></td>
      <td>
        <a onclick="delete_manager_one('<?php echo $list->id?>','<?php echo $list->company_id?>')"><i  class="fa fa-remove fa-lg text-danger pull-left"></i></a>
        <?php if($list->InActive==0)
        {?>
        <a onclick="status_manager_one('<?php echo $list->company_id?>','<?php echo $list->id?>','1');"><i  class="fa fa-power-off fa-lg text-success pull-left"></i></a>
        <?php } else{ ?>
          <a onclick="status_manager_one('<?php echo $list->company_id?>','<?php echo $list->id?>','0');"><i  class="fa fa-power-off fa-lg text-danger pull-left"></i></a>
        <?php } ?>       
      </td>
    </tr>
      <?php } ?>
   </tbody>
</table>    