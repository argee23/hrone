
          <div class="col-md-12" style="margin-top: 20px;">
                      
          <div class="col-md-12">
          <n class='text-info'><i>Showing <?php echo count($jobs);?> Entries. . </i></n>
          </div>
          <div class="col-md-12 well well-sm bg-darken-3" style="padding-top: 20px;">
         <?php foreach($jobs as $j)
          {

            $resume = $this->application_forms_model->check_resume_status($j->job_id,$j->employee_info_id);
            $requirements =  '';
            $questions =  '';
                 ?>
          <!-- APPLICATIONS VIEW -->
                    <div class="col-md-6">
                      <div class="box box-widget widget-user-2 item" >
                            <div class="well well-sm bg-aqua" style="height:100px;">
                              <div class="widget-user-image">
                              <?php if(empty($j->logo)){?>
                                <img class="img-circle" src="<?php echo base_url() . 'public/company_logo/' ?>default_logo" alt="company">
                              <?php } else{?>
                                 <img class="img-circle" src="<?php echo base_url() . 'public/company_logo/' ?><?php echo $j->logo;?>" alt="company">
                              <?php } ?>
                              </div>
                              <h3 class="widget-user-username"><?php echo $j->company_name;?></h3>
                              <h5 class="widget-user-desc"></h5>
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked hover">
                                <li><a href="#">Date Applied <span class="pull-right"><?php echo $j->date_applied;?></span></a></li>
                                <li>
                                <?php if($j->ApplicationStatus==2 || $j->ApplicationStatus==3 || $j->ApplicationStatus==4){?>
                                  <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>" >Status <span class="pull-right"><n style="color:<?php echo $j->color_code;?>"><?php echo $j->status_title;?></n></span></a>
                                <?php } else if($j->ApplicationStatus==1)
                                {
                                  $check_respond = $this->application_forms_model->check_invitation_response($j->id);
                                  if(empty($check_respond)){
                                ?>


                                        <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>" class="blink" id="blink"><b>Status <span class="pull-right"><n  class='text-info'>Respond to Interview Invitation</n></span></b></a>


                                      <?php } else{ 
                                        if(!empty($check_respond->response) AND $check_respond->response=='accept'){

                                      ?>

                                        <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Status <span class="pull-right label bg-olive">View Accepted Interview Details</span></a>


                                <?php } else if(!empty($check_respond->response) AND $check_respond->response=='decline'){ ?>

                                       <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Status <span class="pull-right label bg-gray">View Declined Interview Details</span></a>

                                <?php } else{ 
                                  if(empty($check_respond->company_response)){

                                ?>


                                        <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>" class="blink" id="blink"><b>Status <span class="pull-right"><n  style="color:<?php echo $j->color_code;?>">Waiting for company response</n></span></b></a>

                                <?php } else if(!empty($check_respond->company_response) AND $check_respond->company_response=='decline'){ ?>

                                        <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Status <span class="pull-right label bg-gray">Requested Interview Schedule is decline by the employer</span></a>

                                <?php } elseif(!empty($check_respond->company_response) AND $check_respond->company_response=='approved'){?>

                                      <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Status <span class="pull-right label bg-olive">View Rescheduled Interview Invitation</span></a>

                                <?php   } 
                                else {
                                  if(empty($check_respond->company_resched_applicant_response)){
                                ?>

                                        <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>" class="blink" id="blink"><b>Status <span class="pull-right"><n  style="color:<?php echo $j->color_code;?>">Respond to Rescheduled Interview Invitation</n></span></b></a>

                                <?php } else{
                                      if($check_respond->company_resched_applicant_response=='accept')
                                        {?>

                                       <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Status <span class="pull-right label bg-olive">View Rescheduled Interview Invitation</span></a>

                                <?php } else{ ?>


                                   <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Status <span class="pull-right label bg-gray">View Declined Interview Invitation</span></a>


                                <?php 
                                } } }}  }  }
                                else{?>
                                <a style="cursor: pointer;" >Status <span class="pull-right"><n style="color:<?php echo $j->color_code;?>"><?php echo $j->status_title;?></n></span></a>
                                <?php }?>
                                </li>

                                <li>
                                    <a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/manage_questions')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Employer Questions <span class="pull-right label bg-olive">Answer</span></a>
                                </li>

                                <li>
                                <?php $check_req  = $this->application_forms_model->check_pending_requirements_uploaded($j->job_id); 
                                  if($check_req==1){?>
                                    <a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/manage_requirements')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Requirements <span class="pull-right label bg-olive">View Uploaded Requirements</span></a>
                                <?php }
                                  else{
                                ?>
                                   <a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/manage_requirements')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>" class="blink" id="blink">Requirements <span class="pull-right text-info"><b>Pending required requirements</b>
                                   </span></a>
                                <?php } ?>
                                </li>

                                <li><a href="#">Resume Status <span class="pull-right label bg-olive"><?php if($resume==0){ echo "Not yet Viewed"; } else{ echo "Viewed"; }?></span></a></li>
                                
                                <li><a  style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/view_other_applicants')."/".$j->employee_info_id."/".$j->job_id;?>" >View Other Applicants<span class="pull-right label bg-olive">View</span></a></li>

                                <?php foreach($point_rewards_settings as $p){

                                  $checker_with_referral = $this->application_forms_model->checker_with_referral($j->id,$j->employee_info_id,$j->job_id);

                                  ?>
                                <li><a  style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/referral_points')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>" <?php if($checker_with_referral == 0){ ?> class="blink" id="blink" <?php } ?> >

                                <?php if($checker_with_referral == 0){ echo "<b>".$p->title." <span class='pull-right'><n class='text-info'> Assign Employee Referral</n></span></b>"; } else { echo $p->title; ?> <span class="pull-right label bg-olive">View Assigned Referral</span> <?php }?>



                                </a></li>
                                <?php } ?>
                              </ul>
                            </div>
                          </div>
                    </div>
                    <!-- END APPLICATIONS VIEW -->
                       <?php }?>
                    </div>
                       </div>
                      