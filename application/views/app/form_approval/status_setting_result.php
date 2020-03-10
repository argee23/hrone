<div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:50px;">
          <div class="col-md-12" id='setting_edit'>
           <div class='col-md-4' style="padding-top: 5px;">
                  <div class="col-md-3"><label>Company:</label></div>
                    <div class="col-md-9">
                       <select class="form-control" id='setting_company'>
                             <option selected disabled value='0'>Select Company</option>
                            <?php foreach($companyList as $company){ if($UserDefine==0){?>
                                    <option value="<?php echo $company->company_id?>" <?php foreach ($status_setting as $s) { if($s->company_id==$company->company_id){ echo "disabled"; } }?>><?php echo $company->company_name?></option> <?php } else{ if($UserDefine==$company->company_id){ ?>
                                    <option value="<?php echo $company->company_id?>" <?php foreach ($status_setting as $s) { if($s->company_id==$company->company_id){ echo "disabled"; } }?>><?php echo $company->company_name?></option>
                            <?php } else{} } } ?>
                        </select>
                  </div>
                </div>
              <div class='col-md-3' style="padding-top:5px;">
                  <div class="col-md-3"><label>Days:</label></div>
                    <div class="col-md-9">
                      <input type='number' class='form-control'  id='setting_days'>
                  </div>
                </div>
                 <div class='col-md-3' style="padding-top:5px;">
                  <div class="col-md-3"><label>Status:</label></div>
                    <div class="col-md-9">
                     <select class="form-control" name='setting_status' id='setting_status'>
                        <option value='0' selected disabled>Select</option>
                        <option value='approved'>Approved</option>
                        <option value='cancelled'>Cancelled</option>
                        <option value='rejected'>Rejected</option>
                     </select>
                  </div>
                </div>
                <div class='col-md-2' style="padding-top: 5px;">
                  <div class="col-md-4"></div>
                    <div class="col-md-8">
                     <button class='btn btn-success' onclick="save_status_setting_add('<?php echo $transaction_id?>')">SAVE</button>
                  </div>
                </div>
        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
        <?php if($this->session->flashdata('success_inserted') AND $action_=='add')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.'  Setting is Successfully Added.</center></n></div>';
            } 
           else if($this->session->flashdata('insert_error') AND $action_=='add' )
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in adding Company ID - '.$flash_id.' Setting. PLease try again later.</center></n></div>';
            } 
            else if($this->session->flashdata('success_deleted') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>ID - '.$flash_id.'  Setting is Successfully Deleted.</center></n></div>';
            }
            else if($this->session->flashdata('delete_error') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in deleting ID - '.$flash_id.'  Setting. PLease try again later.</center></n></div>';
            }
            else if($this->session->flashdata('success_updated') AND $action_=='update')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>Company ID - '.$flash_id.'  Setting is Successfully Updated.</center></n></div>';
            }
            else if($this->session->flashdata('update_error') AND $action_=='delete')
            { 
              echo '<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"> <center>There is an error in updating Company ID - '.$flash_id.' Setting. PLease try again later.</center></n></div>';
            }
            else{}?>
        <div class="col-md-12" id='status_settings'>
         <table id="status_setting" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th>ID</th>
                    <th>Company ID</th>
                    <th>Company Name</th>
                    <th>Days</th>
                     <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($status_setting as $ss) { ?>
                  <tr>
                       <td><?php echo $ss->id?></td>
                       <td><?php echo $ss->company_id?></td>
                      <td><?php echo $ss->company_name?></td>
                      <td><?php echo $ss->days?></td>
                      <td><?php echo $ss->action?></td>
                      <td>
                        <a class='fa fa-pencil-square-o' aria-hidden='true' data-toggle='tooltip' title='Click to edit!' onclick='edit_status_setting("<?php echo $ss->id;?>","<?php echo $ss->company_id?>","<?php echo $transaction_id?>")'></a>
                         <a class='fa fa-trash' aria-hidden='true' data-toggle='tooltip' title='Click to delete record!'  onclick='delete_status_setting("<?php echo $ss->id;?>","<?php echo $transaction_id?>")'></a>
                      </td>
                  </tr>
                <?php } ?>
                </tbody>
       </table>  
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div>
