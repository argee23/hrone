<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $info->job_title . ' - ' . $info->company_name; ?></title>
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
    <script type="text/javascript" src="<?php echo base_url()?>public/applicant_controller.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>

  </head>
      <?php require_once(APPPATH.'views/include/logo.php');?>
  <br>
    <body class="signup-bg fixed sidebar-mini" ng-app="myApp" ng-controller="appCtrl">
<!--     <div class="col-md-3"  style="position:fixed">
	    <div class="panel panel-default">
	  		<div class="panel-body"><strong>Search Jobs</strong><hr>
		  		<div class="form-group has-feedback">
				      <input type="text" class="form-control" id="job_title" placeholder="Job Title" ng-model="title">
				      <span class="fa fa-search form-control-feedback"></span>
				</div>
				<button type="button" class="btn btn-primary btn-flat btn-block" ng-click="search()">Search</button>
	  		</div>
	  		{{jobList}}
		  </div>

      <div class="panel panel-default">
      <div class="panel-body"><dt><strong>Other Jobs Posted by this Company</strong></dt></div>
      <div class="list-group">
      <?php foreach($jobs as $job)
      { ?>
    <a href="#" class="list-group-item">
      <h5 class="list-group-item-heading"><span class="text-info"><?php echo $job->job_title; ?></span></h5>
      <p class="list-group-item-text"><small><?php echo $job->company_name; ?></small></p>
    </a>
      <?php } ?>
  </div>
      </div>
    </div> -->
    <div class="col-md-6 col-md-offset-0" >
    <div class="panel panel-default">
    <div class="panel-body">
      		        <dt><h4><strong>About the Company</strong></h4></dt>
<div class="media">
  <div class="media-left media-top">
    <img src="<?php echo base_url() . 'public/company_logo/' . $info->logo; ?>" class="media-object" style="width:80px">
  </div>
  <div class="media-body">
    <h4 class="media-heading"><?php echo $info->company_name; ?> </h4>
    <p><?php echo $info->company_address; ?></p>
  </div>
</div>
                </div>
    </div>
        <div class="panel panel-default">
  		<div class="panel-body">
  		<div class="panel-header">
<!--   		<div class="pull-right"><button type="button" class="btn btn-warning btn-sm btn-flat"><span style="color: #000;"><b>Apply Now</b></span></button></div> -->
  		<h3 class="text-info"><?php echo $info->job_title; ?></h3></div>
  		<p>Date Posted: <strong><?php echo date("F d, Y", strtotime($info->date_posted)); ?></strong></p>
  		  <dl>	

                <dt><h4><strong>Job Description</strong></h4></dt>
                <dd><?php echo nl2br($info->job_description); ?></dd>
                <dt><h4><strong>Qualification</strong></h4></dt>
                <dd><?php echo nl2br($info->job_qualification); ?></dd>
                <dt><h4><strong>Number of Vacancies</strong></h4></dt>
                <dd><?php echo $info->job_vacancy; ?></dd>
                <dt><h4><strong>Salary</strong></h4></dt>
                <dd><?php echo $info->salary; ?></dd>

            </dl>

            <center>
            <p class="text-muted"><i>Hiring will start on <strong><?php echo date("F d, Y", strtotime($info->hiring_start)); ?></strong> and will end on <strong><?php echo date("F d, Y", strtotime($info->hiring_end)); ?></strong></i></p>
            </center>
            <button type="button" class="btn btn-info btn-flat btn-block"><b>APPLY NOW</b></button>
	</div>
    </div>
    </div>
    <div class="col-md-3">
        
	</div>
    </div>
    </body>