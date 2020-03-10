
              <table class="table table-bordered" id="job_analytics">
                      <thead>
                      <?php if($employer_type=='public')
                      {?>
                        <tr class="danger">
                          <th>No</th>
                          <th>Position</th>
                          <th>Slot</th>
                          <th>Current Available</th>
                          <?php foreach($status as $stat)
                          {?>
                          <th><?php echo $stat->status_title;?></th>
                          <?php } ?>
                        </tr>
                      <?php } else{  ?>
                         <tr class="danger">
                          <th>No</th>
                          <th>Company</th>
                          <th>Position</th>
                          <th>Slot</th>
                          <th>Current Available</th>
                           <?php foreach($status as $stat)
                          {
                            if($stat->id==1)
                            {
                                $get_interview_process = $this->recruitments_model->get_interview_process($company_id);
                                foreach($get_interview_process as $gp)
                                {?>
                                  <th><?php echo $gp->title;?></th>
                                <?php }
                            }
                          else{
                          ?>
                          <th><?php echo $stat->status_title;?></th>
                          <?php }  } ?>
                        </tr>
                      <?php } ?>
                      </thead>
                      <tbody>
                        <?php 
                        $i=1;
                        foreach($analytics as $app){
                        if($employer_type=='public'){?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $app->position_name;?></td>
                            <td><?php echo $app->job_vacancy;?></td>
                            <td>
                            <?php 
                              $get_hired_by_job = $this->recruitments_model->get_hired_by_job($app->job_id,$app->company_id);
                              echo $available = $app->job_vacancy - $get_hired_by_job;
                            ?>
                              

                            </td>
                            <?php foreach($status as $stat)
                            {
                               if($stat->id==1)
                                {}
                              else{
                            ?>
                              <td>
                                 <?php 
                                  $get_analytics = $this->recruitments_model->get_num_status($app->job_id,$app->comp_id,$stat->id); 
                                  ?>
                                  <a data-toggle='collapse' data-target='#<?php echo $app->job_id.$stat->id;?>' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view applicant'><span class='badge' <?php if(count($get_analytics)>0){ ?>   style="background-color:#ff0000;"  <?php }?> ><?php echo count($get_analytics);?></span></a>
                                  <div class="collapse" id="<?php echo $app->job_id.$stat->id;?>">
                                  <?php 
                                    foreach($get_analytics as $ga)
                                    { echo '<a href="'.base_url().'app/recruitments/applicant_profile/'.$ga->employee_info_id.'/'.$ga->applicant_id.'/'.$ga->job_id."/".$ga->company_id."/".$employer_type.'" data-toggle="tooltip"  title="Click to view resume of '.$ga->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger  "></i> &nbsp;&nbsp;'.$ga->fullname.'</a>';
                                     }
                                  ?>
                                  </div>
                              </td>
                            <?php } } ?>
                        </tr>

                        <?php } else{?>
                           <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $app->company_name;?></td>
                            <td><?php echo $app->position_name;?></td>
                            <td><?php echo $app->job_vacancy;?></td>
                            <td>
                             <?php 
                                $get_hired_by_job = $this->recruitments_model->get_hired_by_job($app->job_id,$app->company_id);

                                echo $available = $app->job_vacancy - $get_hired_by_job;
                            ?>

                            </td>
                            <?php foreach($status as $stat)
                            {
                               if($stat->id==1)
                                {
                                   $get_interview_process = $this->recruitments_model->get_interview_process($company_id);
                                    foreach($get_interview_process as $gp)
                                    {
                                        $get_hired_by_job_process = $this->recruitments_model->get_hired_by_job_process($app->job_id,$company_id,$gp->numbering);

                                    ?>
                                      <td>
                                         <a data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/get_applicant_by_status_application_interview')."/".$app->job_id."/".$app->comp_id."/".$stat->id."/".$employer_type."/".$gp->interview_id;?>"  style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view applicants'><span class='badge' <?php if($get_hired_by_job_process>0){ ?>   style="background-color:#ff0000;"  <?php }?> ><?php echo $get_hired_by_job_process;?></span></a>
                                      </td>
                                    <?php
                                    }
                                }
                              else{
                            ?>
                              <td>
                                 <?php 
                                  $get_analytics = $this->recruitments_model->get_num_status($app->job_id,$app->comp_id,$stat->id);?>
                                  <a data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/get_applicant_by_status_application')."/".$app->job_id."/".$app->comp_id."/".$stat->id."/".$employer_type;?>"  style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view applicants'><span class='badge' <?php if(count($get_analytics)>0){ ?>   style="background-color:#ff0000;"  <?php }?> ><?php echo count($get_analytics);?></span></a>

                                 
                              </td>
                            <?php }} ?>
                        </tr>
                        <?php  } $i++; } ?>
                      </tbody>
                  </table>