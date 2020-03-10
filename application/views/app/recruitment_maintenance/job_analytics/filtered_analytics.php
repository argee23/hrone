
      <table class="table table-bordered" id="job_analytics">
                      <thead>
                         <tr class="danger">
                          <th>No</th>
                          <th>Company</th>
                          <th>Position</th>
                          <th>Slot</th>
                          <th>Current Available</th>
                           <?php foreach($status as $stat)
                          {?>
                          <th><?php echo $stat->status_title;?></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                       <?php 
                        $i=1;
                        foreach($analytics as $app){?>
                           <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $app->company_name;?></td>
                            <td><?php echo $app->position_name;?></td>
                            <td><?php echo $app->job_vacancy;?></td>
                            <td>
                             <?php 
                                $get_hired_by_job = $this->recruitment_plantilla_model->get_hired_by_job($app->job_id,$app->comp_id);
                                echo $available = $app->job_vacancy - $get_hired_by_job;  
                            ?>
                            </td>
                            <?php foreach($status as $stat)
                            {?>
                              <td>  
                                <?php 
                                  $get_analytics = $this->recruitment_plantilla_model->get_num_status($app->job_id,$app->comp_id,$stat->id);
                                ?>
                                 <a data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitment_plantilla/get_applicant_by_status_application')."/".$app->job_id."/".$app->comp_id."/".$stat->id;?>"  style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view applicants'><span class='badge' <?php if(count($get_analytics)>0){ ?>   style="background-color:#ff0000;"  <?php }?> ><?php echo count($get_analytics);?></span></a>
                              </td>
                            <?php } ?>
                        </tr>
                        <?php   $i++; } ?>
                      </tbody>
              </table>
