 <div class="col-md-12" style="margin-top: 20px;">
          <h4 style="font-family: serif;"><center>Applicant Job Application/s</center></h4>
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
                              <h5 class="widget-user-username"><?php echo $j->company_name;?></h5>
                              <h5 class="widget-user-desc"><?php echo $j->position_name;?></h5>
                            </div>
                            <div class="box-footer no-padding">
                              <ul class="nav nav-stacked hover">
                                <li><a href="#">Date Applied <span class="pull-right"><?php echo $j->date_applied;?></span></a></li>
                                <li>
                                <?php if($j->ApplicationStatus==2 || $j->ApplicationStatus==3 || $j->ApplicationStatus==4){?>
                                  <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status_updates')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$j->ApplicationStatus;?>" >Status <span class="pull-right"><n style="color:<?php echo $j->color_code;?>"><?php echo $j->status_title;?></n></span></a>
                                <?php } 
                                else if($j->ApplicationStatus==1)
                                {
                                    $get_active_interview = $this->application_forms_model->get_applicant_active_interview($j->id);
                                    if(empty($get_active_interview)){}
                                    else
                                    {
                                      $get_active_interview = $this->application_forms_model->get_applicant_active_interview_details($j->id,$get_active_interview);
                                      if(!empty($get_active_interview->response))
                                      {
                                          if($get_active_interview->response=='Accept' || $get_active_interview->response=='Decline')
                                          {?>

                                            <a style="cursor: pointer;" data-toggle='modal' data-target='#modal'  href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" >Status <span class="pull-right label bg-olive">View <?php echo $get_active_interview->response;?> Interview Details</span></a>

                                          <?php }
                                          else
                                          {
                                            if($get_active_interview->company_response=='Accept' || $get_active_interview->company_response=='Decline')
                                            {?>
                                               <a style="cursor: pointer;" data-toggle='modal' data-target='#modal'  href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" >Status <span class="pull-right label bg-olive">View <?php echo $get_active_interview->response;?> Interview Details</span></a>
                                            <?php }
                                            else if($get_active_interview->company_response=='Reschedule')
                                            {
                                                if(empty($get_active_interview->company_resched_applicant_response)){
                                            ?>
                                               <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" class="blink" id="blink"><b>Status <span class="pull-right"><n  style="color:<?php echo $j->color_code;?>">Respond to company invitation</n></span></b></a>
                                            <?php } else{ ?>
                                              <a style="cursor: pointer;" data-toggle='modal' data-target='#modal'  href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" >Status <span class="pull-right label bg-olive">View <?php echo $get_active_interview->response;?> Interview Details</span></a>
                                            <?php }}
                                            else
                                            {
                                          ?>

                                            <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" class="blink" id="blink"><b>Status <span class="pull-right"><n  style="color:<?php echo $j->color_code;?>">Waiting for company response</n></span></b></a>
                                          


                                          <?php } }
                                      } 
                                      else
                                      {?>

                                        <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" class="blink" id="blink"><b>Status <span class="pull-right"><n  class='text-info'>Respond to <?php echo $get_active_interview->title;?> Invitation</n></span></b></a>
                                      
                                      <?php }

                                    }
                                }
                                else{?>
                                <a style="cursor: pointer;" >Status <span class="pull-right"><n style="color:<?php echo $j->color_code;?>">Application Today</n></span></a>
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
                                  $checker_with_referral = $this->application_forms_model->checker_with_referral_applicant($j->id,$j->employee_info_id,$j->job_id);
                                  ?>
                                     <li><a  style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/referral_points_applicant')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>" <?php if($checker_with_referral == 0){ ?> class="blink" id="blink" <?php } ?> >

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