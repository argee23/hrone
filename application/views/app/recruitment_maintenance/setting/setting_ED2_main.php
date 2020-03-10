 <table id="settings" class="table table-bordered table-striped">
      <thead>
          <tr class="danger">
              <th>ID</th>
              <th>Numbering</th>
              <th>Include in Vacant Slot Computation</th>
              <th>Status Title</th>
              <th  style="width:40%;">Description</th>
              <th>Color Code</th>
              <th>Status</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
        <?php $i=1; foreach($details as $row){

          $recheck_if_with_numbering = $this->recruitment_hris_model->get_numbering($company_id,$row->id);
          ?>
          <tr">
              <td>
                  <?php echo $row->id;?>
              </td>
              <td>
                <div id="numbering_viewing<?php echo $i;?>"> 
                  <?php if(empty($recheck_if_with_numbering->numbering)){ echo $i; } else{ echo $recheck_if_with_numbering->numbering; };?>
                  <input type="hidden" id="numberingid<?php echo $i;?>" value="<?php echo $row->id;?>">
                </div>
                <div id="numbering_update<?php echo $i;?>" style="display:none;">
                   
                    <select class="form-control numbering_value" id="numberingvalue<?php echo $i;?>" name="numbering<?php echo $row->id;?>"> 
                       <?php $co_o = count($details);  
                             if(empty($recheck_if_with_numbering->numbering)){ $v =  $i; } else{ $v = $recheck_if_with_numbering->numbering; }
                             for ($x = 1; $x <= $co_o; $x++) {?>
                            <option <?php if($v==$x){ echo "selected"; }?>><?php echo $x;?></option>";
                        <?php }?>
                    </select>

                </div>
              </td>
              <td>
                  <div id="computation_viewing<?php echo $i;?>"> 
                    <?php if(empty($recheck_if_with_numbering->include_in_computation_job_vacancy)){ echo "no"; } else{ if($recheck_if_with_numbering->include_in_computation_job_vacancy==1){ echo "yes"; } else{ echo "no"; } };?>
                    <input type="hidden" id="computationid<?php echo $i;?>" value="<?php echo $row->id;?>">
                  </div>
                  <div id="computation_update<?php echo $i;?>" style="display:none;">
                      <select class="form-control computation_value" id="computationvalue<?php echo $i;?>" name="computation<?php echo $row->id;?>"> 
                        <option value="1" <?php if(!empty($recheck_if_with_numbering->include_in_computation_job_vacancy) AND $recheck_if_with_numbering->include_in_computation_job_vacancy==1){ echo "selected"; } ?>>yes</option>
                        <option value="0" <?php if(empty($recheck_if_with_numbering->include_in_computation_job_vacancy) || $recheck_if_with_numbering->include_in_computation_job_vacancy==0){ echo "selected"; } ?>>no</option>
                      </select>
                  </div>

              </td>
              <td>
                  <div id="o_title<?php echo $row->id;?>"><?php echo $row->status_title;?></div>
                    <div id="u_title<?php echo $row->id;?>" style='display: none;'>
                        <input type="text" class="form-control" id="title<?php echo $row->id;?>" value="<?php echo $row->status_title;?>" style='width:100%;'>
                        <input type="hidden" id="title_<?php echo $row->id;?>">
                    </div>
              </td>
              <td>
                  <div id="o_description<?php echo $row->id;?>"><?php echo $row->status_description;?></div>
                    <div id="u_description<?php echo $row->id;?>" style='display: none;'>
                        <input type="text" class="form-control" id="description<?php echo $row->id;?>"  value="<?php echo $row->status_description;?>" style='width:100%;'>
                        <input type="hidden" id="description_<?php echo $row->id;?>">
                    </div>
              </td>
              <td>
                  <div id="o_color<?php echo $row->id;?>"><input type="color" value="<?php echo $row->color_code;?>" disabled></div>
                    <div id="u_color<?php echo $row->id;?>" style='display: none;'>
                        <input type="color" value="<?php echo $row->color_code;?>" id="color<?php echo $row->id;?>">
                        <input type="hidden" id="color_<?php echo $row->id;?>">
                    </div>
              </td>
              <td>
                  <?php if($row->InActive==0){ echo "Active"; }
                  else{ echo "Not Active"; }?>
              </td>
              <td>
                
                                      <div id="original<?php echo $row->id;?>">

                                       
                                        <?php if($row->IsDefault==1){ 
                                            if($row->id==1){ ?>

                                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>'  data-toggle='modal' data-target='#modal1' href='<?php echo base_url();?>app/recruitment_hris/ED2_manage_interviewprocess_modal/<?php echo $company_id."/".$row->id."/".$code;?>' title='Click to Manage Interview Process'><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                                            <?php } else{  echo "<n class='text-danger'>-</n>";  }}
                                        else{?>
                                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Package setting' onclick="employer_settings_status('update','<?php echo $row->id;?>','<?php echo $company_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete status' onclick="employer_settings_status('delete','<?php echo $row->id;?>','<?php echo $company_id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                             
                                         <?php 
                                          if($row->InActive==1){?> 
                                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable status' onclick="employer_settings_status('enable','<?php echo $row->id;?>','<?php echo $company_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                                                   <?php } else { ?>
                                                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable status' onclick="employer_settings_status('disable','<?php echo $row->id;?>','<?php echo $company_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                                                    <?php } ?>
                                                    <?php }?>
                                      </div>
                                      <div id="update<?php echo $row->id;?>" style='display: none;'>
                                         
                                              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="employer_settings_status('save_update','<?php echo $row->id;?>','<?php echo $company_id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update' onclick="employer_settings_status('cancel','<?php echo $row->id;?>','<?php echo $company_id;?>');" ><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                           

                                      </div>

                </td>
              </tr>
              <?php $i++; } echo "<input type='text' name='numbering_count' id='numbering_count' value='".$i."' style='display:none;'>"; ?>
        </tbody>
  </table>
  <input type="hidden" id="checking_empty" value="0">
  <input type="hidden" id="update_checking" value="0">

  <div id="action_updatingcomp" style="display: none;"> 
    <button class="btn btn-danger pull-right btn-xs" style="margin-top: 20px;" onclick="cancel_numbering();"><i class="fa fa-times"></i>Cancel</button>
    <button class="btn btn-success pull-right btn-xs" style="margin-top: 20px;margin-right: 5px;" onclick="savechanges_numbering('<?php echo $company_id;?>');" 
    id="savenumb"><i class="fa fa-check"></i>Save Updated Numbering</button>
  </div>

  <div id="action_viewing">
    <button class="btn btn-danger pull-right btn-xs" style="margin-top: 20px;" onclick="view_updating_comp('comp');">Update Computation Setting</button>
    <button class="btn btn-info pull-right btn-xs" style="margin-top: 20px;margin-right: 5px;" onclick="view_updating_numbering('num');">Update Numbering</button>
    <a class='btn btn-success btn-xs pull-right' style="margin-top: 20px;margin-right: 5px;"  class='btn btn-xs btn-default' data-toggle='modal' data-target='#modal' href='<?php echo base_url();?>app/recruitment_hris/ED2_add_new_status_modal/<?php echo $company_id."/".$code;?>'  style='cursor:pointer;' title='Click to add new status'> Add New</a>
  </div>
  <div id="action_updating" style="display: none;">    
    <button class="btn btn-danger pull-right btn-xs" style="margin-top: 20px;" onclick="cancel_numbering();"><i class="fa fa-times"></i>Cancel</button>
    <button class="btn btn-success pull-right btn-xs" style="margin-top: 20px;margin-right: 5px;" onclick="savechanges_numbering('<?php echo $company_id;?>');" 
    id="savenumb"><i class="fa fa-check"></i>Save Updated Numbering</button>
  </div>


