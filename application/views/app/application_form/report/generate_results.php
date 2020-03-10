<?php if($type=='job_application') { ?>

    <table class="table table-hover" id="resultss">
        <thead>
            <tr class="danger">
              <?php foreach($fields as $f){?>
                <th><?php echo $f->label;?></th>
              <?php } ?>
            </tr>
        </thead>
        <tbody>
          <?php foreach($details as $d){?>
            <tr>
              <?php foreach($fields as $f){
                $val = $f->field;
               
                if($val=='resume_status')
                {
                  $ddd = $this->applicant_reports_model->check_resume($d->job_id);
                  if($ddd > 0){ $data = 'Viewed'; } else{ $data = 'Unread'; }
                }
                else if($val=='location')
                {
                  $data = $this->applicant_reports_model->get_location($d->loc_province,$d->loc_city);
                }
                else if($val=='status_title')
                {
                  if(empty($d->status_title)){ $data='Pending Application'; } else{ $data  = $d->status_title; }
                }
                else if($val=='job_specialization')
                {
                  $sp = $this->applicant_reports_model->get_specialization($d->job_specialization);
                  if(empty($sp)){ $data = '-'; } else{ $data = $sp; }
                }
                else
                {
                  $data = $d->$val;
                }
              ?>
                <td><?php echo $data;?></td>
              <?php } ?>
            </tr>
          <?php } ?>
        </tbody>
    </table>

<?php } else if($type=='applicant_referral'){?>

    <table class="table table-hover" id="resultss">
        <thead>
            <tr class="danger">
                <th>Company</th>
                <th>Position</th>
                <th>Date Posted</th>
                <th>Employee</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($details as $d){?>
            <tr>
               <td><?php echo $d->company_name;?></td>
               <td><?php echo $d->job_title;?></td>
               <td><?php echo $d->date_posted;?></td>
               <td><?php echo $d->employee;?></td>
            </tr>

            <?php } ?>
          
        </tbody>
    </table>

<?php } else{  ?>

    
      <table class="table table-hover" id="resultss">
        <thead>
            <tr class="danger">
              <?php foreach($fields as $f){?>
                <th><?php echo $f->label;?></th>
              <?php } ?>
            </tr>
        </thead>
        <tbody>
          <?php foreach($details as $d){?>
            <tr>
              <?php foreach($fields as $f){
                $val = $f->field;
               
                if($val=='title')
                {
                  $ddd = $this->applicant_reports_model->get_interview_process_title($d->interview_process_id);
                  if(empty($ddd)){ $data = '-'; } else{ $data = $ddd; } 
                }
                else if($val=='location')
                {
                  $data = $this->applicant_reports_model->get_location($d->loc_province,$d->loc_city);
                }
                else if($val=='status_title')
                {
                  if(empty($d->status_title)){ $data='Pending Application'; } else{ $data  = $d->status_title; }
                }
                else if($val=='job_specialization')
                {
                  $sp = $this->applicant_reports_model->get_specialization($d->job_specialization);
                  if(empty($sp)){ $data = '-'; } else{ $data = $sp; }
                }
                else
                {
                  $data = $d->$val;
                }
              ?>
                <td><?php echo $data;?></td>
              <?php } ?>
            </tr>
          <?php } ?>
        </tbody>
    </table>


<?php } ?>