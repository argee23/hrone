<br>
  <ol class="breadcrumb">
    <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Crystal Reports | 
    <?php if($code_type=='CRRS1') { echo "Serttech Settings"; } else if($code_type=='CRRS2'){ echo "Registered Employer"; }
    else if($code_type=='CRRS3') { echo "Job Management"; } else if($code_type=='CRRS4') { echo "Requirement Status"; } else if($code_type=='CRRS5') { echo "Payment Status"; } else {  }?>
    </h4>
  </ol>
  <div class="col-md-12" id="action_here_div">
  <?php if($code_type=='CRRS1'){?>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <select class="col-md-12 form-control" id="code" name="code">
          <option value="" disabled selected>Select Setting</option>
          <?php foreach($setting as $s){?>
             <option value="<?php echo $s->code;?>"><?php echo $s->policy_title;?></option>
          <?php } ?>
             <option value="single_field">Single Field Settings (all settings with single field)</option>
             <option value="setting_list">Serttech Settings (list of sert tech settings)</option>
        </select>
        <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="add_crystal_report('<?php echo $code_type;?>');"> ADD CRYSTAL REPORT</button>
    </div>
    <div class="col-md-4"></div>
     <br><br><br><br><br>
  <?php } else if($code_type=='CRRS2'){?>

      <input type="hidden" id="code" name="code" value="RE1">
      <button class="col-md-2 btn btn-success btn-sm pull-right" style="margin-top: 10px;" onclick="add_crystal_report('<?php echo $code_type;?>');"> ADD CRYSTAL REPORT</button>
    <br><br><br>
  <?php } else if($code_type=='CRRS3'){?>
      <input type="hidden" id="code" name="code" value="JM1">
      <button class="col-md-2 btn btn-success btn-sm pull-right" style="margin-top: 10px;" onclick="add_crystal_report('<?php echo $code_type;?>');"> ADD CRYSTAL REPORT</button>
    <br><br><br>
  <?php } else if($code_type=='CRRS4') {?>
  <input type="hidden" id="code" name="code" value="RS1">
      <button class="col-md-2 btn btn-success btn-sm pull-right" style="margin-top: 10px;" onclick="add_crystal_report('<?php echo $code_type;?>');"> ADD CRYSTAL REPORT</button>
    <br><br><br>
  <?php }
  else if($code_type=='CRRS5'){?>
      
     <input type="hidden" id="code" name="code" value="PS1">
      <button class="col-md-2 btn btn-success btn-sm pull-right" style="margin-top: 10px;" onclick="add_crystal_report('<?php echo $code_type;?>');"> ADD CRYSTAL REPORT</button>
    <br><br><br>
  <?php  } else { ?>

    

  <?php  }?>
  
 
  <div class="box box-default" class='col-md-12'></div>
  <div class="col-md-12">
       <table class="table table-hover" id="crystal_report_table">
          <thead>
              <tr class="danger">
                <th>ID</th>
                <th>Type</th>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach($crystal_report as $cd){
              $code = $cd->code;
            ?>
              <tr>
                <td><?php echo $cd->id;?></td>
                <td>
                   <?php if($code=='single_field'){ echo 'Single Field Settings'; } else if($code=='setting_list') { echo 'Serttech Settings'; } else if($code=='RE1'){ echo "Registered Employers"; } else { echo $cd->title; } ?>
                </td>
                <td><?php echo $cd->crtitle;?></td>
                <td><?php echo $cd->description;?></td>
                <td>
                    <?php if($cd->InActive==1){} else{ ?><a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_crystal_report('edit','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Update Crystal report details' ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> <?php } ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="stat_crystal_report('delete','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to Delete crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                        <?php if($cd->InActive==1){?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>' onclick="stat_crystal_report('enable','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to disable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                        <?php }else{ ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'onclick="stat_crystal_report('disable','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to enable crystal report'><i  class="fa fa-<?php echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                        <?php } ?>
                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="stat_crystal_report('view','<?php echo $cd->id?>','<?php echo $cd->type;?>','<?php echo $cd->code;?>')" aria-hidden='true' data-toggle='tooltip' title='Click to View crystal report' ><i  class="fa fa-<?php echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                </td>
              </tr>
            <?php $i++; } ?>
          </tbody>
      </table>


  </div>
  </div>