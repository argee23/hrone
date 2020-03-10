<?php 
$rec_employer_setting = $this->recruitment_employer_model->rec_employer_current_setting();
if(empty($rec_employer_setting))
{
    $access_status_rec="<span class='text-danger'>(Kindly settle your account to access me)</span>";
    $job_settings_access="#";
    $job_vacancy_access="#";
    $job_application_access="#";
    $job_analytics_access="#";
    $job_requirements_access="#";
    $job_questions_access="#";
    $reports="#";
    $setting1="#";
    $job_vacancy="#";
    $job_application="#";
    $job_analytics="#";
    $job_reports="#";
     $final_job_reports="#";
}
else{
$rec_employer_setting->payment_status;
if(($rec_employer_setting->is_usage_expired=="0") AND ($rec_employer_setting->payment_status=="paid")){
    $access_status_rec="";
    $job_vacancy_access=base_url()."app/recruitment/";
    $job_settings_access="#";
    $job_application_access=base_url()."app/recruitment/job_application";
    $job_analytics_access=base_url()."app/recruitment/job_analytics";
    $job_requirements_access=base_url()."app/recruitment/requirements";
    $job_questions_access=base_url()."app/recruitment/questions";
    $reports=base_url()."recruitment_employer/recruitment_employer_management/employer_settings/public/";
    $job_vacancy=base_url()."app/final_recruitments/job_vacancy_index/public";
    $job_application=base_url()."app/final_recruitments/job_application_index/public/all/all";
    $job_analytics=base_url()."app/report_analytics_recruitment/index";
    $job_reports=base_url()."app/report_recruitment/index/public";
    $final_job_reports=base_url()."app/report_recruitments/index";
}else{
    $access_status_rec="<span class='text-danger'>(Kindly settle your account to access me)</span>";
    $job_vacancy_access="#";
    $job_settings_access="#";
    $job_application_access="#";
    $job_analytics_access="#";
    $job_requirements_access="#";
    $job_questions_access="#";
    $reports="#";
    $job_vacancy="#";
    $job_application="#";
    $job_analytics="#";
    $job_reports="#";
    $final_job_reports="#";
}
}

?>

<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" href="<?php echo base_url()?>recruitment_employer/recruitment_employer/goto_employer_profile"><i class="fa fa-dashboard"></i> Dashboard</a>
  </div>

   <div class="btn-group" role="group">
    <a type="button" class="btn btn-warning btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-newspaper-o"></i> Recruitment</a>
     <?php 
     echo 
       // Recruitment Menu
        '<ul class="dropdown-menu">'.
             
              '<li><a href="'.$reports.'"><i class="fa fa-files-o"></i>Settings '.$access_status_rec.'</a></li>'.
              '<li><a href="'.$job_vacancy.'"><i class="fa fa-files-o"></i>Job Vacancies '.$access_status_rec.'</a></li>'.
              '<li><a href="'.$job_application.'"><i class="fa fa-files-o"></i>Job Application '.$access_status_rec.'</a></li>'.
              '<li><a href="'.$job_analytics.'"><i class="fa fa-files-o"></i>Job Analytics '.$access_status_rec.'</a></li>'.
          '</ul>';
    ?>

  </div>
  <!-- <div class="btn-group" role="group">
    <a type="button" class="btn btn-primary btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-newspaper-o"></i> Recruitment</a> -->
 <?php 
 echo 
   // Recruitment Menu
    // '<ul class="dropdown-menu">'.
  //         '<li><a href="'.$job_vacancy_access.'"><i class="fa fa-files-o"></i>Job Vacancies '.$access_status_rec.'</a></li>'.
  //         '<li><a href="'.$job_application_access.'"><i class="fa fa-files-o"></i>Job Application '.$access_status_rec.'</a></li>'.
  //         '<li><a href="'.$job_analytics_access.'"><i class="fa fa-files-o"></i>Job Analytics '.$access_status_rec.'</a></li>'.
  //         '<li><a href="'.$job_requirements_access.'"><i class="fa fa-files-o"></i>Requirements '.$access_status_rec.'</a></li>'.
  //          '<li><a href="'.$job_questions_access.'"><i class="fa fa-files-o"></i>Questions '.$access_status_rec.'</a></li>'.
  //    '</ul></div>'.



'<div class="btn-group" role="group">
    <a type="button" class="btn btn-success btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-excel-o"></i> Reports</a>
  <ul class="dropdown-menu">'.
    '<li><a href="'.$job_reports.'"><i class="fa fa-files-o"></i>Recruitment Reports '.$access_status_rec.'</a></li>'.
     '<li><a href="'.$final_job_reports.'"><i class="fa fa-files-o"></i>Final Recruitment Reports '.$access_status_rec.'</a></li>'.
     '<li><a href="'.$job_analytics.'"><i class="fa fa-files-o"></i>Analytics Reports '.$access_status_rec.'</a></li>'.

    '</ul></div>'; 


   

 ?>
</div>


