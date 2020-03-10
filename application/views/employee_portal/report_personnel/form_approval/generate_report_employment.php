
          <div class="box-body">
                      <form class="form-horizontal" method="post" action="<?php echo base_url()?>employee_portal/reports_personnel_form_approval/generate_report_employment_result/" target="_blank">
                            <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
                            <input type="hidden" name="identification" id="identification" value="<?php echo $identification;?>">
                            <div class="col-md-12">
                                <div class="col-md-3 bg-danger">Report Type<small><i> ( Note: You must create a report fields contents at 'Crystal Report'. Those report types you created will be the choices in this area <i class="fa fa-arrow-right"></i> )</i> </small></div>
                                <div class="col-md-6"> 
                                  <select class="form-control" name="report" id="report" required>
                                    <option value="default">Default Crystal Report</option>
                                    <?php foreach($crystal_report as $c){?>
                                       <option value="<?php echo $c->id;?>"><?php echo $c->title;?></option>
                                    <?php } ?>
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
                              <div class="col-md-3">Date From<br> <i>(based on date filed)</i></div>
                              <div class="col-md-6">
                               <input type="date" class="form-control" name="date_from" id="date_from" value="<?php echo date('Y-m-d');?>" required><br>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Date To <br><i>(based on date filed)</i></div>
                              <div class="col-md-6">
                                 <input type="date" class="form-control" name="date_to" id="date_to" value="<?php echo date('Y-m-d');?>" required><br>
                              </div>
                            </div>

                        
                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Status</div>
                              <div class="col-md-6">
                                 <select class="form-control" name="status" id="status" required>
                                   <option value="All">All</option>
                                   <option value="approved">Approved</option>
                                   <option value="cancelled">Cancelled</option>
                                   <option value="rejected">Rejected</option>
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