
         <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#gencoe" data-toggle="tab"><i class="fa fa-file text-danger"></i> Generate COE [Mass Encoding]</a></li>
                     
                    </ul>

              <div class="tab-content">

                <!-- ADMIN REMINDERS -->
                <div class="active tab-pane" id="gencoe">

    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i> Generate Certificate Of Employment</b></n></a>
              </li>
          </ul>
      </div>
      
       <div class="box-body">
            <form class="form-horizontal" method="post" name="format2_coe" action="<?php echo base_url()?>app/employee_reports/extract_coe_format2" target="_blank" onsubmit="return validateForm()">
            <div class="col-md-12">
            <div class="col-md-3">Company</div>
            <div class="col-md-6">        
            <select class="form-control" name="company_id" id="company_id" required  >
          <!--   <option selected disabled value=""> Select Company</option> -->
            <?php              
            if(!empty($companyList)){
            foreach($companyList as $c){
            echo '<option  value="'.$c->company_id.'"> '.$c->company_name.'</option>';
            }
            }else{
            }
            ?>
            </option>
            </select>
            </div>
            </div>

<!--             <div class="col-md-12" style="display: hidden;">
            <div class="col-md-3">Resigned Date <span class="">(not required)</span></div>
            <div class="col-md-6">   -->      
              <input type="hidden" class="form-control" name="resigned_date" >
     <!--        </div>
            </div>    
              -->
            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Employee Status</div>
            <div class="col-md-6">        
            <select class="form-control" name="employee_status" id="employee_status" required  >
            <option selected value="active">Active</option>
            <option value="inactive">InActive</option>
            </select>
            </div>
            </div> 

            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Address</div>
            <div class="col-md-6">        
                  <input type="radio" name="emp_address" value="present_address">Present Address<br>
                  <input type="radio" name="emp_address"  value="permanent_address" checked>Permanent Address <br>
            </div>
            </div> 

            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Employment Type</div>
            <div class="col-md-6">        
               <input type="checkbox" checked name="employment_type_01" id="employment_type_follow" onclick="coe_2_checker('employment_type_follow','employment_type');">Follow employee employment type<br>
               <input type="text" class="form-control" disabled name="employment_type_02" id="employment_type_02">
               <input type="hidden" value="employment_type_01" class="form-control" name="employment_type" id="employment_type">

            </div>
            </div> 

            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Company Name</div>
            <div class="col-md-6">        
               <input type="checkbox" id="company_name_follow" name="company_name_follow" checked onclick="coe_2_checker('company_name_follow','company_name');" >Follow employee company<br>
                <input type="text" class="form-control" disabled name="company_name_02" id="company_name_02">
                <input type="hidden" value="company_name_01" class="form-control" name="company_name" id="company_name">
            </div>
            </div> 



            
            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Request OF:</div>
            <div class="col-md-6">        
                  <input type="radio" name="request_of" value="first_name" onclick="coe_2_namee('first_name','namee');">First Name<br>
                  <input type="radio" name="request_of"  value="last_name" checked onclick="coe_2_namee('last_name','namee');">Last Name <br>
                  <input type="radio" name="request_of"  value="fullname" onclick="coe_2_namee('fullname','namee');">FullName 
                  <input type="hidden" name="namee" id="namee" value="last_name"> 
            </div>
            </div>


            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Reason for COE</div>
            <div class="col-md-6">        
            <input type="text" class="form-control" name="coe_reason" required>
            </div>
            </div>
            

            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Signed Date </div>
            <div class="col-md-6">        
            <input type="date" class="form-control" name="signed_date" value="<?php echo date('Y-m-d');?>" required>
            </div>
            </div> 

            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Date Issued </div>
            <div class="col-md-6">        
              <input type="date" class="form-control" name="date_issued" id="date_issued" value="<?php echo date('Y-m-d');?>">
            </div>
            </div> 

            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Company Address </div>
            <div class="col-md-6">        
               <input type="checkbox" id="company_address_follow" name="company_address_follow" checked onclick="coe_2_checker('company_address_follow','company_address');" >Follow company address<br>
               <input type="text" class="form-control" disabled name="company_address_02" id="company_address_02">
               <input type="hidden" value="company_address_01" class="form-control" name="company_address" id="company_address">
            </div>
            </div> 

            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">Others</div>
            <div class="col-md-6">        
                  <input type="checkbox" name="other_01" >Company Logo<br>
                  <input type="checkbox" name="other_02" >Company Details [Name and address] <br> 
            </div>
            </div> 

            <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3"></div>
            <div class="col-md-6">  
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Generate</button>
            </div>
            </div>
            </form>
       </div> <!-- box body -->

  </div>

  </div><!-- admin rem -->
 </div>
</div>
</div>



