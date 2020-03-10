
     
      <div class="col-md-12" id="all_action">
            <div class="col-md-12" id="crystal_report_action" style="margin-top: 30px;">
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/reports_working_schedule/excel_employment_details_report" target="_blank">
                <div class="col-md-1"></div>
                <div class="col-md-10">

                    <div class="col-md-6">
                          <div class="col-md-12"  style="margin-top: 5px;">
                            <select class="form-control" name="calendar_company" id="calendar_company" onchange="get_calendar_department(this.value);">
                              <option value="All">All</option>
                            	<?php if(count($company) == 1){ foreach($company as $c){?>
                            		<option value="<?php echo $c->company_id; ?>"><?php echo $c->company_name;?></option>
                            	<?php } } else{?> <option value="All">All Companies</option> <?php foreach($company as $c){?>
                                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                                <?php }  } ?>
                            </select>
                          </div>
                          <div class="col-md-12" style="margin-top: 5px;">
                          <select class="form-control" name="calendar_section" id="calendar_section" required>
                              <option value="All" selected disabled>All Section</option>
                          </select>
                        </div>
                        <div class="col-md-12" style="margin-top: 5px;">
	                          <select class="form-control" name="employment" id="employment" required>
	                              <option value="All">All Employment</option>
	                              <?php foreach($employmentList as $e){?>
	                                <option value="<?php echo $e->employment_id;?>"><?php echo $e->employment_name;?></option>
	                              <?php } ?>
	                          </select>
	                    </div>
                    </div>
                    
                    <div class="col-md-6">
                        
                        	<div class="col-md-12" style="margin-top: 5px;">
                              <select class="form-control" name="calendar_department" id="calendar_department" onchange="get_calendar_section(this.value);" required>
		                              <option value="All" selected>All Department</option>
                              </select>
	                        </div>
	                        <div class="col-md-12" style="margin-top: 5px;">
	                          <select class="form-control" name="classification" id="classification" required>
	                                <option value="All">All Locations</option>
	                                <?php foreach ($classificationList as $l) {?>
	                                      <option value="<?php echo $l->classification_id;?>"><?php echo $l->classification;?></option>
	                                  <?php } ?>
	                          </select>
	                        </div>
                    </div>

                   
                    <div class="col-md-6">
	                        <div class="col-md-12" style="margin-top: 5px;">
	                           <select class="form-control" name="location" id="location" required>
	                                <option value="All">All Locations</option>
	                                <?php foreach ($locationList as $l) {?>
	                                      <option value="<?php echo $l->location_id;?>"><?php echo $l->location_name;?></option>
	                                  <?php } ?>
	                          </select>
	                        </div>
	                        
                    </div>

                   


                  
                    <div class="col-md-12">
                      <div class="col-md-12" style="margin-top: 20px;">
                          <button class="col-md-12 btn btn-success" type="submit">FILTER</button> 
                        </div>
                      </div>
                </div>
                <div class="col-md-1"></div>
            </form>


            </div>
      </div>
   

   