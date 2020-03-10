  <?php 
       
         $company_id = $this->uri->segment('4');
         $od_id = $this->uri->segment('5');
         $date_effective = $this->uri->segment('6');
         $pay_type_id = $this->uri->segment('7');
         $cutoff = $this->uri->segment('8');
        
          
  ?>  


<div class="well">
  <div class="form-horizontal">
   <div class="box-body">
      <div class="form-group">
                

 
   <div class="col-md-12" >
<center>
           <form target="_blank" action="<?php echo base_url(); ?>app/payroll_other_deduction_automatic/upload" method="post" name="upload_excel" enctype="multipart/form-data">

                             <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
                             <input type="hidden" name="other_deduction_id" id="other_deduction_id" value="<?php echo $od_id; ?>">
                             <input type="hidden" name="date_effectivity" id="date_effectivity" value="<?php echo $date_effective; ?>">
                             <input type="hidden" name="pay_type_id" id="pay_type_id" value="<?php echo $pay_type_id; ?>">
                             <input type="hidden" name="cutoff" id="cutoff" value="<?php echo $cutoff; ?>">
                             <input type="hidden" name="entry_type" id="entry_type" value="manual_upload">
                           

                  <div class="col-md-12" >
                    <div class="box box-default">
                    <div class="panel panel-info">
                      <div class="panel-heading"><strong><center>UPLOADING TEMPLATE</center></strong></div>


                        <div class="box-body" style="height:330px;" >
                       
                          <div style="padding-top: 80px;"> 
                              <center> 
                                


                                <p><u><strong><n class="text-success">Download Template</n></strong></u></p>
                                          <b><input class="btn btn-primary" type="button" name="template" id="template" onclick="lin_auto();" value="Download Template Now"></b>

                                     <p><u><strong><n class="text-success">Upload Template</n></strong></u></p>
                                     <div class="form-group" ng-class="{'has-error': userForm.file.$invalid}">
                                      <div class="btn btn-info ">
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
                                </div>
                          
                           <button type="submit" id="submit" name="import" class="btn btn-success btn-xs" onclick="myFunctionee()" ><i class="fa fa-upload"></i> Import</button>
              </form>
          </center>
    </div>
  </div>
</div>
</div>
</div>    

    </div>  

            </div>                        
        </div><!-- /.box-body -->
      </div>
  </div>

   
