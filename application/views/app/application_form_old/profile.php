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

<br>
    <body class="signup-bg fixed" ng-app="myApp" ng-controller="appCtrl" ng-init="loadSignUpData(); getApplicationCount()" ng-cloak>
    <br>
    <!-- Start of Side View -->
    <div class="col-lg-3">
      
      <div class="panel box box-success">

        <div class="panel-heading"><h4>Applicant Profile</h4></div>
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



<div class="box box-info">
    <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $this->session->userdata('picture'); ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $this->session->userdata('name_of_user'); ?></h3>

              <p class="text-muted text-center">Account Information</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Username</b> <a class="pull-right"><?php echo strtoupper($this->session->userdata('username')); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Password</b> <a class="pull-right"><span class="progress-description" data-toggle="tooltip" title="<?php echo $myhris->myhris; ?>"><?php echo md5($myhris->myhris); ?></span></a>
                </li>
                <li class="list-group-item">
                  <b>Active Job Applications</b> <a class="pull-right">{{appCount.count}}</a>
                </li>
              </ul>

              <a href="<?php echo base_url()?>app/application_forms/applications" class="btn btn-primary btn-block"><b>View Applications</b></a>
            </div>
            </div>

          </div>
</div>

</body>
  