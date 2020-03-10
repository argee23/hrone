
            <div class="col-md-12" style="padding-top: 30px;">

              <table class="table table-bordered" id="job_vancany">
                      <thead>
                      <?php if($employer_type=='public')
                      {?>
                        <tr class="danger">
                          <th>No</th>
                          <th>Applicant Name</th>
                          <th>Position</th>
                          <th>Date Applied</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      <?php } else{  ?>
                         <tr class="danger">
                          <th>No</th>
                          <th>Company</th>
                          <th>Applicant Name</th>
                          <th>Position</th>
                          <th>Date Applied</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      <?php } ?>
                      </thead>
                      <tbody>
                        <?php 
                        $i=1;
                        foreach($application as $app){

                        if($employer_type=='public'){?>
                          <tr>
                              <td><?php echo $i;?></td>
                              <td><?php echo '<a href="'.base_url().'app/recruitments/applicant_profile/'.$app->employee_info_id.'/'.$app->applicant_id.'/'.$app->job_id."/".$company_id."/".$employer_type.'" style="color:'.$app->color_code.'" data-toggle="tooltip"  title="Click to view resume of '.$app->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger  "></i> &nbsp;&nbsp;'.$app->fullname.'</a>';?></td>
                              <td><?php echo $app->job_title;?></td>
                              <td><?php echo $app->date_applied;?></td>
                              <td  style="color:<?php echo $app->color_code;?>">
                                <?php if(empty($app->ApplicationStatus)){ echo "Application today"; }
                                else{ echo $app->status_title; } ?>
                              </td>
                              <td>
                              <a>
                              <?php $prof_checker=$this->recruitments_model->check_applicant_profile_seen($app->employee_info_id,$app->job_id,$company_id);
                              if($prof_checker == 0){?>
                              <span class='blink_text pull-right'>unread</span>
                              <?php }?>
                               <button data-toggle="collapse" data-target='#<?php echo $i;?>' class="btn btn-sm" >change application status</button>
                               <div id="<?php echo $i;?>" class="collapse">
                                <?php foreach($status as $stat_opts){?>
                                <?php if($stat_opts->id==1 || $stat_opts->id==4)
                                {?>
                                    <a style="cursor:pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/update_application_status')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status;?>" ><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>

                                <?php }
                                else
                                {?>
                                <a style="cursor:pointer;" onclick="update_application_status('<?php echo $stat_opts->status_title;?>','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $filtered_status;?>','<?php echo $app->idd;?>','<?php echo $stat_opts->id;?>');"><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>
                               <?php  } ?>
                                
                                <br>
                                <?php }?>
                                </div>
                              </td>
                          </tr>
                        <?php } else{?>
                          <tr>
                              <td><?php echo $i;?><?php echo $app->iSEmployer;?></td>
                              <td><?php echo $app->company_name;?></td>
                              <td><?php echo '<a href="'.base_url().'app/recruitments/applicant_profile/'.$app->employee_info_id.'/'.$app->applicant_id.'/'.$app->job_id."/".$company_id."/".$employer_type.'" style="color:'.$app->color_code.'" data-toggle="tooltip"  title="Click to view resume of '.$app->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger  "></i> &nbsp;&nbsp;'.$app->fullname.'</a>';?></td>
                              <td><?php echo $app->job_title;?></td>
                              <td><?php echo $app->date_applied;?></td>
                              <td  style="color:<?php echo $app->color_code;?>">
                                <?php if(empty($app->ApplicationStatus)){ echo "Application today"; }
                                else{ echo $app->status_title; } ?>
                              </td>
                              <td>
                              <a>
                              <?php $prof_checker=$this->recruitments_model->check_applicant_profile_seen($app->employee_info_id,$app->job_id,$company_id);
                              if($prof_checker == 0){?>
                              <span class='blink_text pull-right'>unread</span>
                              <?php }?>
                               <button data-toggle="collapse" data-target='#<?php echo $i;?>' class="btn btn-sm" >change application status</button>
                               <div id="<?php echo $i;?>" class="collapse">
                                <?php 
                                $status_ = $this->recruitments_model->get_company_applicaton_status($app->comp_id);
                                foreach($status_ as $stat_opts){?>
                                <?php if($stat_opts->id==1 || $stat_opts->id==4)
                                {?>
                                    <a style="cursor:pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/update_application_status')."/".$app->job_id."/".$company_id."/".$employer_type."/".$app->idd."/".$stat_opts->id."/".$filtered_status;?>" ><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>

                                <?php }
                                else
                                {?>
                                <a style="cursor:pointer;" onclick="update_application_status('<?php echo $stat_opts->status_title;?>','<?php echo $company_id;?>','<?php echo $employer_type;?>','<?php echo $filtered_status;?>','<?php echo $app->idd;?>','<?php echo $stat_opts->id;?>');"><i style="color:<?php echo $stat_opts->color_code;?>" class="fa fa-cog" > <?php echo $stat_opts->status_title;?></i></a>
                               <?php  } ?>
                                
                                <br>
                                <?php }?>
                                </div>
                              </td>
                          </tr>
                        <?php  } $i++; } ?>
                      </tbody>
                  </table>
              </div>