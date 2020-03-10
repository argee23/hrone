 <div class='col-md-4' style="padding-top: 5px;">
                 <div class="col-md-3"><label>Company:</label></div>
                    <div class="col-md-9">
                       <select class="form-control" id='update_setting_company'>
                            <?php foreach($companyList as $company){ if($get_data->company_id==$company->company_id){?>
                            <option value="<?php echo $company->company_id?>" selected><?php echo $company->company_name?></option>
                            <?php } else{} } ?>
                        </select>
                  </div>
                </div>
              <div class='col-md-3' style="padding-top:5px;">
                  <div class="col-md-3"><label>Days:</label></div>
                    <div class="col-md-9">
                      <input type='number' class='form-control'  id='update_setting_days' value="<?php echo $get_data->days?>">
                  </div>
                </div>
                 <div class='col-md-3' style="padding-top:5px;">
                  <div class="col-md-3"><label>Status:</label></div>
                    <div class="col-md-9">
                     <select class="form-control" name='setting_status' id='update_setting_status'>
                        <option value='approved' <?php if($get_data->action=='approved'){ echo "selected"; }?>>Approved</option>
                        <option value='cancelled' <?php if($get_data->action=='approved'){ echo "selected"; }?>>Cancelled</option>
                        <option value='rejected' <?php if($get_data->action=='approved'){ echo "selected"; }?>>Rejected</option>
                     </select>
                  </div>
                </div>
                <div class='col-md-2' style="padding-top: 5px;">
                  <div class="col-md-3"></div>
                    <div class="col-md-9">
                     <button class='btn btn-success' onclick="save_status_setting_update('<?php echo $transaction_id?>','<?php echo $get_data->id?>')">SAVE CHANGES</button>
                  </div>
 </div>