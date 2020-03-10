<div class="box-body">
                  <div id="MassUploading">
                    <div class="well">
                      <div class="MassUploading" style="height: 80px;">

                      <div class="col-md-2"></div>
                      <div class="col-md-12">
                          
                           <div class="col-md-4">
                              <select class="form-control" id="fcompany" onchange="get_department_location_plantilla(this.value);" >
                                <option disabled selected value="">Select Company</option>
                                  <?php foreach($companyList as $comp){?>
                                      <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                  <?php } ?>
                              </select>
                          </div>
                          <div class="col-md-4">
                              <select class="form-control" id="fdepartment">
                                 <option>Select Department</option>
                              </select>
                          </div>

                          <div class="col-md-4" style="margin-top: 5px;">
                              <select class="form-control" id="flocation">
                                <option disabled selected value="">Select Location</option>
                              </select>
                          </div>

                          <div class="col-md-4" style="margin-top: 5px;">
                              <select class="form-control" id="fplantilla">
                                <option disabled selected value="">Select Plantilla</option>
                              </select>
                          </div>

                          <div class="col-md-4" style="margin-top: 5px;">
                            
                              <select class="form-control" id="fposition">
                                  <option disabled selected value="">Select Position</option>
                                  <option value="All">All</option>
                                  <?php foreach($position as $p){?>
                                  <option value="<?php echo $p->position_id;?>"><?php echo $p->position_name;?></option>
                                  <?php } ?>
                              </select>
                          </div>


                          <div class="col-md-4" style="margin-top: 8px;">
                              <button class="col-md-12 btn btn-success pull-right btn-sm" onclick="filter_plantilla_job();"><i class="fa fa-arrow-right"></i>Filter</button>
                          </div>

                      </div>
                      <div class="col-md-2"></div>
                         
                      </div>
                    </div>
                  </div>
                </div>

                <div class="box box-danger" class='col-md-12'></div>

                <div class="col-md-12" style="overflow-y: scroll;margin-top: 20px;" id='filtering_result'>
                 


                </div>
