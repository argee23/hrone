
  <h4 class="text-danger" style="font-weight: bold;">
      <button class="btn btn-success btn-sm pull-right" onclick="crystal_report_add();">Add Report</button>
  </h4>

  <br><br> 
  <table class="col-md-12 table table-hover" id="crystal_report">
    <thead>
      <tr class="danger">
        <th>No.</th>
        <th>Report ID</th>
        <th>Report Name</th>
        <th>Report Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($crystal_report as $ress){?>
      <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $ress->p_id; ?></td>
        <td><?php echo $ress->report_name; ?></td>
        <td><?php echo $ress->report_desc; ?></td>
        <td>
           <?php if($ress->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="editform_crystal_report('<?php echo $ress->p_id;?>','edit')" aria-hidden='true' data-toggle='tooltip' title='Click to Update Group details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>
            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="del_stat_crystal_report('delete','<?php echo $ress->p_id;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Group details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
            <?php if($ress->InActive==1){?>
                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="del_stat_crystal_report('enabled','<?php echo $ress->p_id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable group'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                <?php }else{ ?>
                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>' onclick="del_stat_crystal_report('disabled','<?php echo $ress->p_id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable group'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                <?php } ?>
            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="editform_crystal_report('<?php echo $ress->p_id;?>','view')" aria-hidden='true' data-toggle='tooltip' title='Click to view fields of the report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg pull-left"></i></a>
           
        </td>
      </tr>
      <?php $i++;  } ?>
    </tbody>
  </table>

