
          <div class="col-md-12">
                <div class='col-md-5'>
                       <div class="col-md-4"><label><u>Company:</u></label></div>
                        <div class="col-md-8" >
                        <select id='setting_company' class="form-control" disabled>
                              <option disabled selected value="">Select Company</option>
                              <?php foreach($companyList as $company){  ?>
                              <option value="<?php echo $company->company_id?>" <?php if($company_id==$company->company_id){ echo "selected"; } else{}?>><?php echo $company->company_name?></option>
                              <?php } ?>
                        </select>
                        </div>
                </div>
                <div class='col-md-5'>
                         <div class="col-md-7"><label><u>Number of Approvers:</u></label></div>
                          <div class="col-md-5"  id='r_option'>
                              <select class="form-control" id='setting_no_approvers_edit' > 
                                 <option disabled selected value="">Select</option>
                                <?php for($i=1;$i < 50; $i++)
                                  {?> <option value='<?php echo $i?>'  <?php if($no_approver==$i){ echo "selected"; } else{}?>><?php echo $i?></option>"; 
                                  <?php } ?>
                                ?>
                              </select>
                          </div>
                </div>
                
                <div class='col-md-2'><button class='btn btn-success' onclick="saveupdate_no_approver_setting(<?php echo $company_id?>);">UPDATE CHANGES</button></div>
        </div>