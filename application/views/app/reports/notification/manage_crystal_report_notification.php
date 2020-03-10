<center><h4><u><?php echo $notif_details->form_name;?></u></h4></center>
<div class="col-md-12">
  <button class="pull-right" style="margin-bottom: 10px;" onclick="add_crystal_report('<?php echo $notification;?>','<?php echo $company;?>','add')">Add</button>
</div>
<div class="col-md-12">
  <table class="col-md-12 table table-hover" id="crystal_report">
          <thead>
            <tr class="danger">
              <th>No.</th>
              <th>Report ID</th>
              <th>Report Name</th>
              <th>Report Description</th>
              <th>Fields</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; foreach($crystal_details as $cd){?>
            <tr>
              <td><?php echo $i;?></td>
              <td><?php echo $cd->id;?></td>
              <td><?php echo $cd->title;?></td>
              <td><?php echo $cd->description;?></td>
              <td>View Fields</td>
              <td>
                   <?php if($cd->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_crystal_report('<?php echo $notification;?>','<?php echo $company;?>','edit','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Update Group details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>

                    <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="stat_crystal_report('<?php echo $notification;?>','<?php echo $company;?>','delete','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                    <?php if($cd->InActive==1){?>

                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="stat_crystal_report('<?php echo $notification;?>','<?php echo $company;?>','enable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                        <?php }else{ ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'onclick="stat_crystal_report('<?php echo $notification;?>','<?php echo $company;?>','disable','<?php echo $cd->id?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                        <?php } ?>
                   

              </td>
            </tr>
          <?php $i++; } ?>
          </tbody>
        </table>
</div>