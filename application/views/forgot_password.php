<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHRIS - Forgot Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />

<!-- Inseparable -->
<script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/angular.min.js"></script>

</head>
<body class="hold-transition register-page" ng-app="">
<div class="register-box">

  <div class="register-box-body">

  <center><img class="img img-responsive img-circle" src="<?php echo base_url()?>public/company_logo/hrone.png?>" /></center>
    <p class="login-box-msg"><center><h3>Forgot Password</h3></center></p>

    <form action="validate_email" name="forgot_pass" method="post">
     <?php if ($this->session->flashdata('error')) { ?>
         <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php } ?>
      <div class="form-group has-feedback" ng-class="{'has-error' : forgot_pass.email_add.$invalid}">
      <label>Please provide a valid email address</label>
        <input type="email" class="form-control" placeholder="Email Address" ng-model="email_add" id="email_add" name="email_add" required>
        <span class="fa fa-at form-control-feedback"></span>
      </div>
      <button type="submit" class="form-control btn btn-primary" ng-disabled="forgot_pass.$invalid">Send Email</button>
    </form>
    <br>
    <center><a href="<?php echo base_url()?>/login/index" class="text-center">Back</a></center>
  </div>
  <!-- /.form-box -->
</div>
</body>
<!-- /.register-box -->
