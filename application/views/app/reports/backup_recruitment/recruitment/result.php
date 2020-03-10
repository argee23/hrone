	<div class="row">
        <div class="col-md-8 col-md-offset-2">
        	<hr>
    	</div>
    </div>
    <table id="jobVacancy" class="table table-bordered table-striped">
    				<thead>
                      <tr>
                        <th>Company Name</th>
                        <th>Position</th>
                        <th>Slot</th>
                        <th>Salary</th>
                        <th>Job Description</th>
                        <th>Job Qualification</th>
                        <th>Hiring Start</th>
                        <th>Hiring End</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($reports as $reports){ ?>

                      <tr>
                        <td><?php echo $reports->company_name?></td>
                        <!-- <td><a tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="focus" title="Event Description" data-content="<?php echo nl2br($reports->event_description) ?>"><?php echo $reports->event_title?></a></td> -->
                        <!-- <td>
                          <a role="button" data-html="true" data-toggle="collapse" data-target="#info_<?php echo $reports->id?>"><?php echo $reports->job_title?></a>
                          <div id="info_<?php echo $reports->id?>" class="collapse">
                          <p class="text-success">
                          <?php echo nl2br($reports->event_description) ?>
                          </p>
                          </div>
                        </td> -->
                        <td><?php echo $reports->job_title?></td>
                        <td><?php echo $reports->job_vacancy?></td>
                        <td><?php echo $reports->salary?></td>
                        <td><?php echo $reports->job_description?></td>
                        <td><?php echo $reports->job_qualification?></td>
                        <td><?php echo $reports->hiring_start?></td>
                        <td><?php echo $reports->hiring_end?></td>
                        <td><?php if($reports->status_per_company == 1){ echo "Open";} else { echo "Close"; } ?></td>  
                        
                        <!-- <td>
                        <?php 
                        if($reports->event_start && $reports->event_end < date('Y-m-d H:i:s')) { 
                          echo "<strong class='text-danger'>Completed</strong>";
                        } 
                        else if ($reports->event_start < date('Y-m-d H:i:s') && $reports->event_end > date('Y-m-d H:i:s')){
                          echo "<strong class='text-success'>Ongoing</strong>";
                        }
                        else{
                          echo "<strong class='text-info'>Upcoming</strong>";
                        } 
                        ?>
                        </td> -->
                      </tr>
                      <?php }?>
                     
                    </tbody>
    </table>