<div class="col-md-12"> 
    <div class="col-md-3">
         <div class="box-body">
                  <div id="MassUploading">
                    <div class="well">
                      <div class="MassUploading" style="height: 300px;">
                          
                         
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
                                <option value="date_posted">Date Posted</option>
                                <option value="0">Date Created</option>
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
                              <button class="col-md-12 btn btn-success pull-right btn-sm" onclick="job_filtering_application_public('<?php echo $employer_type;?>','<?php echo $company_id;?>');"><i class="fa fa-arrow-right"></i>Filter</button>
                            
                          </div>

                      </div>
                    </div>
                  </div>
                </div>
    </div>

    <div class="col-md-9">
         <div class="col-md-12" style="overflow: scroll;margin-top: 20px;" id='filtering_result'>
                        <table class="table table-bordered" id="job_application">
                      <thead>
                        <tr class="danger">
                          
                          <th>Applicant Name</th>
                          <th>Job Title</th>
                          <th>Date Applied</th>
                          <th>Status</th>
                          <th>Action</th>
                          <th></th>

                        </tr>
                      </thead>
                    <tbody>
                    <?php $i=1; foreach($application as $app){?>
                        <tr>
                          <td>
                              <?php echo '<a href="'.base_url().'app/recruitments/applicant_profile/'.$app->employee_info_id.'/'.$app->applicant_id.'/'.$app->job_id."/".$company_id."/".$employer_type.'" style="color:'.$app->color_code.'" target="_blank" data-toggle="tooltip"  title="Click to view resume of '.$app->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger  "></i> &nbsp;&nbsp;'.$app->fullname.'</a>';?>
                          </td>
                          <td><?php echo $app->job_title;?></td>
                          <td><?php echo $app->date_applied;?></td>
                          <td>
                                <?php 
                                
                                    if(empty($app->ApplicationStatus)){ echo "Application today"; }

                                    else if($app->ApplicationStatus==1)
                                    {

                                      $check_respond = $this->application_forms_model->check_invitation_response($app->idd);
                                      if(empty($check_respond->response))
                                      {
                                        echo $check_respond->title.": <n class='text-danger blink_text'>Waiting for Applicant Response </n>"; 
                                      }
                                      else
                                      {
                                        if($check_respond->response=='Decline')
                                        {
                                            echo $check_respond->title.": <n class='text-danger'>Declined by the applicant </n>";
                                        } 
                                        else if($check_respond->response=='Accept')
                                        {
                                          echo $check_respond->title.": <n class='text-danger'>Accepted by the applicant </n>";
                                        } 
                                        else
                                        {
                                            if(empty($check_respond->company_response))
                                            {
                                               echo $check_respond->title.": <n class='text-danger blink_text'>Requesting for Reschedule Interview </n>"; 
                                            }
                                            else 
                                            {
                                              if($check_respond->company_response=='Accept')
                                              {
                                                 echo $check_respond->title.": <n class='text-danger'>Accepted by the applicant </n>"; 
                                              }
                                              else if($check_respond->company_response=='Decline')
                                              {
                                                 echo $check_respond->title.": <n class='text-danger '>Applicant Rescheduled Interview <br> Request  is Declined by the employer</n>"; 
                                              }
                                              else
                                              {
                                                  if(empty($check_respond->company_resched_applicant_response))
                                                  {
                                                      echo $check_respond->title.": <n class='text-danger blink_text'>Waiting for Applicant Respond</n>"; 
                                                  }
                                                  else
                                                  {
                                                    if($check_respond->company_resched_applicant_response=='Decline')
                                                    {
                                                        echo $check_respond->title.": <n class='text-danger'>Declined by the applicant</n>";
                                                    } 
                                                    else 
                                                    {
                                                      echo $check_respond->title.": <n class='text-danger'>Accepted by the applicant</n>";
                                                    } 
                                                  }
                                              }

                                            }
                                        }
                                      }
                                      
                                    }

                                    else{ echo $app->status_title; } ?>
                          </td>
                          <td>
                               <a>
                              <?php if($app->ApplicationStatus==3){
                                if($employer_type=='public'){}
                                else { echo "Hired";
                              ?>

                             
                               <a style="cursor: pointer;" href="<?php echo base_url(); ?>app/employee/employee_profile/<?php echo $app->hired_employee; ?>" target="_blank" class="btn btn-sm" >View Employee Details</a>


                              <?php } } else{
                                if($app->ApplicationStatus==4){ ?>

                                   <a style="cursor:pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/recruitments/update_application_status_blocked')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status."/".$app->comp_id."/".$app->applicant_id;?>" >View Blocked Details</a>

                                <?php }
                                else
                                {
                              ?>
                            
                               <button data-toggle="collapse" data-target='#<?php echo $i;?>' class="btn btn-sm" >change application status</button>
                               <div id="<?php echo $i;?>" class="collapse">
                                <?php 
                                $status_ = $this->recruitments_model->get_company_applicaton_status($app->comp_id);
                                foreach($status_ as $stat_opts){?>
                                <?php if($stat_opts->id==1)
                                {?>
                                    <a style="cursor:pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/update_application_status')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status."/".$app->comp_id."/".$app->applicant_id;?>" ><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>

                                <?php }
                                else if($stat_opts->id==4)
                                {?>

                                     <a style="cursor:pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/recruitments/update_application_status_blocked')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status."/".$app->comp_id."/".$app->applicant_id;?>" ><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>


                                <?php }
                                else if($stat_opts->id==3)
                                {?>
                                  <a style="cursor:pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/update_status_hired')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status."/".$app->comp_id."/".$app->employee_info_id."/".$app->applicant_id;?>" ><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>
                                <?php }
                                else
                                {?>
                                <a style="cursor:pointer;" onclick="update_application_status('<?php echo $stat_opts->status_title;?>','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $filtered_status;?>','<?php echo $app->idd;?>','<?php echo $stat_opts->id;?>');"><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>
                               <?php  } ?>
                                
                                <br>
                                <?php }} }?>
                                </div>
                          </td>
                          <td> 
                              <?php $prof_checker=$this->recruitments_model->check_applicant_profile_seen($app->employee_info_id,$app->job_id,$app->comp_id);
                              if($prof_checker == 0){?>
                              <span class='blink_text pull-right'>unread</span>
                              <?php }?>
                          </td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                  </table>
                </div>
    </div>
</div>