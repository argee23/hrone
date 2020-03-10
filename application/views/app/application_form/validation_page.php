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
  <br>
    <body class="signup-bg fixed sidebar-mini" ng-app="myApp" ng-controller="appCtrl">

    <div class="register-box">
      <div class="register-box-body">
        <center><img class="img img-responsive img-circle" src="<?php echo base_url()?>public/company_logo/hrone.png?>" /></center>
          <?php if (empty($status)) {?>

          
            <p class="login-box-msg"><center><h3>Applicant Account</h3></center></p>
            <p class="text-primary"><center>The following is your account to track your application.</center></p>

            <b>Username: </b> <?php echo $applicant_id; ?> <br>
            <b>Password: </b> <?php echo $password; ?><br>
            <br><br>

            <a href="<?php echo base_url()?>/login/applicant_login/<?php echo $applicant_id; ?>/<?php echo $password; ?>" class="btn btn-success btn-block btn-md">Login <i class="fa fa-sign-in"></i></a>
          <?php } 

          else  {?>

              <p class="login-box-msg"><center><h4><?php echo $message; ?></h4></center></p><br><br>
              <a href="<?php echo base_url()?>/login/index" class="btn btn-success btn-block btn-md">Back to HOME <i class="fa fa-sign-in"></i></a>


          <?php }  ?>
          <br>
      </div>
    </div>

    </body>