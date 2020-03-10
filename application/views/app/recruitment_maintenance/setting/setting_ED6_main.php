<div class="col-md-12" style="margin-top: 10px;">
    <div class="col-md-4">
        <label class="pull-right">Allow File Upload?</label>
    </div>
    
    <div class="col-md-6">
      <input type="radio" value="1" name="upload" onclick="allow_upload('1','uploadable','uploadable')" checked> Yes
      <input type="radio" value="0"  name="upload" value="0" onclick="allow_upload('0','uploadable','uploadable')">  No
      <input type="hidden" id="uploadable" value='1'>
    </div>
  </div>

  <div class="col-md-12">
    <div class="col-md-4">
      <label class="pull-right">Requirements</label>
    </div>
    <div class="col-md-6">
      <input type="text" id="requirements" class="form-control">
      <input type="hidden" id="requirements_">
    </div>
    <div class="col-md-1"> 
      <button class="btn btn-success pull-right" onclick="job_requirements('<?php echo $company_id;?>','save','save');">SAVE</button>
    </div>
  </div>

    <div class="col-md-12" style="margin-top: 10px;">
    </div><br><br><br><br><br><br>
    <div class="box box-default" class='col-md-12'></div>
  </div>

  <table id="settings" class="table table-bordered table-striped">
    <thead>
      <tr class="danger">
        <th>No.</th>
        <th>Requirements</th>
        <th>Is Uploadable?</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; foreach($details as $row){?>
      <tr>
        <td> <?php echo $i;?></td>
        <td>
            <div id="o_title<?php echo $row->id;?>"><?php echo $row->title;?></div>
            <div id="u_title<?php echo $row->id;?>" style='display: none;'>
              <input type="text" class="form-control" id="title<?php echo $row->id;?>" value="<?php echo $row->title;?>" style='width:100%;'>
              <input type="hidden" id="title_<?php echo $row->id;?>">
            </div>
        </td>
        <td>
            <div id="o_isupload<?php echo $row->id;?>">  <?php if($row->IsUploadable==0){ echo "No"; }  else{ echo "Yes"; }?> </div>
            <div id="u_isupload<?php echo $row->id;?>" style='display: none;'> 
                <input type="radio" value="1" name="uupload<?php echo $row->id;?>" onclick="allow_upload('1','uploadable','<?php echo $row->id;?>')" <?php if($row->IsUploadable==1){ echo "checked"; } ?>> Yes
                <input type="radio" value="0"  name="uupload<?php echo $row->id;?>" value="0" onclick="allow_upload('0','uploadable','<?php echo $row->id;?>')" <?php if($row->IsUploadable==0){ echo "checked"; } ?>>  No
                <input type="hidden" id="uploadable<?php echo $row->id;?>" value='<?php echo $row->IsUploadable;?>'>
                <?php echo $row->id;?>
            </div>
        </td>
        <td>
            <?php if($row->InActive==0){ echo "Active"; }
            else{ echo "Not Active"; }?>
        </td>
        <td>
            <div id="original<?php echo $row->id;?>">
              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Requirement' onclick="job_requirements('<?php echo $company_id;?>','update','<?php echo $row->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Requirement' onclick="job_requirements('<?php echo $company_id;?>','delete','<?php echo $row->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                   <?php 
                        if($row->InActive==1){?> 
                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Requirement'  onclick="job_requirements('<?php echo $company_id;?>','enable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                              <?php } else { ?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Requirement'  onclick="job_requirements('<?php echo $company_id;?>','disable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                              <?php } ?>
            </div>
            <div id="update<?php echo $row->id;?>" style='display: none;'>
              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="job_requirements('<?php echo $company_id;?>','save_update','<?php echo $row->id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>
              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  onclick="job_requirements('<?php echo $company_id;?>','cancel','<?php echo $row->id;?>');"><i  class="fa fa-times fa-lg  pull-left"></i></a>
            </div>
        </td>
      </tr>
       <?php $i++; } ?>
        </tbody>
      </table>