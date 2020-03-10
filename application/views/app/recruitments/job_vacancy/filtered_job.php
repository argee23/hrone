<div class="col-md-12" style="padding-top: 30px;">
<?php if($employer_type=='public')
{?>
              <table class="table table-bordered" id="job_vancany">
                      <thead>
                      <?php if($employer_type=='public')
                      {?>
                        <tr class="danger">
                          <th>No</th>
                          <th>Position</th>
                          <th>Status</th>
                          <th>Admin Status</th>
                          <th>Date Created</th>
                          <th>Serttech Comment</th>
                          <th>Date Approved</th>
                          <th>Action</th>
                        </tr>
                      <?php } else{  ?>
                         <tr class="danger">
                          <th>No</th>
                          <th>Position</th>
                          <th>Status</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      <?php } ?>
                      </thead>
                      <tbody>
                          <?php $i=1; foreach($jobs as $j) { if($employer_type=='public')
                          {?>
                          <tr>
                              <td><?php echo $i;?></td>
                              <td>   <?php echo $j->job_title;?></td> 
                              <td><?php  if($j->admin_verified==1){  if($j->status==1) { echo "Open"; } else{ echo "Close"; } } else{ echo "closed (not yet approved by serttech)"; };?></td>
                              <td><?php if($j->admin_verified==1){ echo "approved"; } else{ echo $j->admin_verified; } ?></td>
                              <td><?php echo $j->date_posted;?></td>
                               <td><?php if(!empty($j->comment)){ echo $j->comment;} else{ echo "no comment"; }?></td>
                              <td><?php if($j->admin_verified!=1){ echo "not yet approved by serttech"; } else{ echo $j->date_approved; }?></td>
                              <td>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/view_job_details')."/".$company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                               
                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/edit_job_details')."/".$company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to Update Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                <?php 
                                  $check_if_used = $this->recruitments_model->check_job_applicant($j->job_id);
                                  if($check_if_used==0){
                                ?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="job_details_action('delete','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                <?php } else{}?>
                                <?php if($j->admin_verified==1){ if($j->status==1){?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left" ' onclick="job_details_action('disable','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php } else{?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable JOb' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left" ' onclick="job_details_action('enable','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php }} else{ }?>
                                <a style='cursor:pointer;color:orange;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitments/get_all_applicants')."/".$j->job_id."/".$employer_type;?>" title='Click to View Applicants' >
                                 <i  class="fa fa-check-circle-o fa-lg  pull-left"></i></a>

                                 <a style='cursor:pointer;color:red;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitments/get_all_not_applied_applicants')."/".$j->job_id."/".$employer_type;?>"  title='Click to View Applicants Applied in other company'  >
                                   <i  class="fa fa-times-circle-o fa-lg  pull-left"></i></a>


                              </td>
                          </tr>
                          <?php }
                          else
                          {?>
                             <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                          </tr>
                          <?php } $i++; }?>
                      </tbody>
                  </table>
  <?php } else{?>
          <div class="col-md-12" style="padding-bottom: 10px;">
              <a  style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/add_new_position')."/".$company_id."/".$employer_type;?>" class="btn btn-danger btn-xs pull-right"  >Add Position</a>
          </div>
          <table class="table table-bordered" id="job_vancany">
                      <thead>
                         <tr class="danger">
                          <th>No</th>
                          <th>Position</th>
                          <th>Status</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                    
                      </thead>
                      <tbody>
                          <?php $i=1; foreach($jobs as $j) { ?>
                             <tr>
                              <td><?php echo $i;?></td>
                              <td><?php echo $j->job_title;?></td>
                              <td><?php if($j->status==1) { echo "Open"; } else{ echo "Close"; } ?></td>
                              <td><?php echo $j->date_posted;?></td>
                              <td>
                                  
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/view_job_details')."/".$j->company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>
                               
                                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/edit_job_details')."/".$j->company_id."/".$employer_type."/".$j->job_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to Update Job Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                                <?php 
                                  $check_if_used = $this->recruitments_model->check_job_applicant($j->job_id);
                                  if($check_if_used==0){
                                ?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="job_details_action('delete','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                                <?php } else{}
                                if($j->status==1){?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Job' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left" ' onclick="job_details_action('disable','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php } else{?>
                                <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable JOb' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left" ' onclick="job_details_action('enable','<?php echo $j->company_id;?>','<?php echo $employer_type;?>','<?php echo $j->job_id;?>');"></i></a>
                                <?php }?>

                                  <a style='cursor:pointer;color:orange;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitments/get_all_applicants')."/".$j->job_id."/".$employer_type;?>" title='Click to View Applicants' >
                                 <i  class="fa fa-check-circle-o fa-lg  pull-left"></i></a>

                                 <a style='cursor:pointer;color:red;'  data-toggle='modal' data-target='#modal' aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Applied in other company'  href="<?php echo base_url('app/recruitments/get_all_not_applied_applicants')."/".$j->job_id."/".$employer_type;?>"  title='Click to View Applicants Applied in other company'  >
                                   <i  class="fa fa-times-circle-o fa-lg  pull-left"></i></a>



                              </td>



                          </tr>
                          <?php  $i++; }?>
                      </tbody>
                  </table>
  <?php } ?>

</div>