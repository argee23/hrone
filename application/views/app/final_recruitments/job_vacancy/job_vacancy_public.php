<div class="col-md-12"> 
    <div class="col-md-3">
         <div class="box-body">
                  <div id="MassUploading">
                    <div class="well">
                      <div class="MassUploading" style="height: 420px;">
                          
                          <div class="col-md-12">
                              <label>Admin Approval</label>
                              <select class="form-control" id="admin_verified">
                                <option value="" disabled selected>Select Admin Approval Status</option>
                                <option value="All">All</option>
                                <option value="waiting">Waiting for Approval</option>
                                <option value="1">Accepted</option>
                                <option value="decline">Decline</option>
                                <option value="rejected">Rejected</option>
                              </select>
                          </div>

                          <div class="col-md-12" style="margin-top: 10px;">
                              <label>Position</label>
                               <select class="form-control" id="position">
                                <option value="" disabled selected>Select Position</option>
                                <?php foreach($position as $pos){?>
                                   <option value="<?php echo $pos->position_id;?>"><?php echo $pos->position_name;?></option>
                                <?php } ?>
                              </select>
                          </div>
                          
                          <div class="col-md-12" style="margin-top: 10px;">
                              <label>Date Option</label>
                              <select class="form-control" id="date_option">
                                <option value="" disabled selected>Select Date Option</option>
                                <option value="date_approved">Date Posted</option>
                                <option value="date_posted">Date Created</option>
                              </select>
                          </div>

                          <div class="col-md-12"  style="margin-top: 10px;">
                              <label>Date From</label>
                              <input type="date" class="form-control" id="from">
                          </div>

                          <div class="col-md-12"  style="margin-top: 10px;">
                              <label>Date To</label>
                              <input type="date" class="form-control" id="to">
                          </div>

                          <div class="col-md-12" style="margin-top: 20px;">
                              <button class="col-md-12 btn btn-success pull-right btn-sm" onclick="job_filtering_vacancies_public('<?php echo $employer_type;?>','<?php echo $company_id;?>');"><i class="fa fa-arrow-right"></i>Filter</button>
                            <?php 

                              $job_licensee = $this->recruitment_employer_model->check_active_license($company_id);
                              $jleft = $job_licensee[2] - $job_licensee[0];
                              if($jleft==0){ } else {?>
                           
                              <div id='add_new_position' style="margin-top:35px;" <?php if($company_id=='all'){ echo "style='display:none';"; }?>><a  style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/final_recruitments/add_new_position')."/".$company_id."/".$employer_type;?>" class="col-md-12 btn btn-danger pull-right btn-sm"><i class="fa fa-plus"></i>&nbsp;Add Position</a></div>
                            <?php }?>
                          </div>

                      </div>
                    </div>
                  </div>
                </div>
    </div>

    <div class="col-md-9">
      <?php if($jleft==0){ echo "<div class='col-md-12'><n class='text-danger'><i class='fa fa-exclamation'></i> NOTE : You have used up your job license.Please avail package to continue posting!</n></div>"; }?>
         <div class="col-md-12" style="overflow: scroll;margin-top: 20px;" id='filtering_result'>
                      <table class="table table-bordered" id="job_vancany">
                      <thead>
                        <tr class="danger">
                          <th>Job ID</th>
                          <th>Position</th>
                          <th>Status</th>
                          <th>Date Posted</th>
                          <th>Admin Approval</th>
                          <th>Date of Approval</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>
                      <?php foreach($jobs as $j){?>
                      <tr>
                          <td><?php echo $j->job_id;?></td>
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
                          <td><?php if($j->admin_verified==1){ echo "Approved"; } else{  echo $j->admin_verified; }?></td>
                          <td>
                             <?php if(empty($j->date_approved)){ echo "Waiting for approval"; } else{
                                $month=substr($j->date_posted, 5,2);
                                $day=substr($j->date_posted, 8,2);
                                $year=substr($j->date_posted, 0,4);
                                echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year; }
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
    </div>
</div>