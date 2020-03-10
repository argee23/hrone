

  <div class="col-md-12" style="padding-bottom: 50px;" id="action"> 
   
                    <br><br>
                      <form class="form-horizontal" method="post" action="<?php echo base_url()?>employee_portal/reports_personnel_schedule/generate_report_result_date_range/" target="_blank">
                      
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
                                <select class="form-control" name="company" id="company" required >
                                   <?php if(count($company_list) > 1){ echo "<option value='All'>All</option>"; }
                                    foreach($company_list as $l){?>
                                    <option value="<?php echo $l->company;?>"><?php echo $l->company_name;?></option>
                                   <?php } ?>
                                </select><br>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Covered Date From<br> </div>
                              <div class="col-md-6">
                               <input type="date" class="form-control" name="date_from" id="date_from" value="<?php echo date('Y-m').'-01';?>" required><br>
                              </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
                              <div class="col-md-3">Covered Date To <br></div>
                              <div class="col-md-6">
                                 <input type="date" class="form-control" name="date_to" id="date_to" value="<?php echo date('Y-m-d');?>" required><br>
                              </div>
                            </div>


                           <div class="col-md-12">
                              <div class="col-md-3"></div>
                              <div class="col-md-6"><button class="btn btn-success col-md-12"  target="_blank">GENERATE</button>
                              </div>
                          </div>
                  </form>
           
              </div>      
            <div class="col-md-12" id="main_action" style="margin-top: 30px;"></div>
      </div>
      <div class="panel panel-info"><div class="btn-group-vertical btn-block"> </div></div>             
    </div> 
  
 