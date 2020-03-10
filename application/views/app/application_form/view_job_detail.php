<title><?php echo $info->job_title.  ' - ' . $info->company_name; ?></title>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MyHris</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">

    <!-- Inseparable -->
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />

    <script type="text/javascript" src="<?php echo base_url()?>public/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/angular-messages.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/angular-route.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/signup_controller.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>

    <!-- Header File -->
    <?php require_once(APPPATH.'views/include/header_application.php');?>
  </head>
   <body class="content-body" ng-app="myApp" ng-controller="appCtrl">
   <br>
   <div class="col-sm-3">
   </div>
   <div class="col-sm-6">
	       <div class="panel panel-default">
	             <div class="panel-body">
                <h2 class="text-center"><?php echo $info->job_title; ?></h2>
                <h4 class="text-center text-info"><strong><?php echo $info->company_name; ?></strong></h4>
                <div class="col-lg-6">
                  <span class="text-right">
                    <h3>About the Company</h3><br>
                    	<h4></h4>
                      <div class="media">
                        <div class="media-left media-top">
                          <img src="<?php echo base_url() . 'public/company_logo/' . $info->logo; ?>" class="media-object" style="width:80px">
                        </div>
                        <div class="media-body">
                          <h4 class="media-heading"><?php echo $info->company_name; ?> </h4>
                          <p><?php echo $info->company_address; ?></p>
                        </div>
                      </div>
                  </span>
                </div>

                <div class="col-lg-6">
                <h3>Job Details</h3>
                 	<h4>Job Description <span class="pull-right"><i class="fa fa-2x fa-list"></i></span></h4>
                 	<p><?php echo nl2br($info->job_description); ?></p>
                 	<br>
                 	<h4>Job Qualification <span class="pull-right"><i class="fa fa-2x fa-check-square-o"></i></span></h4>
                 	<p><?php echo nl2br($info->job_qualification); ?></p>
                 	<br>
                 	<h4>Salary <span class="pull-right"><i class="fa fa-2x fa-rub"></i></span></h4>
                 	<p><?php echo nl2br($info->salary); ?></p>
                 	<br>
                 	<h4>Hiring <span class="pull-right"><i class="fa fa-2x fa-calendar"></i></span></h4>
                 	<p>Hiring will start on <strong><?php echo date("F d, Y", strtotime($info->hiring_start)); ?></strong> and will end on <strong><?php echo date("F d, Y", strtotime($info->hiring_end)); ?></strong></p>
                </div>
                <br /><br />

                <button type="button" class="btn btn-info btn-flat btn-block"><b>APPLY NOW</b></button>

              </div>
              </div>
              </div>

              <div class="col-sm-3">
              </div>

              </body>