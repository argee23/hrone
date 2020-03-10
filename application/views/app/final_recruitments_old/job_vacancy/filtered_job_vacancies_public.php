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