<div class="box-body">
                  <div id="MassUploading">
                    <div class="well">
                      <div class="MassUploading" style="height: 100px;">

                          <div class="col-md-3">
                              <center><label>Company</label></center>
                              <select class="form-control" id="company" <?php if($company_id!='all'){ echo "disabled"; }?>>
                                <option value="" selected disabled>Select Company</option>
                                <?php foreach($companyList as $company){?>
                                  <option value="<?php echo $company->company_id;?>" <?php if($company_id==$company->company_id){ echo "selected"; }?>><?php echo $company->company_name;?></option>
                                <?php } ?>
                              </select>
                          </div>
                          <div class="col-md-3">
                              <center><label>Position</label></center>
                              <select class="form-control" id="position">
                                <option value="" disabled selected>Select Position</option>
                                <?php foreach($position as $pos){?>
                                   <option value="<?php echo $pos->position_id;?>"><?php echo $pos->position_name;?></option>
                                <?php } ?>
                              </select>
                          </div>
                          <div class="col-md-3">
                              <center><label>Date Posted From</label></center>
                              <input type="date" class="form-control" id="from">
                          </div>
                          <div class="col-md-3">
                              <center><label>Date Posted To</label></center>
                              <input type="date" class="form-control" id="to">
                          </div>

                          <div class="col-md-12" style="margin-top: 20px;">
                              <button class="btn btn-success pull-right btn-sm" onclick="job_filtering_vacancies('<?php echo $employer_type;?>');"><i class="fa fa-arrow-right"></i>Filter</button>
                              <div  id='add_new_position' <?php if($company_id=='all'){ echo "style='display:none';"; }?>><a  style="cursor: pointer;margin-right:5px;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/final_recruitments/add_new_position')."/".$company_id."/".$employer_type;?>" class="btn btn-danger pull-right btn-sm"><i class="fa fa-plus"></i>&nbsp;Add Position</a></div>
                          </div>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12" style="overflow: scroll;margin-top: 20px;" id='filtering_result'>
                  <table class="table table-bordered" id="job_vancany">
                      <thead>
                        <tr class="danger">
                          <th>Job ID</th>
                          <th>Company Name</th>
                          <th>Position</th>
                          <th>Status</th>
                          <th>Date Posted</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>
                      <?php foreach($jobs as $j){?>
                      <tr>
                          <td><?php echo $j->job_id;?></td>
                          <td><?php echo $j->company_name;?></td>
                          <td><?php echo $j->job_title;?></td>
                          <td><?php if($j->status==1){ echo "open"; } else{ echo "close"; };?></td>
                          <td>
                              <?php 
                                $month=substr($j->date_posted, 5,2);
                                $day=substr($j->date_posted, 8,2);
                                $year=substr($j->date_posted, 0,4);
                                echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                              ?>
                          </td>
                          <td>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/final_recruitments/view_job_details')."/".$j->company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/final_recruitments/edit_job_details')."/".$j->company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to Update Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                <?php 
                                  $check_if_used = $this->final_recruitments_model->check_job_applicant($j->job_id); if($check_if_used==0){ ?>
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="job_details_action('delete','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                <?php } else{}
                                if($j->status==1){?>
                              
                              <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left" ' onclick="job_details_action('disable','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php } else{?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable JOb' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left" ' onclick="job_details_action('enable','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php }?>

                              <a style='cursor:pointer;color:orange;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/final_recruitments/get_all_applicants')."/".$j->job_id."/".$employer_type;?>" title='Click to View Applicants' > <i  class="fa fa-check-circle-o fa-lg  pull-left"></i></a>

                              <a style='cursor:pointer;color:red;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/final_recruitments/get_all_not_applied_applicants')."/".$j->job_id."/".$employer_type;?>"  title='Click to View Applicants Applied in other company'  ><i  class="fa fa-times-circle-o fa-lg  pull-left"></i></a>

                          </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
