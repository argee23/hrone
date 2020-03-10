<hr>
<?php
if($type=='ED1')
 { ?>

       <div class="col-md-12">
                      <div class="col-md-4"></div>
                      <div class="col-md-6">
                      <table id="SD1" class="col-md-10 table table-bordered table-striped" style="height: 10%;overflow: scroll;">
                        <thead>
                            <tr class="danger"><th colspan="2"><center>Emails Details <?php if(empty($details)){ echo "(no existing data please add)"; }else{}?></center></th></tr>
                        </thead>
                        <tbody>
                        <?php if(empty($details)){?>
                        <tr style="text-align: center;">
                            <td>SMTP HOST</td>
                            <td>
                                <input type="text" class="form-control" id="smtp_host" value="">
                                <input type="hidden" id="smtp_host_">
                              
                            </td>
                          </tr>
                          <tr style="text-align: center;">
                            <td>SMTP PORT</td>
                            <td>
                                <input type="text" class="form-control" id="smtp_port" value="">
                                <input type="hidden" id="smtp_port_">
                            </td>
                          </tr>
                          <tr style="text-align: center;">
                            <td>USERNAME</td>
                            <td>
                              
                                <input type="text" class="form-control" id="usernamehost" value="">
                                <input type="hidden" id="usernamehost_">
                            </td>
                          </tr>
                          <tr style="text-align: center;">
                            <td>PASSWORD</td>
                            <td>
                              
                                <input type="text" class="form-control" id="password" value="">
                                <input type="hidden" id="password_">
                              
                            </td>
                          </tr>
                          <tr style="text-align: center;">
                            <td>SEND MAIL FROM</td>
                            <td>
                                <input type="text" class="form-control" id="send_mail_from" value="">
                                <input type="hidden" id="send_mail_from_">
                              
                            </td>
                          </tr>

                          <tr style="text-align: center;">
                            <td>SECURITY TYPE</td>
                            <td>
                                <input type="text" class="form-control" id="security_type" value="">
                                <input type="hidden" id="security_type_">
                              
                            </td>
                          </tr>

                        <?php } else{ foreach($details as $row){?>
                          <tr style="text-align: center;">
                            <td>SMTP HOST</td>
                            <td>
                              <div id="o_host"><?php echo $row->smtp_host;?></div>
                              <div id="u_host" style="display: none;">
                                <input type="text" class="form-control" id="smtp_host" value="<?php echo $row->smtp_host;?>">
                                <input type="hidden" id="smtp_host_">
                              </div>
                            </td>
                          </tr>
                          <tr style="text-align: center;">
                            <td>SMTP PORT</td>
                            <td>
                              <div id="o_port"><?php echo $row->smtp_port;?></div>
                              <div id="u_port" style="display: none;">
                                <input type="text" class="form-control" id="smtp_port" value="<?php echo $row->smtp_port;?>">
                                <input type="hidden" id="smtp_port_">
                              </div>
                            </td>
                          </tr>
                          <tr style="text-align: center;">
                            <td>USERNAME</td>
                            <td>
                              <div id="o_username"><?php echo $row->username;?></div>
                              <div id="u_username" style="display: none;">
                                <input type="text" class="form-control" id="usernamehost" value="<?php echo $row->username;?>">
                                <input type="hidden" id="usernamehost_">
                              </div>
                            </td>
                          </tr>
                          <tr style="text-align: center;">
                            <td>PASSWORD</td>
                            <td>
                              <div id="o_password"><?php echo $row->password;?></div>
                              <div id="u_password" style="display: none;">
                                <input type="text" class="form-control" id="password" value="<?php echo $row->password;?>">
                                <input type="hidden" id="password_">
                              </div>
                            </td>
                          </tr>
                          <tr style="text-align: center;">
                            <td>SEND MAIL FROM</td>
                            <td>
                              <div id="o_mail_from"><?php echo $row->send_mail_from;?></div>
                              <div id="u_mail_from" style="display: none;">
                              <input type="text" class="form-control" id="send_mail_from" value="<?php echo $row->send_mail_from;?>">
                                <input type="hidden" id="send_mail_from_">
                              </div>
                            </td>
                          </tr>
                          <tr style="text-align: center;">
                            <td>Security Type</td>
                            <td>
                              <div id="o_security_type"><?php echo $row->security_type;?></div>
                              <div id="u_security_type" style="display: none;">
                              <input type="text" class="form-control" id="security_type" value="<?php echo $row->security_type;?>">
                                <input type="hidden" id="security_type_">
                              </div>
                            </td>
                          </tr>
                        <?php } } ?>
                        </tbody>
                        </table>
                      </div>
                      <div class="col-md-2"></div>

                      <div class="col-md-10" style="padding-top: 20px;">
                      <?php if(empty($details)){ ?>
                        <button class="btn btn-success pull-right" onclick="email_settings('<?php echo $type;?>','save','save','employer','<?php echo $account;?>','<?php echo $company_id;?>')" id="email_update">SAVE</button>
                      <?php }
                      else{?>
                        <button class="btn btn-success pull-right" onclick="email_settings('<?php echo $type;?>','<?php echo $row->id;?>','update','<?php echo $account;?>','<?php echo $company_id;?>')" id="email_update">UPDATE</button>
                        <button class="btn btn-danger pull-right" onclick="email_settings('<?php echo $type;?>','<?php echo $row->id;?>','cancel','<?php echo $account;?>','<?php echo $company_id;?>')" id="email_cancel" style='display: none;'>CANCEL</button>
                        <button class="btn btn-success pull-right" onclick="email_settings('<?php echo $type;?>','<?php echo $row->id;?>','save_update','employer','<?php echo $account;?>','<?php echo $company_id;?>')" id="email_save" style='display: none;margin-right: 10px;'>SAVE CHANGES</button>
                      <?php } ?>
                      </div>
                    </div>
<?php }
elseif($type=='ED7'){?>
  
    <div class="col-md-12" id="r<?php echo $type;?>">
        <div class="col-md-12">
          <div class="col-md-4">
            <label class="pull-right">Position</label>
          </div>
          <div class="col-md-6">
              <input type="text" id="position" class="form-control">
              <input type="hidden" id="position_">
          </div>
          <div class="col-md-1"> 
              <button class="btn btn-success pull-right" onclick="company_position('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save','save','save','save');">SAVE</button>
          </div>
        </div>
         <div class="col-md-12" style="margin-top: 10px;">
          </div><br><br><br>
        <div class="box box-default" class='col-md-12'></div>
    </div>

    <div class="col-md-12">
        <table id="<?php echo $type;?>" class="table table-bordered table-striped">
            <thead>
              <tr class="danger">
                <th>No.</th>
                <th style="width:30%;">Positions</th>
                <th style="width:30%;">Requirements</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; foreach($details as $row){?>
                <tr>
                     <td><?php echo $i;?></td>
                        <td>
                            <div id="oposition<?php echo $row->id;?>"><?php echo $row->position;?></div>
                            <div id="uposition<?php echo $row->id;?>" style='display: none';>
                              <input type="text" class="form-control" style="width:100%;" id="position<?php echo $row->id;?>" value="<?php echo $row->position;?>">
                              <input type="hidden" class="form-control" style="width:100%;" id="position_<?php echo $row->id;?>">
                            </div>
                        </td>
                        <td>
                              <?php foreach($req as $r)
                                 {?>
                                  <div class="col-md-12">
                                       <?php 
                                          $check_if_req = $this->recruitment_employer_management_model->check_job_requirements($company_id,$r->id,$row->id);
                                          if(empty($check_if_req)){?>
                                             <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Add Position'  onclick="company_position('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','add_req','<?php echo $row->id;?>','<?php echo $r->id;?>','deletereq');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg"></i></a>
                                              <?php  }
                                               else
                                               {?>
                                               <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Remove Position' onclick="company_position('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','delete_req','<?php echo $row->id;?>','<?php echo $r->id;?>','<?php echo $check_if_req->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg"></i></a>
                                              <?php  }
                                              echo $r->title;?> 
                                    </div>
                                    <?php }?>
                          </td>
                          <td><?php if($row->InActive==1){ echo "Inactive"; } else{ echo "Active";} ?></td>
                         <td>
                              <div id="o_position<?php echo $row->id;?>">
                                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Position' onclick="company_position('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','update','<?php echo $row->id;?>','update','update');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Position' onclick="company_position('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','delete','<?php echo $row->id;?>','delete','delete');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                               
                                <?php 
                                    if($row->InActive==1){?> 
                                       <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Position' onclick="company_position('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','enable','<?php echo $row->id;?>','enable','enable');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                                   
                                    <?php } else { ?>
                                    
                                    <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Position'  onclick="company_position('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','disable','<?php echo $row->id;?>','disable','disable');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                                                  <?php } ?>
                                            </div>

                              <div id="u_position<?php echo $row->id;?>" style='display: none;'>
                                  <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="company_position('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save_update','<?php echo $row->id;?>','save','save');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  onclick="company_position('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','cancel','<?php echo $row->id;?>','cancel','cancel');"><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                          
                              </div>
                        </td>
                      </tr>
                      <?php $i++; } ?>
                    </tbody>
                     </table>
                  </div>


<?php } else if($type=='ED2')
{?>

  <table id="<?php echo $type;?>" class="table table-bordered table-striped">
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

          $recheck_if_with_numbering = $this->recruitment_employer_management_model->get_numbering($company_id,$row->id);
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

                                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>'  data-toggle='modal' data-target='#modal1' href='<?php echo base_url();?>recruitment_employer/recruitment_employer_management/manage_interviewprocess_modal/<?php echo $type."/".$account."/".$company_id."/".$row->id;?>' title='Click to Manage Interview Process'><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                                            <?php } else{  echo "<n class='text-danger'>-</n>";  }}
                                        else{?>
                                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Package setting' onclick="employer_settings_status('<?php echo $type;?>','<?php echo $account;?>','update','<?php echo $row->id;?>','<?php echo $company_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete status' onclick="employer_settings_status('<?php echo $type;?>','<?php echo $account;?>','delete','<?php echo $row->id;?>','<?php echo $company_id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                             
                                         <?php 
                                          if($row->InActive==1){?> 
                                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable status' onclick="employer_settings_status('<?php echo $type;?>','<?php echo $account;?>','enable','<?php echo $row->id;?>','<?php echo $company_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                                                   <?php } else { ?>
                                                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable status' onclick="employer_settings_status('<?php echo $type;?>','<?php echo $account;?>','disable','<?php echo $row->id;?>','<?php echo $company_id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                                                    <?php } ?>
                                                    <?php }?>
                                      </div>
                                      <div id="update<?php echo $row->id;?>" style='display: none;'>
                                         
                                              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="employer_settings_status('<?php echo $type;?>','<?php echo $account;?>','save_update','<?php echo $row->id;?>','<?php echo $company_id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

                                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update' onclick="employer_settings_status('<?php echo $type;?>','<?php echo $account;?>','cancel','<?php echo $row->id;?>','<?php echo $company_id;?>');" ><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                           

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
    <button class="btn btn-success pull-right btn-xs" style="margin-top: 20px;margin-right: 5px;" onclick="savechanges_numbering('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>');" 
    id="savenumb"><i class="fa fa-check"></i>Save Updated Numbering</button>
  </div>

  <div id="action_viewing">
    <button class="btn btn-danger pull-right btn-xs" style="margin-top: 20px;" onclick="view_updating_comp('comp');">Update Computation Setting</button>
    <button class="btn btn-info pull-right btn-xs" style="margin-top: 20px;margin-right: 5px;" onclick="view_updating_numbering('num');">Update Numbering</button>
    <a class='btn btn-success btn-xs pull-right' style="margin-top: 20px;margin-right: 5px;"  class='btn btn-xs btn-default' data-toggle='modal' data-target='#modal' href='<?php echo base_url();?>recruitment_employer/recruitment_employer_management/add_new_status_modal/<?php echo $type."/".$account."/".$company_id;?>'  style='cursor:pointer;' title='Click to add new status'> Add New</a>
  </div>
  <div id="action_updating" style="display: none;">    
    <button class="btn btn-danger pull-right btn-xs" style="margin-top: 20px;" onclick="cancel_numbering();"><i class="fa fa-times"></i>Cancel</button>
    <button class="btn btn-success pull-right btn-xs" style="margin-top: 20px;margin-right: 5px;" onclick="savechanges_numbering('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>');" 
    id="savenumb"><i class="fa fa-check"></i>Save Updated Numbering</button>
  </div>


<?php } elseif($type=='ED6'){?>

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
      <button class="btn btn-success pull-right" onclick="job_requirements('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save','save');">SAVE</button>
    </div>
  </div>

    <div class="col-md-12" style="margin-top: 10px;">
    </div><br><br><br><br><br><br>
    <div class="box box-default" class='col-md-12'></div>
  </div>

  <table id="<?php echo $type;?>" class="table table-bordered table-striped">
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
              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Requirement' onclick="job_requirements('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','update','<?php echo $row->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Requirement' onclick="job_requirements('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','delete','<?php echo $row->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                   <?php 
                        if($row->InActive==1){?> 
                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Requirement'  onclick="job_requirements('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','enable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                              <?php } else { ?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Requirement'  onclick="job_requirements('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','disable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                              <?php } ?>
            </div>
            <div id="update<?php echo $row->id;?>" style='display: none;'>
              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="job_requirements('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','save_update','<?php echo $row->id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>
              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update'  onclick="job_requirements('<?php echo $type;?>','<?php echo $account;?>','<?php echo $company_id;?>','cancel','<?php echo $row->id;?>');"><i  class="fa fa-times fa-lg  pull-left"></i></a>
            </div>
        </td>
      </tr>
       <?php $i++; } ?>
        </tbody>
      </table>
<?php }
  elseif($type=='ED8'){?>


      


  <?php }
  else
  {

       $datas = $this->recruitment_employer_management_model->get_settings_single_data($company_id,$account,$settings->id);
      if(empty($datas)){ $d='save'; } else{ $d='update'; }
    ?>
  


        <div class="col-md-12" style="padding-top:70px;">
                        <div class="col-md-4">
                          <label class="pull-right"><?php echo $settings->field_title;?> </label>
                        </div>
                        <?php if($settings->format_1=='text'){ ?>

                          <div class="col-md-6">
                            <input type="<?php if($settings->format_2=='Alphanumerics'){ echo "text"; } else{ echo "number"; }?>" class="form-control" 
                            value="<?php if(empty($datas)){} else{ echo $datas; } ?>" id="<?php echo $settings->format_1;?>">
                            <input type="hidden" id="for_email">
                          </div> 

                          <?php } elseif($settings->format_1=='dropdown'){
                            $data = $settings->format_2;
                            $var=explode('-',$data); 
                          ?>

                          <div class="col-md-6">
                            <select class="form-control" id="<?php echo $settings->format_1;?>">
                            <option disabled <?php if(empty($datas)){ echo "selected"; }?>>Select</option>
                            <?php foreach($var as $v){?>
                              <option value="<?php echo $v;?>" <?php if(empty($datas)){} else{ if($v==$datas){ echo "selected"; } } ?>><?php echo $v;?></option>
                            <?php } ?>
                            </select>
                          </div>

                        <?php } elseif($settings->format_1=='datepicker'){ ?>

                          <div class="col-md-6">
                            <input type="<?php echo $settings->format_2;?>" class="form-control"  value="<?php if(empty($datas)){} else{ echo $datas; } ?>" id="<?php echo $settings->format_1;?>">
                          </div>

                        <?php } else{}?>  

                        <div class="col-md-1"><button class="btn btn-success" onclick="single_field_data_checker('<?php echo $type;?>','<?php echo $settings->format_1;?>','<?php echo $account;?>','<?php echo $company_id;?>','<?php echo $d;?>','<?php echo $settings->id;?>');">SAVE</button></div>
       </div>


<?php } ?>


<div id="modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>