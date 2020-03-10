<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />

    <!-- Inseparable -->
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/jquery.mCustomScrollbar.concat.min.js"></script>

    

    <!-- Angular JS & Application Controller -->
    <script type="text/javascript" src="<?php echo base_url()?>public/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/angular-route.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/controller.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>
   
    <!-- show header -->
    <?php require_once(APPPATH.'views/include/header_application.php');?>
    <br>

<script>
    // (function($){
    //     $(window).on("load",function(){
    //         $(".content").mCustomScrollbar();
    //     });
    // })(jQuery);
</script>
</head>
<?php

      $id = $this->session->userdata('employee_id');
      $status = $this->application_form_model->get_applicant_status($id);

      $status_title = "New Applicant";
      $status_description = "New Applicant";
      $color_code = "";

      if(!empty($status))
      {
         $status_title = $status->status_title;
         $status_description = $status->status_description;
         $color_code = $status->color_code;
      }  
?>
    <body class="signup-bg fixed" ng-app="myApp" ng-controller="appCtrl" ng-init="loadSignUpData(); getMyMessages();" ng-cloak>
    
    <!-- Start of Side View -->
    <div class="col-lg-3">
      
      <div class="panel box box-success">

        <div class="panel-heading"><h4>Employee 201 File</h4></div>
        <div class="panel-body  fixed-panel-side mCustomScrollbar" data-mcs-theme="dark"">
          <ul class="nav nav-pills nav-stacked">
              <li><a data-toggle="tab"  href="#personal_info">Personal Information <span class="fa fa-user pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#more_info" >More Information <span class="fa fa-info pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#address">Address <span class="fa fa-home pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#contact_info">Contact Information <span class="fa fa-phone pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#experience">Employment Experience <span class="fa fa-black-tie pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#educational_attainment">Educational Attainment <span class="fa fa-graduation-cap pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#trainings_seminars">Trainings and Seminars <span class="fa fa-certificate pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#skills">Skills <span class="fa fa-cogs pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#character_references">Character References <span class="fa fa-users pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#uploaded_resume">Uploaded Resume<span class="fa fa-upload pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#change_picture">Change Picture <span class="fa fa-file-photo-o pull-right"></span></a></li>
              <li><a data-toggle="tab"  href="#full_resume">View Full Resume <span class="fa fa-eye pull-right"></span></a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End of Side View -->


    <div class="col-lg-6">
        <!-- Success Feedback -->
        <?php if ($this->session->flashdata('feedback')) { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> <?php echo $this->session->flashdata('feedback'); ?>
            </div>
        <?php } ?>

        <!-- Failed Feedback -->
        <?php if ($this->session->flashdata('error')) { ?>
         <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php } ?>

        <?php echo validation_errors(); ?> 

        <div class="panel box box-danger">
            <div class="panel-body">
                <div class="tab-content" ng-view>
                  <!-- Selected Content is displayed in this div -->
    
                </div>
            </div>
        </div>

    </div>

<div class="col-lg-3">      
     <div class="box box-widget widget-user">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-green-active">
        <h3 class="widget-user-username"><?php echo $this->session->userdata('job_title'); ?></h3>
        <h5 class="widget-user-desc">Job Title</h5>
      </div>
      <div class="widget-user-image">
        <img class="img-circle" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $this->session->userdata('picture'); ?>" alt="User Avatar">
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-sm-6 border-right">
            <div class="description-block">
              <h5 class="description-header"><span class="badge" style="background: <?php echo $color_code; ?>"><?php echo $status_title; ?></span></h5>
              <span class="description-text">Application Status</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
          <div class="col-sm-6">
            <div class="description-block">
              <h5 class="description-header"><?php echo $this->session->userdata('date_applied'); ?></h5>
              <span class="description-text">Date Applied</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </div>

    <div class="info-box bg-aqua">
      <span class="info-box-icon"><i class="fa fa-user"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Username</span>
        <span class="info-box-text"><b><?php echo $this->session->userdata('username'); ?></b></span>
        <span class="info-box-text">Password</span>
        <span class="progress-description" data-toggle="tooltip" title="<?php echo $myhris; ?>"><?php echo md5($myhris); ?></span>
      </div>
    </div>

    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
      <a class="btn btn-danger pull pull-right" href="#inbox">View Messages</a>
      <div class="info-box-content">
        <span class="info-box-text">Messages</span>
        <span class="info-box-number">{{messages.length}}</span>

        <div class="progress">
          <div class="progress-bar" style="width: 100%"></div>
        </div>
            <span class="progress-description">
              Messages from Company
            </span>
      </div>
    </div>

      <div class="info-box bg-yellow" ng-init="getRequirements()">
        <span class="info-box-icon"><i class="fa fa-eye"></i></span>
        <a class="btn btn-warning pull pull-right" href="#requirements">View Requirements</a>
        <div class="info-box-content">
          <span class="info-box-text">Requirements</span>
          <span class="info-box-number">{{requirements.length}}</span>

          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
              <span class="progress-description">
                Job requirements you should pass.
              </span>
        </div>
      </div>

      <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-question"></i></span>
            <a class="btn btn-success pull pull-right" href="#questions">View Questions</a>
            <div class="info-box-content">
              <span class="info-box-text">HR Questions</span>
              <span class="info-box-number">_</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    Questions posted by HR
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
</div>

</body>
  