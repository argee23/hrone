<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">

    <link href="<?php echo base_url()?>public/bootstrap/css/developer.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">    
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    <script>
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
</script>
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php if($this->session->userdata('is_logged_in')){
$current_account_logged_in="admin or employee account";
}else{
$current_account_logged_in="employer_account";
}    
if($current_account_logged_in!="employer_account"){
   require_once(APPPATH.'views/include/sidebar.php');
  }else{
 require_once(APPPATH.'views/include/sidebar_recruitment_employer.php');
  }
?>
<body>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Recruitment
    <small>Applicant Profile</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Recruitment</li>
    <li><a href="<?php echo base_url()?>app/recruitment/job_application">Job Applications</a></li>
    <li class="active">Applicant Profile</li>
  </ol>
</section>

      <div class="container-fluid">
         
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <!-- Main content -->
        <section class="content">
<?php
if(!empty($app_info)){

?>
<div class="row">
  <div class="col-md-7">
      <button type="button" class="btn btn-primary pull-right" onclick="javascript:printDiv('printablediv')">
<i class="fa fa-print"></i>
      Print / Save as PDF</button>
  </div>
  <div class="col-md-5">
    &nbsp;
  </div>
</div>

          <div class="row">
            <div class="col-md-7 " id="printablediv">

              <div class="box box-primary">
                <div class="box-body">
<div class="col-lg-12">      
     <div class="box box-widget widget-user">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-blue-active">
        <h3 class="widget-user-username"><?php echo $app_info->fullname;?>
        <?php 
if(!empty($app_info->nick_name)){
 echo '<span style="font-size: 12px">( '.$app_info->nick_name.' ) </span>';
}else{  
//do not display nickname if its blank 
}
?>
        </h3>
         
        <h3 class="widget-user-username pull-right"><?php echo $app_info->job_title;?></h3>
 
<h5 class="widget-user-desc">
<?php
if(!empty($app_info->mobile_1)){
?> 
<i class="fa fa-mobile"></i> <?php echo $app_info->mobile_1;?>
<?php
}else{
}
echo " &nbsp;  &nbsp; ";
if(!empty($app_info->mobile_2)){
?>
<i class="fa fa-mobile"></i> <?php echo $app_info->mobile_2;

}else{
}
?>
</h5> 

<?php
if(!empty($app_info->email)){
?> 
<h5 class="widget-user-desc">
<i class="fa fa-envelope"></i> <?php echo $app_info->email;?>
</h5>
<?php
}else{
}

if(!empty($app_info->tel_1)){
?> 
<h5 class="widget-user-desc">

<i class="fa fa-phone"></i> <?php echo $app_info->tel_1;?>
<?php
}
else{
}
echo " &nbsp;  &nbsp; ";
if(!empty($app_info->tel_2)){
?>
<i class="fa fa-phone"></i> <?php echo $app_info->tel_2;

}else{
}
?>
</h5>


      </div>
      <div class="widget-user-image">
        <img class="img-circle" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $app_info->picture;?>" alt="User Avatar">
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-sm-6 border-right">
<span class="info"><i class="fa fa-calendar"></i> Date Applied:  <?php echo $app_info->date_applied;?></span><br>
<span class="info"><i class="fa fa-check-circle-o"></i> Application Status:  
<?php
$id=$app_info->ApplicationStatus;
$mystat=$this->recruitment_model->get_status_option($id);
if(!empty($mystat)){
  echo $mystat->status_title;
}else{
  echo "new";
}
?>

</span><br>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
          <div class="col-sm-6">
         <span class="info pull-right"><i class="fa fa-map"></i>
 <?php echo $app_info->present_address.", ";
                     $province_id= $app_info->present_province;

                     $city_id= $app_info->present_city;

                     if(!empty($city_id)){
$mycity=$this->general_model->myCity($city_id);
echo $mycity->city_name." "; 
                     }

                     if(!empty($province_id)){
$myprov=$this->general_model->myProvince($province_id);
echo $myprov->name;                      
                     }
?>

         </span><br>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </div>
</div>

<div class="col-md-12">
  <div class="box-body">
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Personal Information<i class="fa fa-newspaper-o pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<tr>
<td width="30%">Birthday</td>
<td><?php echo $app_info->birthday;?> <i class="fa fa-birthday-cake text-danger"></i></td>
</tr>
<tr class="alt">
<td>Civil Status</td>
<td><?php
$civil_status_id=$app_info->civil_status;
$mycivil_stat=$this->general_model->getCivil_status($civil_status_id);
if(!empty($mycivil_stat)){
  echo $mycivil_stat->civil_status;
}else{
  echo "";
}
?> </td>
</tr>
<tr>
<td>Blood Type</td>
<td><?php
$myblood_type=$this->general_model->getBloodType($app_info->blood_type);
if(!empty($myblood_type)){
  echo $myblood_type->cValue;
}else{
  echo "";
}
?>      
</td>
</tr>
<tr class="alt">
<td>Citizenship</td>
<td><?php
$mycitizenship=$this->general_model->getCitizenship($app_info->citizenship);
if(!empty($mycitizenship)){
  echo $mycitizenship->cValue;
}else{
  echo "";
}
?> </td>
</tr>
<tr>
<td>Religion</td>
<td><?php
$myreligion=$this->general_model->getReligion($app_info->religion);
if(!empty($myreligion)){
  echo $myreligion->cValue;
}else{
  echo "";
}
?> </td>
</tr>

</tbody>
</table>
</div>
<!-- //=================Other Info -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Other Information<i class="fa fa-info pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<tr class="alt">
<td width="30%">Philhealth</td>
<td><?php
echo $app_info->philhealth;
?> </td>
</tr>
<tr>
<td>SSS</td>
<td><?php
echo $app_info->sss;
?>  </td>
</tr>
<tr class="alt">
<td>Pagibig</td>
<td><?php
echo $app_info->pagibig;
?> </td>
</tr>
<tr>
<td>TIN</td>
<td><?php
echo $app_info->tin;
?> </td>
</tr>
</tbody>
</table>
</div>
<!-- //===========================work experiences -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Work Experience<i class="fa fa-black-tie pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php
$mywork_exp=$this->general_model->getMyWorkExperience($app_info->id);
if(!empty($mywork_exp)){
  foreach($mywork_exp as $work){
?>
 <tr class="alt">
    <td colspan="2" class="educ_head"><?php echo $work->position_name;?></td>
  </tr>
  <tr >
    <td  width="30%">&nbsp;</td>
    <td><?php echo $work->company_name;?></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td><?php echo $work->company_address;?></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td>Job Description</td>
  </tr>
  <tr >
    <td >&nbsp;</td>
    <td><?php
if($work->isPresentWork=="1"){
  $to_date="Present";
}else{
  $to_date=$work->date_end;
}
     echo $work->date_start." - ".$to_date;?></td>
  </tr>
<?php
  }//end of foreach
}else{
    echo "<tr><td>no work experience yet.<td></tr>";
}
?>
</tbody>

</table>
</div>

<!-- //===========================educational background -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Educational Background<i class="fa fa-book pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php 
$myeducation=$this->general_model->getMyEducation($app_info->id);
if(!empty($myeducation)){
  foreach($myeducation as $myEd){
?>
 <tr class="alt">
    <td colspan="2" class="educ_head"><?php echo $myEd->education_name;?></td>
  </tr>
  <tr >
    <td width="30%">&nbsp;</td>
    <td><?php echo $myEd->school_name;?></td>
  </tr>
  <!-- course -->
 <?php
 if(empty($myEd->course)){
  //do not display honor
 }else{
 ?> 
  <tr>
    <td >&nbsp;</td>
    <td><?php echo $myEd->course;?></td>
  </tr>
<?php
}
?>  

  <tr>
    <td >&nbsp;</td>
    <td><?php echo $myEd->school_address;?></td>
  </tr>
  <!-- honors -->
 <?php
 if(empty($myEd->honors)){
  //do not display honor
 }else{
 ?> 
  <tr>
    <td >&nbsp;</td>
    <td><?php echo $myEd->honors;?></td>
  </tr>
<?php
}
?>

  <tr >
    <td >&nbsp;</td>
    <td><?php echo $myEd->date_start." - ".$myEd->date_end;?></td>
  </tr>
<?php
  }//end of foreach
}else{
    echo "<tr><td>no educational background yet.<td></tr>";
}
?>
</tbody>

</table>
</div>

<!-- //===========================Skills -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Skills<i class="fa fa-info-circle pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php 
$myskill=$this->general_model->getMySkills($app_info->id);
if(!empty($myskill)){
  foreach($myskill as $skill){
?>
 <tr class="alt">
    <td colspan="2" class="educ_head"><?php echo $skill->skill_name;?></td>
  </tr>
  <tr >
    <td width="30%">&nbsp;</td>
    <td><?php echo $skill->skill_description;?></td>
  </tr>
 
<?php
  }//end of foreach
}else{
    echo "<tr><td>no skills yet.<td></tr>";
}
?>
</tbody>

</table>
</div>
<!-- //===========================Training & Seminars -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Training & Seminars<i class="fa fa-users pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php 
$mytraining=$this->general_model->getMyTrainings($app_info->id);
if(!empty($mytraining)){

foreach($mytraining as $train){
?>
  <tr >
    <td width="30%">
      <img src="<?php echo base_url()?>public/applicant_files/certificates/<?php echo $train->file_name;?>" class="img-responsive img-thumbnail" style="width:200px">
    </td>
    <td>
<p><?php echo $train->training_title;?></p>      
<p><?php echo $train->training_institution;?></p>    
<p><?php echo $train->training_address;?></p>        
<p><?php echo $train->conducted_by;?></p>         
<p><?php 
if($train->isOneDay=="1"){
  echo $train->date_start." - ".$train->date_start;
}else{
  echo $train->date_start." - ".$train->date_end;
}
    ?></p>      

    </td>
  </tr>
<?php
  }//end of foreach
}else{
    echo "<tr><td>no training & seminars yet.<td></tr>";
}
?>
</tbody>

</table>
</div>

<!-- //===========================Character Reference -->
<div class="datagrid">
<table>
  <thead>
    <tr>
      <th colspan="2">Character References<i class="fa fa-users pull-right"></i> </th>
    </tr>
  </thead>
<tbody >
<?php 
$myreference=$this->general_model->getMyCharacterReference($app_info->id);
if(!empty($myreference)){

foreach($myreference as $myRef){
  if(empty($myRef->reference_company)){
//if blank si company do not display 
  }else{
?>
  <tr class="alt">
    <td width="30%">Company Name</td>
    <td><?php echo $myRef->reference_company;?></td>
  </tr>
  <?php } ?>
  <tr >
    <td>Name</td>
    <td><?php echo $myRef->cValue." ".$myRef->reference_name;?></td>
  </tr>
  <tr>
    <td>Designation</td>
    <td><?php echo $myRef->reference_position;?></td>
  </tr>
  <tr>
    <td>Contact No</td>
    <td><?php echo $myRef->reference_contact;?></td>
  </tr>
  <tr >
    <td>Email</td>
    <td><?php echo $myRef->reference_email;?></td>
  </tr>
    <td colspan="2">&nbsp;</td>
  </tr>
<?php
  }//end of foreach
}else{
    echo "<tr><td>no character reference yet.<td></tr>";
}
?>
</tbody>

</table>
</div>








  </div>
</div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
            <div class="col-md-5">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li><a href="#online_questions" data-toggle="tab">
<i class="fa fa-question text-danger"></i> 
                  Questions</a></li>
                  <li class="active"><a href="#myrequirement" data-toggle="tab"><i class="fa fa-file text-danger"></i> Requirements</a></li>
                  <li><a href="#myinbox" data-toggle="tab"><i class="fa fa-comments text-danger"></i> Inbox</a></li>
                  <li><a href="#myaccount" data-toggle="tab"><i class="fa fa-key text-danger"></i>Account Information</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane" id="online_questions">
<?php
// get all qualifying questions of an applicant
$myqua_ques=$this->general_model->list_qua_ques_of_applicant($app_info->job_id);
if(!empty($myqua_ques)){
?>
<table class="table table-hover table-striped">
<thead>
  <tr>
    <th colspan="2" class="text-danger text-center">Qualifying Question</th>
  </tr>
  <tr>
    <th>Question</th>
    <th>Answer</th>
</tr>
</thead>
          <tbody>
<?php
  foreach($myqua_ques as $qq){
?>    
            <tr>
              <td><?php echo $qq->question;?></td>
              <td>
<?php
if($qq->correct_ans=="1"){
echo "Yes";
}elseif($qq->correct_ans=="0"){
echo "No";
}else{
//field content unknown
}
?>
              </td>
            </tr>
<?php
  } //end of foreach

echo "</tbody>
</table>";
}else{
echo "no qualifying questions for this position yet.<br>";
}
?>
<!-- //========== hypothetical questions -->
<?php
// get all hypothetical questions of an applicant
$myhypo_ques=$this->general_model->list_hypo_ques_of_applicant($app_info->job_id);
if(!empty($myhypo_ques)){
?>
<table class="table table-hover table-striped">
<thead>
  <tr>
    <th colspan="2" class="text-danger text-center">Hypothetical Questions</th>
  </tr>
  <tr>
    <th>Question</th>
    <th>Answer</th>
</tr>
</thead>
          <tbody>
<?php
  foreach($myhypo_ques as $hypo){
?>    
            <tr>
              <td><?php echo $hypo->question;?></td>
              <td>
<?php
$check_hypo_ans=$this->general_model->check_hypo_ans($hypo->id,$job_id,$applicant_id);
if(!empty($check_hypo_ans)){

  foreach($check_hypo_ans as $ch){
    echo $ch->answer;
  }

}else{
echo "<span class='text-danger'>no answer yet.</span>";
}
?>

              </td>
            </tr>
<?php
  } //end of foreach

echo "</tbody>
</table>";
}else{
echo "no hypothetical questions for this position yet.<br>";
}
?>
<!-- //========== multiple choices questions -->
<?php
// get all  multiple choices  questions of an applicant
$myMC_ques=$this->general_model->list_mc_ques_of_applicant($app_info->job_id);
if(!empty($myMC_ques)){
?>
<table class="table table-hover table-striped">
<thead>
  <tr>
    <th colspan="2" class="text-danger text-center">Multiple Choice</th>
  </tr>
  <tr>
    <th>Question</th>
    <th>Choices</th>
</tr>
</thead>
          <tbody>
<?php
  foreach($myMC_ques as $mc){
?>    
            <tr>
              <td><?php echo $mc->question;?></td>
              <td>
<?php 
$mymc_choices=$this->general_model->list_choices_of_mc_ques($mc->id);
if(!empty($mymc_choices)){
  foreach ($mymc_choices as $cc){
      $choice_id=$cc->mc_id;
      $check_mc_ans_choices=$this->general_model->check_mc_ans_choices($mc->id,$applicant_id,$choice_id,$job_id);
if(!empty($check_mc_ans_choices)){
  $check="checked";
  $first="<label class='text-success'>";
  $last="</label>";
}else{
  $check="";
  $first="";
  $last="";
}
    echo "<input type='checkbox' disabled ".$check." > ".$first. $cc->mc_choice. $last."<br>";


  }

}else{

}
?>
              </td>
            </tr>
<?php
  } //end of foreach
echo "</tbody>
</table>";
}else{
echo "no multiple choices questions for this position yet.<br>";
}
?>

                  </div><!-- /.tab-pane -->

  <div class="active tab-pane" id="myrequirement">
                 
    <?php 

      $myreq=$this->recruitments_model->get_jobrequirement_company_applicant($job_id,$company_id);
      
      if(empty($myreq)) { echo "no required requirements"; }
      else
      {?>
      <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>Requirement</th>
              <th>Soft<br> Copy</th>
              <th>Hard Copy</th>
              <th>Option</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach($myreq as $req){
            $check_upload = $this->recruitments_model->check_req_uploaded($req->iddd,$job_id,$applicant_id);

            if($req->IsUploadable=="1"){
                $check_if_uploadable="<i class='fa fa-download text-danger'></i>";
                $file =$check_upload;
              }else if($req->IsUploadable=="0"){
              $check_if_uploadable='<i class="fa fa-minus text-danger"></i>';
              $file ='';
              }else{  $check_if_uploadable =""; $file = '';}
            ?>
            <tr>
              <td><?php echo $req->title;?></td>
              <td>
                  <?php if(!empty($check_upload->file)){ ?>
                    <a href="<?php echo base_url(); ?>app/application_forms/download_requirements/<?php echo $check_upload->file; ?>"
                           title="Download File" ><?php echo $check_upload->file;?></a>
                  <?php } else{ ?>
                    <span class="text-danger"><?php echo $check_if_uploadable;?></span>
                    <br>
                  <?php } ?>
              </td>
              <td> 
                <span class="text-danger">
                <?php if($req->IsUploadable==1){ echo "<i class='fa fa-minus text-danger'></i>"; }
                else{ echo '<i class="fa fa-check bg-green"></i>'; }?>
                </span>
              </td>
              <td>
                 <?php
                  if(!empty($check_upload->status)){ if($check_upload->status==1) {
                    echo "submitted";
                } else{ $submitted_h = anchor('app/recruitments/hard_copy_requirement_insert/'.$applicant_id."/".$app_id."/".$job_id."/".$employer_type."/".$company_id."/".$req->bid."/".$req->iddd,'<i class="fa fa-check-circle-o fa-lg text-danger delete pull-right" ></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Submitted already?','onclick'=>"return confirm('Is ".$req->title." Submitted already? ')"));
                  echo $submitted_h; } } else{ $submitted_h = anchor('app/recruitments/hard_copy_requirement_insert/'.$applicant_id."/".$app_id."/".$job_id."/".$employer_type."/".$company_id."/".$req->bid."/".$req->iddd,'<i class="fa fa-check-circle-o fa-lg text-danger delete pull-right" ></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Submitted already?','onclick'=>"return confirm('Is ".$req->title." Submitted already? ')"));
                  echo $submitted_h; }?>
              </td>
            </tr>
          <?php } ?>
          </tbody>
      </table>

      <?php } 


    ?>

  </div>

                  <div class="tab-pane" id="myinbox">
