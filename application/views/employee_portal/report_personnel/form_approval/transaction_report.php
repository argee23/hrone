<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li><a><n class="text-danger"><b>[ <?php echo $form_name;?> ]</b></n></a></li>
         <li class="pull-right"><a  style="cursor:pointer;" href="#time_quick_gen" onclick="generate_report_employment('<?php echo $id;?>','<?php echo $identification;?>');" data-toggle="tab"><i class="fa fa-file text-info"></i> Generate Report [Employment Details]</a></li>

        <li class="pull-right"><a  style="cursor:pointer;" href="#time_quick_gen" onclick="generate_report('<?php echo $id;?>','<?php echo $identification;?>');" data-toggle="tab"><i class="fa fa-file text-info"></i> Generate Report [Date Range]</a></li>
        <li class="active pull-right"><a style="cursor:pointer;" href="#crystal_report" data-toggle="tab" onclick="get_transaction('<?php echo $id;?>','<?php echo $identification;?>');"><i class="fa fa-folder text-warning"></i> Crystal Report</a></li>
    </ul>

   
      <div id="time_w_filtering">
        <div class="box box-default">
          <div class="box-body"  id="crystal_report_main">
          <div class="col-md-12" style="margin-top: 10px;"><button class="btn btn-success btn-xs pull-right" onclick="add_crystal_report('<?php echo $id;?>','<?php echo $identification;?>');"><i class="fa fa-plus"></i>ADD CRYSTAL REPORT</button></div>
          <div class="col-md-12" style="margin-top: 10px;">
            <table class="table table-hover" id="crystal_report">
              <thead>
                    <tr class="danger">
                        <th>No</th>
                        <th>Transaction</th>
                        <th>Crystal Report</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach($crystal_report as $c){?>

                    <tr>

                        <td><?php echo $i;?></td>
                        <td><?php echo $c->form_name;?></td>
                        <td><?php echo $c->title;?></td>
                        <td><?php echo $c->date_created;?></td>
                        <td>

                             <a  style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="viewupdate_crystal_report('view','<?php echo $id;?>','<?php echo $identification;?>','<?php echo $c->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to View Crystal Report'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                             <a  style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="action_crystal_report('delete','<?php echo $id;?>','<?php echo $identification;?>','<?php echo $c->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Crystal Report'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

                             <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  onclick="viewupdate_crystal_report('update','<?php echo $id;?>','<?php echo $identification;?>','<?php echo $c->id;?>');" data-toggle='modal' data-target='#modal'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Crystal Report'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                            <?php if($c->InActive==1)
                            {?>
                              <a  style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="action_crystal_report('enable','<?php echo $id;?>','<?php echo $identification;?>','<?php echo $c->id;?>'); " aria-hidden='true' data-toggle='tooltip' title='Click to Enable Crystal Report'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                            <?php } else{?>
                              <a  style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>' onclick="action_crystal_report('disable','<?php echo $id;?>','<?php echo $identification;?>','<?php echo $c->id;?>'); " aria-hidden='true' data-toggle='tooltip' title='Click to Disable Crystal Report'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                            <?php } ?>

                        </td>

                    </tr>

                <?php $i++; } ?>
              </tbody>
          </table>
        </div>
        </div>
       </div>
   </div>
</div>
           