 <?php 
  /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $del_sect_mngr=$this->session->userdata('del_sect_mngr');
    $ena_dis_sect_mngr=$this->session->userdata('ena_dis_sect_mngr');
    $system_defined_icons = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */
?>
<table id="section_managers" class="table table-hover table-striped">
  <thead>
    <tr>
      <th>Company Name</th>
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
      <td><?php echo $list->company_name?></td>
      <td><?php echo $list->first_name." ".$list->last_name?></td>
      <td><?php echo $list->division_name?></td>
      <td><?php echo $list->dept_name?></td>
      <td><?php echo $list->section_name?></td>
      <td><?php echo $list->subsection_name?></td>  
      <td><?php  if($list->loc=='All'){ echo"All"; } else{ echo  $list->location_name; } ?></td>
      <td>
        <a onclick="delete_manager_one('<?php echo $list->id?>','<?php echo $list->company_id?>')"><i  class="<?php echo $del_sect_mngr;?> fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg pull-left"  style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'></i></a>
        <?php if($list->InActive==0)
        {?>
        <a onclick="status_manager_one('<?php echo $list->company_id?>','<?php echo $list->id?>','1');"><i  class="<?php echo $ena_dis_sect_mngr;?> fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg pull-left"  style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'></i></a>
        <?php } else{ ?>
          <a onclick="status_manager_one('<?php echo $list->company_id?>','<?php echo $list->id?>','0');"><i  class="<?php echo $ena_dis_sect_mngr;?> fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg pull-left"  style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'></i></a>
        <?php } ?>       
      </td>
    </tr>
      <?php } ?>
   </tbody>
</table>    