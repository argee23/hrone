
         <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#genalpha" data-toggle="tab"><i class="fa fa-file text-danger"></i> Generate Alphalist</a></li>
                      <li><a href="#prev_emp_set" data-toggle="tab"><i class="fa fa-key text-danger"></i> Previous Employer Settings</a></li>
                      <li><a href="#alphalist_2316" data-toggle="tab"><i class="fa fa-key text-danger"></i> Generate 2316</a></li>
             
                    </ul>

              <div class="tab-content">

                <!-- ADMIN REMINDERS -->
                <div class="active tab-pane" id="genalpha">

    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i> Generate Alphalist</b></n></a>
              </li>
          </ul>
      </div>
      
       <div class="box-body">
 <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/reports_payroll/generated_alphalist" target="_blank" >      
      <div class="form-group">
        <label for="bank_code" class="col-sm-2 control-label">Covered Year</label>
        <div class="col-sm-10">
              <select class="form-control" name="covered_year" id="covered_year" required  >
                <?php
                if(!empty($year_choicesList)){
                  foreach($year_choicesList as $year){
                    echo '<option value="'.$year->yy.'">'.$year->yy.'</option>';
                  }
                }else{

                }
                ?>
              </select>
        </div>
      </div>
      <div class="form-group">
        <label for="bank_code" class="col-sm-2 control-label">Company</label>
        <div class="col-sm-10">
              <select class="form-control" name="company_id" id="company_id" required  >
               
          <?php              
                  if(!empty($companyList)){
                    foreach($companyList as $c){
                      echo '<option  value="'.$c->company_id.'"> '.$c->company_name.'</option>';
                    }
                  }else{
                  }
          ?>
               <option  value="All"> All</option>
              </select>
        </div>
      </div>     
    
  <div class="form-group">
  <label for="bank_code" class="col-sm-2 control-label">Schedule</label>
    <div class="col-sm-10">    
      <select class="form-control" name="alphalist_type" id="alphalist_type" required  >
        <option value="7_1">7.1 : Alphalist of employees terminated before December 31</option>
        <option value="7_2">7.2 : Alphalist of employees compensation income are are excempt from witholding tax but subject to income tax</option>
        <option value="7_3">7.3 : Alphalist of employees as of December 31 with no previous employers within the yea</option>
        <option value="7_4">7.4 : Alphalist of employees as of December 31 with previous employer within the year</option>
        <option value="7_5">7.5 : Alphalist of employees of minimum wage earners</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="bank_code" class="col-sm-2 control-label">Report Result Type</label>
    <div class="col-sm-10">      
            <input type="radio" name="report_result_type" value="excel"> Excel 
            <input type="radio" name="report_result_type" value="browser_view" checked> Browser View 
    </div>
  </div>

  <div class="form-group">
    <label for="bank_code" class="col-sm-2 control-label">Action</label>
    <div class="col-sm-10">      
      <select class="form-control" name="generate_action" id="generate_action" required  >
      <option value="view">View</option>
      <option value="post">Post</option>
      <option value="reset">Reset</option>
      </select>
    </div>
  </div>

    <button type="submit"  class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Generate</button>

</form>           
       </div> <!-- box body -->

  </div>

                </div><!-- admin rem -->

 <div class="tab-pane" id="prev_emp_set">

              <div class="box box-danger">
                <div class="box-body" id="filter_employee">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i> Setup Previous Employer</b></n></a>
                        </li>
                    </ul>
                </div>
                
             
                    <div class="form-group">
                      <label for="" class="col-sm-2 control-label">&nbsp;</label>
                      <label for="" class="col-sm-10 control-label">Filter Employees</label>
                    </div>
                
                    <div class="form-group">
                      <label for="bank_code" class="col-sm-2 control-label">Company</label>
                      <div class="col-sm-10">
                            <select class="form-control" name="company" id="company" required  >                             
                        <?php              
                                if(!empty($companyList)){
                                  foreach($companyList as $c){
                                    echo '<option  value="'.$c->company_id.'"> '.$c->company_name.'</option>';
                                  }
                                }else{
                                }
                        ?>
                             <option  value="All"> All</option>
                            </select>
                      </div>
                    </div>    
                    <div class="form-group">
                      <label for="bank_code" class="col-sm-2 control-label">Covered Year</label>
                      <div class="col-sm-10">
                            <select class="form-control" name="year" id="year" required  >
                              <?php
                              if(!empty($year_choicesList)){
                                foreach($year_choicesList as $year){
                                  echo '<option value="'.$year->yy.'">'.$year->yy.'</option>';
                                }
                              }else{

                              }
                              ?>
                            </select>
                      </div>
                    </div>  
                    <div class="form-group">
                      <label for="" class="col-sm-2 control-label">&nbsp;</label>
                      <label for="" class="col-sm-10 control-label">Note: System will show employees who's Date Hired/Employed is Within The Year Selected on the Field "Covered Year".</label>
                    </div>                  
                     <button type="submit" onclick="prev_employer_filter_employees();" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Filter</button>


                </div><!-- end of body -->
              </div>

 </div>


 <div class="tab-pane" id="alphalist_2316">
    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i> Generate 2316</b></n></a>
              </li>
          </ul>
      </div>
      
       <div class="box-body">
 <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/reports_payroll/generate_2316" target="_blank" >      
      <div class="form-group">
        <label for="bank_code" class="col-sm-2 control-label">Covered Year</label>
        <div class="col-sm-10">
              <select class="form-control" name="covered_year" id="covered_year" required  >
                <?php
                if(!empty($year_choicesList)){
                  foreach($year_choicesList as $year){
                    echo '<option value="'.$year->yy.'">'.$year->yy.'</option>';
                  }
                }else{

                }
                ?>
              </select>
        </div>
      </div>
      <div class="form-group">
        <label for="bank_code" class="col-sm-2 control-label">Company</label>
        <div class="col-sm-10">
              <select class="form-control" name="company_id" id="company_id" required  >
               
          <?php              
                  if(!empty($companyList)){
                    foreach($companyList as $c){
                      echo '<option  value="'.$c->company_id.'"> '.$c->company_name.'</option>';
                    }
                  }else{
                  }
          ?>
               <option  value="All"> All</option>
              </select>
        </div>
      </div>     
    
  <div class="form-group">
  <label for="bank_code" class="col-sm-2 control-label">Schedule</label>
    <div class="col-sm-10">    
      <select class="form-control" name="alphalist_type" id="alphalist_type" required  >
        <option value="7_1">7.1 : Alphalist of employees terminated before December 31</option>
        <option value="7_2">7.2 : Alphalist of employees compensation income are are excempt from witholding tax but subject to income tax</option>
        <option value="7_3">7.3 : Alphalist of employees as of December 31 with no previous employers within the yea</option>
        <option value="7_4">7.4 : Alphalist of employees as of December 31 with previous employer within the year</option>
        <option value="7_5">7.5 : Alphalist of employees of minimum wage earners</option>
      </select>
    </div>
  </div>


    <button type="submit"  class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Generate</button>

</form>           
       </div> <!-- box body -->

  </div>






 </div> <!-- end of 2316 alphalist-->



              </div>

            </div>































