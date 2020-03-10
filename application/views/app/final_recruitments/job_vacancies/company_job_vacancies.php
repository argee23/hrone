<div class="box-body">
                  <div id="MassUploading">
                    <div class="well">
                      <div class="MassUploading" style="height: 120px;">

                          <div class="col-md-3">
                              <center><label>Company</label></center>
                              <select class="form-control" id="company" disabled>
                                  <?php foreach($companyList as $comp){?>
                                    <option value="<?php echo $comp->company_id;?>" <?php if($comp->company_id==$company_id){ echo "selected"; }?>><?php echo $comp->company_name;?> </option>
                                  <?php } ?>
                              </select>
                          </div>

                          <div class="col-md-3">
                              <center><label>Department</label></center>
                              <select class="form-control" id="department">
                                <option value="" disabled selected>Select Position</option>
                                <option value="All">All</option>
                                <?php foreach($department as $dep){?>
                                   <option value="<?php echo $dep->department_id;?>"><?php echo $dep->dept_name;?></option>
                                <?php } ?>
                              </select>
                          </div>

                          <div class="col-md-3">
                              <center><label>Location</label></center>
                              <select class="form-control" id="location">
                               <option value="" disabled selected>Select Location</option>
                                <option value="All">All</option>
                                  <?php foreach($location as $loc){?>
                                      <option value="<?php echo $loc->location_id;?>"><?php echo $loc->location_name;?></option>
                                  <?php } ?>
                              </select>
                          </div>

                          <div class="col-md-3">
                              <center><label>Plantilla</label></center>
                              <select class="form-control" id="plantilla">
                               <option value="" disabled selected>Select Plantilla</option>
                                <option value="All">All</option>
                                <?php foreach($plantilla as $p){?>
                                      <option value="<?php echo $p->id;?>"><?php echo $p->plantilla_no;?></option>
                                  <?php } ?>
                              </select>
                          </div>

                          <div class="col-md-3">
                              <center><label>Position</label></center>
                              <select class="form-control" id="position">
                               <option value="" disabled selected>Select Position</option>
                                <option value="All">All</option>
                                <option value="" disabled selected>Select Position</option>
                                 <?php foreach($position as $p){?>
                                      <option value="<?php echo $p->position_id;?>"><?php echo $p->position_name;?></option>
                                  <?php } ?>
                              </select>
                          </div>


                      
                          <div class="col-md-2">
                              <center><label>Date Posted From</label></center>
                              <input type="date" class="form-control" id="posted_from">
                          </div>
                          <div class="col-md-2">
                              <center><label>Date Posted To</label></center>
                              <input type="date" class="form-control" id="posted_to">
                          </div>

                           <div class="col-md-2" style="margin-top: 30px">
                              <b>All Dates</b>&nbsp;<input type="checkbox" id="postedall" onclick="datepostedall('postedall','posted_from','posted_to');">
                          </div>

                          <div class="col-md-3" style="margin-top: 20px;">
                              <button class="col-md-5 btn btn-success pull-right btn-sm" style='margin-top: 7px;' onclick="filtering_by_company('<?php echo $employer_type;?>');"><i class="fa fa-arrow-right"></i>Filter</button>
                              <a tyle="cursor: pointer;margin-right:5px;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitment_plantilla/add_new_position')."/".$company_id."/".$employer_type;?>" class="col-md-5 btn btn-danger pull-right btn-sm" style='margin-top: 7px;margin-right: 10px;' ><i class="fa fa-plus"></i>Add</a>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="box box-danger" class='col-md-12'></div>

                <div class="col-md-12" style="overflow: scroll;margin-top: 20px;" id='filtering_result'>
                  <table class="table table-bordered" id="job_vacancy">
                      <thead>
                        <tr class="danger">
                          <th>Company ID</th>
                          <th>Department</th>
                          <th>Location</th>
                          <th>Plantilla</th>
                          <th>Position</th>
                          <th>Job Vacancy</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>
                    <?php foreach ($job_vacancies as $j) {?>
                        <tr>
                          <td><?php echo $j->company_id;?></td>
                          <td><?php echo $j->dept_name;?></td>
                          <td><?php echo $j->location_name;?></td>
                          <td><?php echo $j->plantilla_no;?></td>
                          <td><?php echo $j->job_title;?></td>
                          <td><?php echo $j->job_vacancy;?></td>
                          <td>
                               <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitment_plantilla/view_job_details')."/".$j->company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Job Details'><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                              
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitment_plantilla/edit_job_details')."/".$j->company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to Update Job Details' ><i class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                <?php 
                                  $check_if_used = $this->final_recruitments_model->check_job_applicant($j->job_id); if($check_if_used==0){ ?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="job_details_action('delete','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                <?php } else{}

                              if($j->statuss==1){?>
                              
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left" ' onclick="job_details_action('disable','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php } else{?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable JOb' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left" ' onclick="job_details_action('enable','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php }?>

                              <a style='cursor:pointer;color:orange;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitment_plantilla/get_all_applicants')."/".$j->job_id."/".$employer_type;?>" title='Click to View Applicants' > <i  class="fa fa-check-circle-o fa-lg  pull-left"></i></a>

                              <a style='cursor:pointer;color:red;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitment_plantilla/get_all_not_applied_applicants')."/".$j->job_id."/".$employer_type;?>"  title='Click to View Applicants Applied in other company'  ><i  class="fa fa-times-circle-o fa-lg  pull-left"></i></a>


                          </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                  </table>
                </div>
