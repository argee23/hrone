<div class="col-md-12" >
  <div class="box box-info">
    <div class="panel panel-success">
      <div class="panel-heading"><h4><strong><center>Salary Information Manual Upload</center></strong></h4></div>
        <div class="box-body" style="height:400px;" >
          <div class="col-md-12">
          </div>
          
            <div style="padding-top: 60px;"> 
          <center> 
               <form target="_blank" action="<?php echo base_url(); ?>app/salary_information_manual_upload/upload" method="post" name="upload_excel" enctype="multipart/form-data">
                      <p><u><strong><n class="text-success">Import Salary Information Template</n></strong></u></p>
                      <div class="col-md-12">
                         
                          <div class="col-md-3"></div>

                          <div class="col-md-6">
                                <div class="col-md-12">
                                   <select class="form-control" name="company" id="company" required>
                                    <option value="" disabled selected >Select Company</option>
                                    <?php foreach($companyList as $c){?>
                                      <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                                    <?php } ?>
                                   </select>
                                </div>
                              
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <select class="form-control" name="option" id="option" required onchange="option_status(this.value);">
                                      <option value="" disabled selected >Select Option</option>
                                      <option value="reset" style="color:red;">Reset Company Salary Information</option>
                                      <!-- <option value="overwrite_add">Overwrite existing employee salary information(if no existing data system will add the salary)</option> -->
                                      <option value="add">Add employee salary information</option>
                                    </select>
                                </div>

                                <div class="col-md-12" style="margin-top: 5px;">
                                   <select class="form-control" name="action" id="action">
                                      <option value="" disabled selected >Select Action</option>
                                      <option>Save</option>
                                      <option>Review</option>
                                   </select>
                                </div>

                               <div class="col-md-12" style="margin-top: 5px;">
                                <div class="col-md-12 btn btn-info" id="upload">
                                    <input type="file" name="file" id="file" ng-model="first_name" accept=".xls,.xlsx">
                                </div>  
                               </div>

                               <div class="col-md-12" style="margin-top: 5px;">
                                  <button onclick="myFunction()" type="submit" id="submit" name="import" class="btn btn-primary btn-xs"><i class="fa fa-upload"></i> Import</button>
                                  <a href="<?php echo base_url().'app/salary_information_manual_upload/salary_information_manualupload_template';?>"  type="submit" id="submit" name="import" class="btn btn-warning btn-xs"><i class="fa fa-upload"></i> Download Template</a>
                               </div>


                          </div>

                          <div class="col-md-3"></div>

                      </div>

              </form>
          </center>
    </div>

      </div>
    </div>
  </div>
</div>  


