 <div class="col-md-12">
                <div class='col-md-5'>
                       <div class="col-md-4"><label>Company :</label></div>
                        <div class="col-md-8" id='r_company'>
                          <select class="form-control" id='company_allow' onchange="enable_class_level_option(this.value)" disabled> 
                                <option value='' selected disabled>Select Company</option>
                                 <?php 
                                foreach($companyList as $company){?>
                                  <option value='<?php echo $company->company_id?>' <?php foreach ($allowaccessList_one as $one) { if($one->company_id==$company->company_id) { echo "selected"; } }?>><?php echo $company->company_name?></option>
                              <?php } ?>
                          </select>
                        </div>
                </div>
                <div class='col-md-5'>
                         <div class="col-md-5"><label>Allow_access?</label></div>
                          <div class="col-md-7"  id='r_option'>
                              <select class="form-control" id='option_allow'> 
                               <option selected disabled value=''>Select Option</option>
                                  <option value="can_view" <?php foreach ($allowaccessList_one as $one) { if($one->allow_access=='can_view') { echo "selected"; } }?> >can access plotted schedule</option>
                                  <option value="cannot_view" <?php foreach ($allowaccessList_one as $one) { if($one->allow_access=='cannot_view') { echo "selected"; } }?>>can't access plotted schedule</option>
                                  <option value="no_access" <?php foreach ($allowaccessList_one as $one) { if($one->allow_access=='no_access') { echo "selected"; } }?>>no accees in entire personnel working schedule</option>
                                 
                              </select>
                          </div>
                </div>
                <div class='col-md-2'><button class='btn btn-success' onclick="save_allow_access_setting('update');">SAVE CHANGES</button></div>