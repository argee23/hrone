<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MyHRIS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
           
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/blur_demo.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/blur_style.css" rel="stylesheet">
    <script src="<?php echo base_url()?>public/modernizr.js"></script>  

    <style>
         .login-bg{
        background: 
             linear-gradient(
                rgba(0,0, 0, 0.0), 
                rgba(0,0,0, 0.0)
                ),  
        url('<?php echo base_url()?>/public/img/login-bg/bg_employer.jpg');

            background-size: 100%;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .hiring{
            width: 150px;
            height: 100px;
        }
        /*forgot password*/
        .fp{
            border-radius: 10px;
            border-bottom: 4px solid #1950AB;
        }
        .looking_for_a_job{
            width: 250px;
            height: 40px;
        }
        .biologin{
        margin:5px;
        margin-top: 20px;
        background: #CCC;
        opacity: 0.9;
        }
        .register_size{
          width: 100%;
          height: 550px;
    
        }
        .login_size{
          width: 100%;
          height: 200px;
    
        }
        .design_size{

          width: 50%;
          height: 250px;
   
        }
      .first_add{
        font-weight: bold;
        color: #ff0000;
        font-size: 1.3em;
      }
      .goback{
        text-align: right;
      }
    </style>

</head>
<body class="login-bg home-page" ng-app="">

<div class="row">

      <div class="col-md-2" >
      <img  height="60" class="img img-responsive" src="<?php echo base_url()?>public/img/cropped.png" alt="Brand">
      </div>

  <div class="col-md-12" >
  &nbsp;
  </div>
  <div class="col-md-1" >
  &nbsp;
  </div>

<!-- //===================== -->
<div class="col-md-5 biologin"><!-- col-md-6 biologin -->
    <?php echo validation_errors()?> 
<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"></li>
    <li ><a > <span class="first_add"> Auto Sync Logs</a> </li>
    <li ><a href="<?php echo base_url()?>/auto_sync_logs/auto_sync_logs/bio_logout">  <button class="btn btn-default col-md-12" ><i class="fa fa-arrow-left   fa-sm"></i>Logout</button></a> 
    </li>
  </ul>

  <div style="float: right;">
    Welcome
    <?php 
    echo $this->session->userdata('bio_name_of_user');
    echo  ' <img class="img-circle" style="width:50px;" src="'.base_url()."public/employee_files/employee_picture/".$this->session->userdata('bio_picture').'"'; 
    ?>
  </div>

    </div><!-- /.nav-tabs-custom -->
  </div><!-- /.col -->

<div class="col-md-12">
</div>
<div class="col-md-12">
</div>


<!-- //==================================== COMPANY LIST -->
    <div class="row">

<!-- //==================================== BIOMETRICS DETAILS -->

    <div class="collapse col-md-12" id="view_setup">
    <div class="panel panel-danger">
    <!-- Default panel contents -->
    <div class="panel-heading">   <strong> Biometrics

</strong></div>
    <div class="panel-body">
    
    <?php


echo '

      
<button class="btn btn-danger col-md-12" >Auto Sync Logs Action  <i class="fa fa-arrow-down text-default"></i></button> 
<button class="btn btn-default col-md-12" > '.$sync_action_text.'</button> 

<button class="btn btn-default col-md-5" >Biometrics:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$bio_name.' (ID: '.$bio_id.')</button> 

<button class="btn btn-default col-md-12" >Location:</button> 
<button class="btn btn-default col-md-12" > <i class="fa fa-arrow-right text-primary"></i> '.$m_file_loc_name.'</button> 
<button class="btn btn-default col-md-5" >IP Address:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$m_ip_address.'</button> 
<button class="btn btn-default col-md-5" >Table Name:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$file_table_name.'</button> 

<button class="btn btn-default col-md-5" >Employee ID Field Name:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$employee_id_field_name.'</button> 
<button class="btn btn-default col-md-5" >Logs Field Name:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$logs_field_name.'</button> 
<button class="btn btn-default col-md-5" >Logs Type Field Name:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-primary"></i> '.$logs_type_field_name.'</button> 

<button class="btn btn-danger col-md-5" >  IN Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-danger"></i> '.$code_in.'</button> 

<button class="btn btn-danger col-md-5" >  OUT Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-danger"></i> '.$code_out.'</button> 
';

if($sync_action=="125"){ // get break as well

echo '
<button class="btn btn-warning col-md-5" >  First Break OUT Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-warning"></i> '.$code_break_out1.'</button> 

<button class="btn btn-warning col-md-5" >  First Break IN Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-warning"></i> '.$code_break_in1.'</button> 

<button class="btn btn-info col-md-5" >  Lunch Break OUT Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-info"></i> '.$code_lunch_out.'</button> 

<button class="btn btn-info col-md-5" >  Lunch Break IN Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-info"></i> '.$code_lunch_in.'</button> 

<button class="btn btn-success col-md-5" >  Second Break OUT Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-success"></i> '.$code_break_out2.'</button> 

<button class="btn btn-success col-md-5" >  Second Break IN Code:</button> 
<button class="btn btn-default col-md-7" > <i class="fa fa-arrow-right text-success"></i> '.$code_break_out1.'</button> 
      ';
}else{

}
    ?>

    </div>

    </div>
    </div>




    <div class="col-md-12">
    <div class="panel panel-info">
    <!-- Default panel contents -->
    <div class="panel-heading">   <strong> Company


<?php
echo  $view_setup='<a class="fa fa-'.$system_defined_icons->icon_view.' pull-right text-primary" data-toggle="collapse" title="Click to view biometrics setup" href="#view_setup" aria-expanded="false" aria-controls="collapseExample"> Click To View Biometrics Setup</a>';

?>
    

    </strong></div>
    <div class="panel-body">
    
   <form action="<?php echo base_url(); ?>auto_sync_logs/auto_sync_logs/auto_sync_now/<?php echo $bio_id?>" method="post" name="upload_mdb"  enctype="multipart/form-data" target="_blank"> 

    <?php
      //echo $this->session->userdata('bio_logged_in');
    if(!empty($companyList)){

     foreach($companyList as $comp){

          $isemployee_exist=$this->time_manual_attendance_model->check_employees($comp->company_id);
          if(!empty($isemployee_exist)){
            $no_employee_notice="";
            $no_employee_notice_rmrks="";
          }else{
            $no_employee_notice="disabled";
            $no_employee_notice_rmrks='<i class="fa fa-ban text-danger"></i>';
            $no_employee_notice_notes='<span ><i>(no employee yet.)</i></span>';
            
          }


 $isrealtime=$this->auto_sync_logs_model->companyRealtimeLogs($comp->company_id);
 if(!empty($isrealtime)){
  $realTime="1";
  $realTime_marked="checked";
  $dont_allow_select="disabled";
  $dont_allow_select_guide='<a title="you may checked this at the administrator account via time>biometrics setup>biometrics type management>manage biometrics setup"><i class="small">how to uncheck me?</i></a>';
 }else{
  $realTime="";
  $realTime_marked="";
  $dont_allow_select="disabled";
  $dont_allow_select_guide='<a title="you may checked this at the administrator account via time>biometrics setup>biometrics type management>manage biometrics setup"><i class="small">how to check me?</i></a>';
 }

$sms_notif_setting=$this->auto_sync_logs_model->sms_notif_value($comp->company_id,1);
if(!empty($sms_notif_setting)){
  $allow_sms_notif=$sms_notif_setting->setting;
}else{
  $allow_sms_notif="off";
}

if($allow_sms_notif=="on"){
  $allow_sms_notif_notice='<span class="text-success small">(SMS Notification is Turned On)</span>';
}else{
  $allow_sms_notif_notice='<span class="text-danger small">(SMS Notification is Turned OFF)</span>';
}

          if($no_employee_notice==""){
              echo 
              '<label class="col-md-12 text-default">
              <input type="checkbox" '.$dont_allow_select.' name="chosen_company[]" value="'.$comp->company_id.'" '.$no_employee_notice.' value='.$realTime.' '.$realTime_marked.'>
              <span>'.$dont_allow_select_guide.'</span>
              '.$comp->company_name.' &nbsp;'.$no_employee_notice_rmrks.''.$allow_sms_notif_notice.'
              </label>
             
              ';
          }else{

              echo 
              '
             <label class="col-md-12" style="color:#A9A9A9;">
              '.$no_employee_notice_rmrks.' &nbsp;'.$comp->company_name.' &nbsp;
              '.$no_employee_notice_notes.'
              </label>
              ';            
          }

         }
    }else{

      //echo "none";
    }


    ?>

    <div class="form-group">
 
    </div>
    <div class="form-group">
      <label for="type" class="col-sm-12 control-label">Resync- Date From</label>
        <div class="col-sm-12">
          <input type="date" name="date_from" class="form-control" >
        </div>
    </div>
    <div class="form-group">
      <label for="type" class="col-sm-12 control-label">Resync- Date To</label>
        <div class="col-sm-12">
          <input type="date" name="date_to" class="form-control" >
        </div>
    </div>

      <button 
      <?php
      if($bio_setup_status==""){
      }else{
        echo "disabled";
      }
      ?>

     type="submit" id="submit" name="save" class="btn btn-danger btn pull-right" onclick="$('form').attr('target', '_blank');"><i class="fa fa-upload"></i> Start Auto Sync Biometrics</button>



</form>



    </div>
    <div class="panel-footer">
      <?php echo $bio_setup_status;?>
    </div>

    </div>
    </div>



</div>
</div><!--end row-->

<!-- //================================ -->
<div class="col-md-5 biologin"><!-- col-md-6 biologin -->
<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"></li>
    <li ><a > <span class="first_add"> SMS Mobile Application Attendance</a> </li>
  </ul>
&nbsp;

</div><!-- /.nav-tabs-custom -->

 <div class="row">

<!-- //==================================== BIOMETRICS DETAILS -->

    <div class="col-md-12">
    <div class="panel panel-danger">
    <div class="panel-heading">   <strong> &nbsp;</strong>



<?php
echo  $view_setup='<a class="fa fa-'.$system_defined_icons->icon_view.' pull-right text-primary" data-toggle="collapse" title="Click to view SMS settings" href="#view_mps" aria-expanded="false" aria-controls="collapseExample"> View SMS Settings</a>';

?>
    
    </div>
    <div class="panel-body">
    
<!-- //============= -->
    <div class="collapse col-md-12" id="view_mps">
    <div class="panel panel-danger">
    <!-- Default panel contents -->
    <div class="panel-heading">   <strong> SMS Settings</strong></div>
    <div class="panel-body">
    
<!-- sync_setting -->


    </div>
    </div>
    </div>

<!-- //============= -->








<form action="<?php echo base_url(); ?>auto_sync_logs/auto_sync_logs/auto_sync_sms_app_att/" method="post" name="upload_sms_app_att"  enctype="multipart/form-data" target="_blank"> 

    <div class="form-group">
      <label for="type" class="col-sm-12 control-label">Resync- Date From</label>
        <div class="col-sm-12">
          <input type="date" name="date_from" class="form-control" >
        </div>
    </div>
    <div class="form-group">
      <label for="type" class="col-sm-12 control-label">Resync- Date To</label>
        <div class="col-sm-12">
          <input type="date" name="date_to" class="form-control" >
        </div>
    </div>


    <div class="form-group">
      <label for="type" class="col-sm-12 control-label">Re-sync Attendance?</label>
        <div class="col-sm-12">
          <input type="checkbox" name="do_mresync" value="1" > <i>(Check Me if yes)</i>
        </div>
    </div>
    <br>
     <button type="submit" name="get_sms_app_attendance" class="btn btn-primary btn pull-right"onclick="$('form').attr('target', '_blank');"><i class="fa fa-upload"></i> 
       Start Auto Sync SMS Attendance Application
     </button>
</form>



    </div>
    </div>
    </div>




</div><!-- div 4 -->


</body>
</html>



    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
