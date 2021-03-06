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
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
	
	<!-- <script src="<?php echo base_url()?>public/js/angular.js"></script> -->
	<script src="<?php echo base_url()?>public/js/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/js/jquery-1.12.2.js"></script>

    <style>
    	.login-bg{
    		background-image: url('<?php echo base_url()?>/public/img/login-bg/bg_2.jpg');
    		background-size: 100%;
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
    </style>

</head>
<body class="login-bg" ng-app="">

<div class="row">
	<div class="col-md-4">
    
	</div>
<div class="col-md-4">
</div>

	<div class="col-md-4">
		<div class="panel panel-primary" style="margin:5px;">
			<div class="panel-heading">
				<h2 class="panel-title">
                    Sert Technology Login
                    <span class="pull-right">
                        <!-- Time auto generated by js -->
                    </span><!-- /.headline --> 
                </h2>
			</div>
			<div class="panel-body bg-info">
            <?php echo validation_errors()?> 
			<form name="loginForm" action="<?php echo base_url()?>serttech/serttech_login/validate_login" method="post" novalidate>
                <input type="hidden" name="nbd" value="<?php echo $nbd;?>">
				<div class="form-group">
				  <label for="username">User ID</label>
				<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
				   <!-- <span class="pull-right text-danger" ng-show="loginForm.user_id.$error.required">User ID is required.</span> -->
				  <input type="username" class="form-control" id="username" placeholder="User ID" ng-model="username" name="username" required>
				</div>
				</div>
				<div class="form-group">
				  <label for="Password">Password</label>
				<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-key fa-lg"></i></div>
				  <input type="password" class="form-control" id="Password" placeholder="Password" name="password">
				</div>
				</div>
				<button class="btn btn-primary pull-left" ><i class="fa fa-sign-in fa-lg"></i> Login</button>
			</form>       
			</div>

		</div>
	</div>
</div>



</body>
</html>


<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js.js"></script>