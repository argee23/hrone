 <div class="col-md-12">
                <div class='col-md-5'>
                       <div class="col-md-4"><label>Company :</label></div>
                        <div class="col-md-8" id='r_company'>
                          <select class="form-control" id='company_allow' onchange="enable_class_level_option(this.value)" disabled> 
                                <option value='' selected disabled>Select Company</option>
                                 <?php 
                                foreach($companyList as $company){
                                  if($company->company_id==$access->company_id){ $cc='selected'; } else{ $cc=''; }
                                ?>
                                  <option value='<?php echo $company->company_id?>' <?php echo $cc;?>><?php echo $company->company_name?></option>
                              <?php } ?>
                          </select>
                        </div>
                </div>
                <div class='col-md-5'>
                         <div class="col-md-5"><label>Allow_access?</label></div>
                          <div class="col-md-7"  id='r_option'>
                              <select class="form-control" id='option_allow'> 
                               <option selected disabled value=''>Select Option</option>
                                   <option value="1" <?php if(!empty($access->data)){ if($access->data==1){ echo "selected"; }}?>>Yes</option>
                                  <option value="0" <?php if(!empty($access->data)){ if($access->data==0){ echo "selected"; }}?>>No</option>
                              </select>
                          </div>
                </div>
                <div class='col-md-2'><button class='btn btn-success' onclick="save_plot_own_schedule('update');">SAVE CHANGES</button></div>