

  <div class="col-md-12" style="padding-bottom: 50px;" id="action"> 
  
      
                    
  <br><br>
          <div class="box-body">
                      <form class="form-horizontal" method="post" action="<?php echo base_url()?>employee_portal/reports_personnel_schedule/generate_report_result_employment/" target="_blank">
                      
                            <div class="col-md-12">
                                <div class="col-md-3 bg-danger">Report Type<small><i> ( Note: You must create a report fields contents at 'Crystal Report'. Those report types you created will be the choices in this area <i class="fa fa-arrow-right"></i> )</i> </small></div>
                                <div class="col-md-6"> 
                                  <select class="form-control" name="report" id="report" required>
                                      <option value="default">Default Report</option>
                                      <?php foreach($crystal_report as $c)
                                      {
                                        echo "<option value='".$c->p_id."'>".$c->report_name."</option>";
                                      }
                                      ?>
                                  </select><br>
                                </div>
                            </div> 

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Company</div>
                              <div class="col-md-6">
                                <select class="form-control" name="company" id="company" required onchange="emp_get_department(this.value);">
                                  <option value="All">All Company</option>
                                  <?php
                                    foreach($company_list as $l){?>
                                    <option value="<?php echo $l->company;?>"><?php echo $l->company_name;?></option>
                                   <?php } ?>
                                </select><br>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Department<br> </div>
                              <div class="col-md-6">
                               <select class="form-control" name="department" id="department" required disabled onchange="emp_get_section(this.value);">
                                  <option value="All" disabled selected>All Department</option>
                                </select><br>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Section<br></div>
                              <div class="col-md-6">
                                 <select class="form-control" name="section" id="section" required disabled >
                                  <option value="All" disabled selected>All Section</option>
                                </select><br>
                              </div>
                            </div>


                             <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Classification<br></div>
                              <div class="col-md-6">
                                 <select class="form-control" name="classification" id="classification" required disabled>
                                    <option value="All" disabled selected>All Classification</option>
                                </select><br>
                              </div>
                            </div>

                             <div class="col-md-12" style="margin-top: 10px;" >
                              <div class="col-md-3">Location<br></div>
                              <div class="col-md-6">
                                 <select class="form-control" name="location" id="location" required disabled>
                                  <option value="All" disabled selected>All Location</option>
                                </select><br>
                              </div>
                            </div>

                             <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Employment<br></div>
                              <div class="col-md-6">
                                 <select class="form-control" name="employment" id="employment" required >
                                  <option value="All">All Employment</option>
                                  <?php foreach($employmentList as $emp)
                                  {?>
                                      <option value="<?php echo $emp->employment_id;?>"><?php echo $emp->employment_name;?></option>
                                  <?php } ?>
                                </select><br>
                              </div>
                            </div>


                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Covered From<br></div>
                              <div class="col-md-6">
                                  <input type="date" name="from" id="from" class="form-control" value="<?php echo date('Y-m').'-01';?>"><br>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Covered To<br></div>
                              <div class="col-md-6">
                                 <input type="date" name="to" id="to" class="form-control" value="<?php echo date('Y-m-d');?>"><br>
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
 