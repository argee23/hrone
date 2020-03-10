<div class="col-md-12"> 
    <div class="col-md-3">
         <div class="box-body">
                  <div id="MassUploading">
                    <div class="well">
                      <div class="MassUploading" style="height: 300px;">
                          
                         
                          <div class="col-md-12">
                              <label>Date Posted From</label>
                              <input type="date" class="form-control" id="from" onchange="get_position_based_ondate('<?php echo $company_id;?>');">
                          </div>

                          <div class="col-md-12" style="margin-top: 10px;">
                              <label>Date Posted To</label>
                              <input type="date" class="form-control" id="to" onchange="get_position_based_ondate('<?php echo $company_id;?>');">
                          </div>

                          <div class="col-md-12" style="margin-top: 10px;">
                              <label>Position</label>
                              <select class="form-control" id="position">
                                  <option value="" selected disabled>Select Position</option>
                              </select>
                          </div>

                          <div class="col-md-12" style="margin-top: 20px;">
                              <button class="col-md-12 btn btn-success pull-right btn-sm" onclick="job_filtering_analytics('<?php echo $employer_type;?>','<?php echo $company_id;?>');"><i class="fa fa-arrow-right"></i>Filter</button>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
    </div>

    <div class="col-md-9">
        <div class="col-md-12" style="overflow: scroll;margin-top: 20px;" id='job_analytics_filtering'>
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
                                $get_hired_by_job = $this->final_recruitments_model->get_hired_by_job($app->job_id,$app->comp_id);

                                echo $available = $app->job_vacancy - $get_hired_by_job;
                              
                            ?>
                            </td>
                            <?php foreach($status as $stat)
                            {?>
                              <td>
                                <?php 
                                  $get_analytics = $this->final_recruitments_model->get_num_status($app->job_id,$app->comp_id,$stat->id);
                                ?>
                                 <a data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/recruitments/get_applicant_by_status_application')."/".$app->job_id."/".$app->comp_id."/".$stat->id."/".$employer_type;?>"  style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to view applicants'><span class='badge' <?php if(count($get_analytics)>0){ ?>   style="background-color:#ff0000;"  <?php }?> ><?php echo count($get_analytics);?></span></a>
                              </td>
                            <?php } ?>
                        </tr>
                        <?php   $i++; } ?>
                      </tbody>
                  </table>           
        </div>
    </div>
</div>