<div class="col-md-12" style="overflow:scroll;">

<?php if($code_type=='VR1'){?>

  <table class="table table-hover" id="generate_report_results">
    <thead>
      <tr class="danger">
      <?php foreach($crystal_report as $cc){?>
        <th><?php echo $cc->label;?></th>
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
      </tr>
      <?php } ?>
    </tbody>
  </table>

<?php } else if($code_type=='VR2'){?>
  
   <table class="table table-hover" id="generate_report_results">
    <thead>
      <tr class="danger">
      <?php foreach($crystal_report as $cc){?>
        <th><?php echo $cc->label;?></th>
      <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($details as $d) {
      ?>
      <tr>
         <?php foreach($crystal_report as $cc){
          $cc_field = $cc->field;
          if($cc_field=='ApplicationStatus')
          {
            $dataa = $d->status_title;
            if(empty($dataa)){ $data='Pending'; } else{ $data=$dataa; }
          }
          else if($cc_field=='citizenship')
          {
            $data = $this->report_recruitments_model->get_results_ids('system_parameters','param_id',$d->citizenship,'cValue');
          }
          else if($cc_field=='religion')
          {
            $data = $this->report_recruitments_model->get_results_ids('system_parameters','param_id',$d->religion,'cValue');
          }
          else if($cc_field=='permanent_province')
          {
             $data = $this->report_recruitments_model->get_results_ids('provinces','id',$d->permanent_province,'name');
          }
          else if($cc_field=='permanent_city')
          {
            $data = $this->report_recruitments_model->get_results_ids('cities','id',$d->permanent_city,'city_name');
          }
          else if($cc_field=='present_province')
          {
            $data = $this->report_recruitments_model->get_results_ids('provinces','id',$d->present_province,'name');
          }
          else if($cc_field=='present_city')
          {
            $data = $this->report_recruitments_model->get_results_ids('cities','id',$d->present_city,'city_name');
          }
          else
          {
            $data = $d->$cc_field;
          }
          
         ?>
          <td><?php echo $data;?></td>
         <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
  </table>


<?php } else if($code_type=='VR3' || $code_type=='VR4' || $code_type=='VR5' || $code_type=='VR8'){?>
  
  <table class="table table-hover" id="generate_report_results">
    <thead>
      <tr class="danger">
      <?php foreach($crystal_report as $cc){?>
        <th><?php echo $cc->label;?></th>
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
      </tr>
      <?php } ?>
    </tbody>
  </table>


<?php } else if($code_type=='VR6'){?>

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
            echo $hired_applicants = $this->report_recruitments_model->get_hired_applicants($d->company_id,$d->job_id);
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
      <?php } ?>
    </tbody>
  </table>

<?php } else if($code_type=='VR7'){?>

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
            echo $hired_applicants = $this->report_recruitments_model->get_hired_applicants($d->company_id,$d->job_id);
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

<?php } ?>


</div>
   