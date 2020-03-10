<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Manual Uploading</h4></ol>


    <div class="box-body" style="height:330px;" >
   
      <div style="padding-top: 60px;"> 
          <center> 
               <form target="_blank" action="<?php echo base_url(); ?>app/payroll_emp_loan_enrolment/plot_schedules_upload" method="post" name="upload_excel" enctype="multipart/form-data">
                  <p><u><strong><n class="text-success">Import Working Schedule Template</n></strong></u></p>
                    <div class="form-group" ng-class="{'has-error': userForm.file.$invalid}">
                      <div class="btn btn-info">
                        <input type="file" name="file" id="file" ng-model="first_name" accept=".xls,.xlsx" required>
                      </div><br>
                      <n class="text-danger"></n><br>
                        <div class="col-md-3"></div>
                           <div class="col-md-6">
                              <input type="hidden" id="company" name="company" value="1">
                               <input type="hidden" id="loan" name="loan" value="1">
                               <select class="form-control" name="action" id="action" required>
                               <option value="">Select Action</option>
                                <option value="Save">Upload and Save</option>
                                <option value="Review">Upload and Review</option>
                               </select>
                            </div>
                        </div><br><br>
                      <button onclick="myFunction()" type="submit" id="submit" name="import" class="btn btn-primary btn-xs"><i class="fa fa-upload"></i> Import</button>
                      <a href="<?php echo base_url(); ?>app/plot_schedules/download_ws" type="submit" id="submit" name="import" class="btn btn-warning btn-xs"><i class="fa fa-upload"></i> Download Template</a>
              </form>
          </center>
    </div>
  </div>


<div class="box box-danger" class='col-md-12'></div>
