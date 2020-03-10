<div class="col-md-12" >
<div class="box box-default">
<div class="panel panel-success">
  <div class="panel-heading"><strong><center>EMPLOYEE LOAN MASS UPLOADING</center></strong></div>


    <div class="box-body" style="height:330px;" >
    <a href="<?php echo base_url().'app/payroll_emp_loan_enrolment/download_emp_loan_enrolment_mass_upload';?>" type="button" class="btn btn-warning btn-xs btn pull-right" title="Download Template" ><i class="fa fa-download"></i> Download Template</a> 
    	<div style="padding-top: 80px;"> 
    	 		<center> 
              <form target="_blank" action="<?php echo base_url(); ?>app/payroll_emp_loan_enrolment/loan_mass_upload" method="post" name="upload_excel" enctype="multipart/form-data">
                  <p><u><strong><n class="text-success">Import Employee Template</n></strong></u></p>
                  
                    <div class="form-group" ng-class="{'has-error': userForm.file.$invalid}">
                      <div class="btn btn-info">
                        <input type="file" name="file" id="file" ng-model="first_name" accept=".xls,.xlsx" required>
                      </div><br>
                      <n class="text-danger"></n><br>
                        <div class="col-md-3"></div>
                           <div class="col-md-6">
	                             <select class="form-control" name="action" id="action" required>
                               <option value="">Select Action</option>
                                <option value="Save">Upload and Save</option>
	                             	<option value="Review">Upload and Review</option>
	                             </select>
                            </div>
                        </div><br><br>
                      <button onclick="myFunction()" type="submit" id="submit" name="import" class="btn btn-primary btn-xs"><i class="fa fa-upload"></i> Import</button>
              </form>
          </center>
    </div>
  </div>
</div>
</div>
</div>  


