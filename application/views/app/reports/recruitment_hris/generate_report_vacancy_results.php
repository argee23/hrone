<div class="col-md-12" style="overflow:scroll;">

<?php if($code_type=='VR7'){?>
     <table class="table table-hover" id="generate_report_results">
    <thead>
      <tr class="danger">
      <?php foreach($crystal_report as $cc){?>
        <th><?php echo $cc->label;?></th>
      <?php } ?>
      <th>Hired Applicants etc</th>
      <th>Remaining Target Applicant</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($details as $d) {
        if($d->optiontype==false){}
          else {
      ?>
      <tr>
         <?php foreach($crystal_report as $cc){
          $cc_field = $cc->field;
          if($cc->field=='location')
          {
             $data = $d->city_name.",".$d->name;
          }
          else
          {
               $data = $d->$cc_field;
          }
          
         ?>
          <td><?php echo $data;?></td>
         <?php } ?>
         <td>
           <?php
            echo $hired_applicants = $this->report_recruitments_hris_model->get_hired_applicants($d->company_id,$d->job_id);
           ?>
         </td>
         <td>
           <?php 
            $count_target_applicant = $d->with_target_applicant;
            $remaining = $count_target_applicant - $hired_applicants;
            echo $remaining;
           ?>
         </td>
      </tr>
      <?php } } ?>
    </tbody>
  </table>

<?php } else if($code_type=='VR8'){?>

     <table class="table table-hover" id="generate_report_results">
    <thead>
      <tr class="danger">
      <?php foreach($crystal_report as $cc){?>
        <th><?php echo $cc->label;?></th>
      <?php } ?>
        <th>Hired Applicants (based on setting)</th>
        <th>Slots Left</th>
        <th>Job Position Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($details as $d) {
        if($d->slot_status==true){ 
        $date  = date('Y-m-d');
        $count_hired = $this->report_recruitments_hris_model->get_hired_applicants($d->company_id,$d->job_id); 
        $slot_sleft = $d->job_vacancy - $count_hired;

        if($d->plantilla_from <= $date AND $d->plantilla_to >=$date)
        {
          $job_status = 'Active';
        }
        else
        {
           $job_status = 'InActive';
        }
      ?>
      <tr>
         <?php foreach($crystal_report as $cc){
          $cc_field = $cc->field;
          if($cc->field=='location')
          {
             $data = $d->city_name.",".$d->name;
          }
         
          else
          {
               $data = $d->$cc_field;
          }
         
         ?>
          <td><?php echo $data;?></td>
         <?php } ?>

        
          <td>
            <?php echo $count_hired; ?>
          </td>
          <td>
            <?php echo $slot_sleft;?>
          </td>
          <td>
            <?php echo $job_status;?>
          </td>

      </tr>
      <?php } } ?>
    </tbody>
  </table>


<?php } else{?>
  <table class="table table-hover" id="generate_report_results">
    <thead>
      <tr class="danger">
      <?php foreach($crystal_report as $cc){?>
        <th><?php echo $cc->label;?></th>
      <?php } ?>

      <?php if($code_type=='VR6' || $code_type=='VR7')
      {?>
        <th>Hired Applicants etc</th>
        <th>Remaining Target Applicant</th>
      <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($details as $d) {
      ?>
      <tr>
         <?php foreach($crystal_report as $cc){
          $cc_field = $cc->field;
          if($cc->field=='location')
          {
             $data = $d->city_name.",".$d->name;
          }
         
          else
          {
               $data = $d->$cc_field;
          }
         
         ?>
          <td><?php echo $data;?></td>
         <?php } ?>

         <?php if($code_type=='VR6' || $code_type=='VR7'){?>
            <td>
             <?php
              echo $hired_applicants = $this->report_recruitments_hris_model->get_hired_applicants($d->company_id,$d->job_id);
             ?>
            </td>
            <td>
             <?php 
              $count_target_applicant = $d->with_target_applicant;
              $remaining = $count_target_applicant - $hired_applicants;
              echo $remaining;
             ?>
            </td>
         <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
  </table>

<?php } ?>