<div style="height: 400px;overflow: auto">
                    <ul class="timeline timeline-inverse">
                      <!-- timeline time label -->
<?php
$get_company_id = $this->recruitments_model->job_details_msg($app_info->job_id);
$myinbox=$this->general_model->get_mymessages($app_info->applicant_id,$get_company_id);

if(!empty($myinbox)){
  foreach($myinbox as $mymessage){
  
 if(!empty($mymessage->IsApplicant) || $mymessage->IsApplicant==1)   {

?>

                      <li >
                        <i class="fa fa-comments bg-green"></i>
                        <div class="timeline-item" style="background-color: #C3FCC6">
                          <span class="time"><i class="fa fa-clock-o"></i>  <?php echo $mymessage->message_sent; ?></span>
                          <h3 class="timeline-header"><a href="#"><?php echo $app_info->fullname;?></a> </h3>
                          <div class="timeline-body" style="text-align: right;">
                            <?php echo $mymessage->message; ?>
                          </div>
                        </div>
                      </li>
<?php
}else{?>
                      <li>
                        <i class="fa fa-comments bg-yellow"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i>  <?php echo $mymessage->message_sent; ?></span>
                          <h3 class="timeline-header"><a href="#"><?php echo $mymessage->company_name; ?></a> </h3>
                          <div class="timeline-body" style="text-align: right;">
                            <?php echo $mymessage->message; ?>
                          </div>
                        </div>
                      </li>
  <?php
}

  }
}else{

}
?>
                    </ul>
