

  <div class="col-md-12" style="padding-bottom: 50px;" id="action"> 
    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>PAYROLL PERIOD REPORT</b></n></a></li>
          </ul>
      </div>
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
              <div class="col-md-12">
                    

          <div class="box-body">
                      <form class="form-horizontal" method="post" action="<?php echo base_url()?>employee_portal/reports_personnel_attendance/generate_report_result_payroll_period/" target="_blank">
                      
                            <div class="col-md-12">
                                <div class="col-md-3 bg-danger">Report Type<small><i> ( Note: You must create a report fields contents at 'Crystal Report'. Those report types you created will be the choices in this area <i class="fa fa-arrow-right"></i> )</i> </small></div>
                                <div class="col-md-6"> 
                                  <select class="form-control" name="report" id="report" required>
                                      <option value="default">Default Report</option>
                                      <?php foreach($crystal_report as $c)
                                      {
                                        echo "<option value='".$c->id."'>".$c->title."</option>";
                                      }
                                      ?>
                                  </select><br>
                                </div>
                            </div> 


                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Company</div>
                              <div class="col-md-6">
                                <select class="form-control" name="company" id="company" required onclick="pp_get_paytypegroup();">
                                  <option value="" selected disabled>Select Company</option>
                                  <?php
                                    foreach($company_list as $l){?>
                                    <option value="<?php echo $l->company;?>"><?php echo $l->company_name;?></option>
                                   <?php } ?>
                                </select><br>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Pay Type<br> </div>
                              <div class="col-md-6">
                               <select class="form-control" name="paytype" id="paytype" required onclick="pp_get_paytypegroup();">
                                  <option value="" selected disabled>Select Pay Type</option>
                                     <?php foreach($paytypeList as $p){?>
                                      <option value="<?php echo $p->pay_type_id;?>"><?php echo $p->pay_type_name;?></option>
                                     <?php } ?>
                                </select><br>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Group<br></div>
                              <div class="col-md-6">
                                 <select class="form-control" name="paytypegroup" id="paytypegroup" required onclick="pp_get_payroll_period(this.value);" >
                                  <option value="" selected disabled>Select Pay Type Group</option>
                                  
                                </select><br>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Payroll Period<br></div>
                              <div class="col-md-6">
                                  <select class="form-control" name="payrollperiod" id="payrollperiod" required >
                                  <option value="" selected disabled>Select Payroll Period</option>
                                  
                                </select><br>
                              </div>
                            </div>

                           <div class="col-md-12">
                              <div class="col-md-3"></div>
                              <div class="col-md-6"><button class="btn btn-success col-md-12"  target="_blank">GENERATE</button>
                              </div>
                          </div>
                  </form>
            </div>

              </div>      
            <div class="col-md-12" id="main_action" style="margin-top: 30px;"></div>
      </div>
      <div class="panel panel-info"><div class="btn-group-vertical btn-block"> </div></div>             
    </div> 
  </div> 
 