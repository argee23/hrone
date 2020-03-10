
         <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#gencoe" data-toggle="tab"><i class="fa fa-file text-danger"></i> Generate COE</a></li>
                      <li><a href="#coeset" data-toggle="tab"><i class="fa fa-key text-danger"></i> COE Signatory</a></li>
                      <li><a href="#coesetting" data-toggle="tab"><i class="fa fa-key text-danger"></i> COE Settings</a></li>
             
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
            <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/employee_reports/extract_coe_format2" target="_blank" >
            <div class="col-md-12">
            <div class="col-md-3">Employee name</div>
            <div class="col-md-6">        
            <select class="form-control" name="company_id" id="company_id" required  >
          <!--   <option selected disabled value=""> Select Company</option> -->
            <?php              
            if(!empty($employee)){
            foreach($employee as $employee){
            echo '<option  value="'.$employee->employee_id.'"> '.$employee->fullname.'</option>';
            }
            }else{
            }
            ?>
           
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
            <div class="col-md-12">
            <div class="col-md-3">Address</div>
            <div class="col-md-6">        
            <input type="text" class="form-control" name="address_employee" required="">
            </div>
            </div> 

            <div class="col-md-12">
            <div class="col-md-3">Employment Type</div>
            <div class="col-md-6">        
            <select class="form-control" name="employment"  required  >
            <center><option>Select employment type</option></center>
             <?php              
            if(!empty($employee)){
            foreach($employment as $employment){
            echo '<option  value="'.$employment->employment_id.'"> '.$employment->employment_name.'</option>';
            }
            }else{
            }
            ?>
            </select>
            </div>
            </div> 
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
            
            </select>
            </div>
            </div>
            <div class="col-md-12">
            <div class="col-md-3">Date Employed</div>
            <div class="col-md-6">        
            <input type="date" name="employed" class="form-control">
            </div>
            </div>
            <div class="col-md-12">
            <div class="col-md-3">Requested By</div>
            <div class="col-md-6">        
            <input  type="text" name="requested" required="" class="form-control">
            </div>
            </div>
            <div class="col-md-12">
            <div class="col-md-3">Reason for COE</div>
            <div class="col-md-6">        
            <input  type="text" name="reason" required="" class="form-control">
            </div>
            </div>
             <div class="col-md-12">
            <div class="col-md-3">Date Issued</div>
            <div class="col-md-6">   
            <input type="date" name="date_issued" class="form-control" value="<?php echo date('Y-m-d');?>" >
          </div>
            </div>
            <div class="col-md-12">
               <div class="col-md-3">Address</div>
            <div class="col-md-6">   
           

            <input type="text" name="address" class="form-control" >
            </div>
            </div>

        
              
            <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6">  
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Generate</button>
            </div>
            </div>
            </form>
       </div> <!-- box body -->

  </div>

                </div><!-- admin rem -->


<div class="tab-pane" id="coesetting">
  <div class="box box-danger">
  <div class="col-md-12">
    <ul class="nav nav-tabs">
     <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i> Electronic Signature</b></n></a></li>
    </ul>
  </div>

    <div class="box-body">
                  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/employee_reports/coe_esig">
                    <div class="col-md-12">
                    <div class="col-md-5">Attach Electronic Signature  on Certificate of Employment?</div>
                    <div class="col-md-7">  

                      <?php
                       $esig=$this->employee_reports_model->getCoeESigSetup();
                       if(!empty($esig)){
                        $show_esignature=$esig->topic_setting;
                       }else{
                        $show_esignature="";
                       }

                      ?>
                      <input type="radio" name="coe_esig" value="checked" <?php echo $show_esignature;?>> YES <br>
                      <input type="radio" name="coe_esig" value="" <?php if($show_esignature==""){ echo "checked";}else{}?>> NO <br>
                    </div>
                    </div>

                    <div class="col-md-12">
                    <div class="col-md-5"></div>
                    <div class="col-md-7">  
                    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> Update</button>
                    </div>
                    </div>

                  </form>
    </div>

  </div>
</div>


 <div class="tab-pane" id="coeset">

    <div class="box box-danger">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i> Setup COE Settings</b></n></a>
              </li>
          </ul>
      </div>
      
       <div class="box-body">

            <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/employee_reports/coe_settings">

          <div class="form-group"  id="show_selected_emp">
          <label for="next" class="col-sm-5 control-label"><a type="button" class="" data-toggle="modal" data-target="#showEmployeeList"></a> &nbsp;&nbsp;COE Signatory</label>
          <div class="col-sm-7" >
          <a data-toggle="modal" data-target="#showEmployeeList" id="ieh"><input type="text" id="ie" class="form-control col-sm-12" placeholder="Click to Select Signatory" >
          </a>
          </div>
          </div> 


            <div class="col-md-12">
            <div class="col-sm-5 control-label">For this Company (Select from the choices)</div>
            <div class="col-md-7">        
  
            <?php              
            if(!empty($companyList)){
            foreach($companyList as $c){
              if($c->company_id=="1"){
                $sel="checked";
              }else{
                $sel="";
              }
              echo '<input type="radio"  name="company_id" value="'.$c->company_id.'" '.$sel.'> '.$c->company_name.'</br>';
            }
            }else{
            }
            ?>
   
            </div>
            </div>
            <div class="col-md-12">
            <div class="col-md-5"></div>
            <div class="col-md-7">  
            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> Update</button>
            </div>
            </div>


          </form>
      </div>
    </div>



    <div class="box box-danger">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i> Current COE Signatory</b></n></a>
              </li>
          </ul>
      </div>
      
       <div class="box-body">
        <?php
       if(!empty($companyList)){
            foreach($companyList as $c){

              $a=$this->employee_reports_model->getSignatory($c->company_id);
              if(!empty($a)){
               echo "Company: ".$c->company_name." | COE Signatory: ".$a->name_lname_first;
              }else{

              }
            }
       }else{

       }
        ?>


       </div>

    </div>





 </div>




              </div>

            </div>