</div>
                     <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitments/send_message_from_company/<?php echo $app_info->applicant_id ;?>/<?php echo $this->session->userdata('user_id'); ?>/<?php echo $get_company_id; ?>/<?php echo $this->uri->segment('4');?>" >
                      <div class="form-group">
                        <input type="hidden" name="employer_type" value="<?php echo $employer_type;?>">
                        <input type="hidden" name="job_id" value="<?php echo $job_id;?>">
                        <label for="inputName" class="col-sm-2 control-label">Message</label>
                        <div class="col-sm-10">
                          <textarea type="text" name="message" class="form-control" rows="10" placeholder="Type Message" required></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>

                  </div><!-- /.tab-pane -->
      <div class="tab-pane" id="myaccount">
<p>
  <button class="btn btn-xs btn-primary" type="button">Username</button>
  <button class="btn btn-xs btn-default" type="button"><?php echo $app_info->applicant_id;?></button>
</p>
<p>
  <button class="btn btn-xs btn-primary" type="button">Password</button>
<a href="" title="<?php echo $app_info->myhris;?>">  <button class="btn btn-xs btn-default" type="button"><?php echo $app_info->applicant_password;?></button>
</a> <i class="fa fa-arrow-left text-danger"> point the mouse to view true password</i> 
</p>
      </div>


                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->
<?php
}else{
  echo "employee not exist";
}

?>
        </section><!-- /.content -->
      </div>

             
<!-- Loading (remove the following to stop the loading)-->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             


 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }

      $(function () {
        $('[data-toggle="popover"]').popover()
      });

    </script>

  </body>
</html>