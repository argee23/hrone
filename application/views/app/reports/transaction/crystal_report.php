  <div class="col-md-12" style="margin-bottom: 10px;" id="mm">
    <button class="btn btn-success pull-right btn-xs" onclick="add_crystal_report('<?php echo $transaction;?>','<?php echo $company;?>','<?php echo $type;?>');">Add Crystal Report</button>
  </div>
  <table class="col-md-12 table table-hover" id="crystal_report">
      <thead>
        <tr class="danger">
          <th>No</th>
          <th>Report ID</th>
          <th>Report Name</th>
          <th>Report Description</th>
          <th>Action</th>
        </tr>
      </thead>  
      <tbody>
      <?php $i=1; foreach($details as $cd){?>
      <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $cd->id;?></td>
          <td><?php echo $cd->title;?></td>
          <td><?php echo $cd->description;?></td>
          <td>
                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="stat_crystal_report('<?php echo $transaction;?>','<?php echo $company;?>','<?php echo $type;?>','view','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to View crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                  <?php if($cd->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="stat_crystal_report('<?php echo $transaction;?>','<?php echo $company;?>','<?php echo $type;?>','edit','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Crystal Report details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>

                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="stat_crystal_report('<?php echo $transaction;?>','<?php echo $company;?>','<?php echo $type;?>','delete','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                  <?php if($cd->InActive==1){?>

                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="stat_crystal_report('<?php echo $transaction;?>','<?php echo $company;?>','<?php echo $type;?>','enable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                  <?php }else{ ?>
                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>' onclick="stat_crystal_report('<?php echo $transaction;?>','<?php echo $company;?>','<?php echo $type;?>','disable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                        <?php } ?>
          </td>
      </tr>
      <?php  $i++; } ?>
      </tbody>
  </table>
