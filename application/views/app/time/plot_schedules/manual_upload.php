<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Manual Uploading</h4></ol>


    <div class="box-body" style="height:370px;" >
   
      <div style="padding-top: 10px;"> 
          <center> 
               <form target="_blank" action="<?php echo base_url(); ?>app/upload_working_schedules/upload" method="post" name="upload_excel" enctype="multipart/form-data">
                      <p><u><strong><n class="text-success">Import Working Schedule Template</n></strong></u></p>
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
                                   <select class="form-control" name="paytype" id="paytype" onchange="manual_ws_get_group(this.value);" required>
                                    <option value="" disabled selected >Select PayType</option>
                                    <?php foreach($paytypeList as $p){
                                    ?>
                                      <option value="<?php echo $p->pay_type_id;?>"><?php echo $p->pay_type_name;?></option>
                                    <?php } ?>
                                   </select>
                                </div>
                                <div class="col-md-12" style="margin-top: 5px;">
                                   <select class="form-control" name="group" id="group" onchange="get_payroll_period_manual(this.value);" required>
                                    <option value="" disabled selected >Select Group</option>
                                   </select>
                                </div>
                                <div class="col-md-12" style="margin-top: 5px;">
                                   <select class="form-control" name="payroll_period" id="payroll_period" required>
                                    <option value="" disabled selected >Select Payroll  Period</option>
                                   </select>
                                </div>
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <select class="form-control" name="option" id="option" required onchange="option_status(this.value);">
                                      <option value="" disabled selected >Select Option</option>
                                      <option value="reset_add" style="color:red;">Reset Employee Payroll Period Schedule</option>
                                      <option value="overwrite_add">Overwrite existing schedule(if no existing data system will add the schedule)</option>
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
                                  <a href="<?php echo base_url(); ?>app/upload_working_schedules/download_ws" type="submit" id="submit" name="import" class="btn btn-warning btn-xs"><i class="fa fa-upload"></i> Download Template</a>
                               </div>


                          </div>

                          <div class="col-md-3"></div>

                      </div>

              </form>
          </center>
    </div>
  </div>


<div class="box box-danger" class='col-md-12'></div>
