 <div class="col-md-12">
                <div class='col-md-5'>
                       <div class="col-md-4"><label>Company:</label></div>
                        <div class="col-md-8" id='r_company'>
                          <select class="form-control" id='company_classlevel' onchange="enable_class_level_option(this.value)" disabled> 
                                <option value='' selected disabled>Select Company</option>
                                 <?php 
                                foreach($companyList as $company){?>
                                  <option value='<?php echo $company->company_id?>' <?php foreach ($classlevelList_one as $one) { if($one->company_id==$company->company_id) { echo "selected"; } }?>><?php echo $company->company_name?></option>
                              <?php } ?>
                          </select>
                        </div>
                </div>
                <div class='col-md-5'>
                         <div class="col-md-5"><label>Setting Option</label></div>
                          <div class="col-md-7"  id='r_option'>
                              <select class="form-control" id='class_level_option'> 
                                  <option selected disabled value=''>Select Option</option>
                                  <option value="classification" <?php foreach ($classlevelList_one as $one) { if($one->classification_level_access=='classification') { echo "selected"; } }?>>By Classification</option>
                                  <option value="level" <?php foreach ($classlevelList_one as $one) { if($one->classification_level_access=='level') { echo "selected"; } }?>>By Level</option>
                              </select>
                          </div>
                </div>
                
                <div class='col-md-2'><button class='btn btn-success' onclick="save_level_classification_setting('update');">SAVE CHANGES</button>