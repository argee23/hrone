<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php 

if($this->session->userdata('is_logged_in')){
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Change Password
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Account</a></li>
    <li class="active">Change Password</li>
  </ol>
</section>
  <!-- Main content -->
  <section class="content">

<div class="row">

      <?php echo $message;?>
      <?php echo validation_errors(); ?>

  <div class="col-md-3">  </div>

  <div class="col-md-6">  
    <div class="box box-primary">
        <div class="panel-heading"><strong>Change Password</strong><i class="fa fa-key pull-right"></i></a></div>
      <div class="panel-body">
<?php
    if($this->session->userdata('recruitment_employer_is_logged_in')){
?>
<form class="form-horizontal" method="post" action="<?php echo base_url()?>recruitment_employer/recruitment_employer/go_change_password" >
<?php
    }else{
?>
<form class="form-horizontal" method="post" action="<?php echo base_url()?>recruitment_employer/recruitment_employer/go_change_admin_password" >
<?php
    }
?>



      <div class="form-group">
         <label for="old_password" class="col-sm-2 control-label">Old Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Enter Old Password" value="" required >
        </div>
      </div>
      <div class="form-group">
         <label for="new_password" class="col-sm-2 control-label">New Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter New Password" value="" required minlength="8">
        </div>
      </div>
      <div class="form-group">
         <label for="retype_password" class="col-sm-2 control-label">Re-Type Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="retype_password" id="retype_password" placeholder="Retype Password" value="" required  minlength="8">
        </div>
      </div>
       <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i>Modify</button>
</form>


      </div>
    </div>
  </div>


  <div class="col-md-3">  </div>


</div>

 
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

             
<!-- Loading (remove the following to stop the loading)-->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             


<footer class="footer ">
<div class="container-fluid">

<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<div class="text-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</div>
</div>
</footer>
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
    </script>

  </body>
</html>