<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" href="<?php echo base_url()?>app/application_form/"><i class="fa fa-dashboard"></i> Dashboard</a>
  </div>

  <div class="btn-group" role="group">
    <a type="button" href="<?php echo base_url()?>app/application_form/profile" class="btn btn-success btn-flat"><i class="fa fa-user"></i> Profile</a>
  </div>

  

   <div class="btn-group" role="group">
    <a type="button" class="btn btn-danger btn-flat" href="<?php echo base_url()?>app/application_forms/applications"><i class="fa fa-book"></i> Job Applications</a>
  </div>
<!-- 
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat"><i class="fa fa-bullhorn"></i> Resume</a>
  </div> -->

  <?php $count = $this->application_form_model->countRequirements()->count; 
  $allow = $this->application_form_model->checkRequirementModule()->count;
  if ($allow > 0) { ?>
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat" href="<?php echo base_url()?>app/application_form/requirements"><i class="fa fa-check-square-o"></i> Job Requirements <?php if ($count > 0) { ?> <span class="badge label-danger"><?php echo $count; ?></span>  <?php } ?></a>
  </div>

  <?php } ?>
  

  <?php $countQ = $this->application_form_model->countQuestions()->count; 
  $allowQ = $this->application_form_model->checkQuestionsModule()->count;
  if ($allowQ > 0) { ?>
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-success btn-flat" href="<?php echo base_url()?>app/application_form/questions"><i class="fa fa-edit"></i> HR Questions <?php if ($countQ > 0) { ?> <span class="badge label-danger"><?php echo $countQ; ?></span> <?php } ?></a>
  </div>

  <?php } ?>

  <?php $countM = $this->application_form_model->countMessages()->count; 
  $allowM = $this->application_form_model->checkMessagesModule()->count;
  if ($allowM > 0) { ?>
  <div class="btn-group" role="group">
    <a type="button" class="btn bg-navy btn-flat" href="<?php echo base_url()?>app/application_form/messages"><i class="fa fa-envelope-square"></i> Company Messages <?php if ($countM > 0) { ?> <span class="badge label-danger"><?php echo $countM; ?></span> <?php } ?></a>
  </div>

  <?php } ?>


  <div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i>&nbsp;Reports</a>
    <ul class="dropdown-menu pull-right">
      <li class="bg-info"><a href="<?php echo base_url()?>app/applicant_reports/index"><i class="fa fa-clock-o"></i>Detailed Job Applications</a></li>
      <li class="bg-info"><a href="<?php echo base_url()?>app/applicant_reports/generate_reports"><i class="fa fa-clock-o"></i>Filter Job Applications</a></li>
    </ul>
  </div>

<!-- 
   <div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" href="<?php//echo base_url()?>app/application_form/vacancies"><i class="fa fa-newspaper-o"></i> Job Vacancies</a>
  </div> -->
</div>