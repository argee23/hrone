<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Crystal Reports
      <button class="btn btn-success btn-sm pull-right" onclick="addform_crystal_report('<?php echo $type;?>');">Add Report</button>
  </h4>
</ol>

<div class="col-md-12" id="resultss_pre_approved">
  <table class="col-md-12 table table-hover" id="p_crystal_report">
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
    <?php $i=1; foreach($crystal_report as $ress){?>
      <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $ress->p_id; ?></td>
        <td><?php echo $ress->report_name; ?></td>
        <td><?php echo $ress->report_desc; ?></td>
         
           <td>
          <?php $get_f = $this->personnel_reports_model->get_crystal_fields($ress->p_id,$type); 
         echo "<a data-toggle='collapse' data-target='#demo".$ress->p_id."' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view the list of group/s'> ".count($get_f)." Fields/s</a>";
                   
          ?>
        <div class="collapse" id="demo<?php echo $ress->p_id;?>">
        <?php foreach($get_f as $ff)
        {
         echo '<n class="text-danger">'.$ff->title."<br></n>";
         
         
        }?>
         </div>
        </td>
        <?php if($ress->IsDefault=='1'){ echo "<td>not allowed to take action.</td>"; }
        else
          {?>
        <td>
           <?php if($ress->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="editform_crystal_report('<?php echo $ress->p_id;?>','<?php echo $type;?>','edit')" aria-hidden='true' data-toggle='tooltip' title='Click to Update Group details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>
            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="del_stat_crystal_report('delete','<?php echo $ress->p_id;?>','<?php echo $type;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Group details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
            <?php if($ress->InActive==1){?>
                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="del_stat_crystal_report('enabled','<?php echo $ress->p_id?>','<?php echo $type;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable group'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                <?php }else{ ?>
                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>' onclick="del_stat_crystal_report('disabled','<?php echo $ress->p_id?>','<?php echo $type;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable group'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                <?php } ?>
            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="editform_crystal_report('<?php echo $ress->p_id;?>','<?php echo $type;?>','view')" aria-hidden='true' data-toggle='tooltip' title='Click to view fields of the report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg pull-left"></i></a>
           
        </td>
        <?php } ?>
      </tr>
      <?php $i++;  } ?>
    </tbody>
  </table>
</div>
</div>

