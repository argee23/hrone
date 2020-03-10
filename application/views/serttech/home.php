<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My HRIS- Serttech<?php //echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">

            <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header_serttech.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar_serttech.php');?>

<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    System Management
    <small>Administrator panel </small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">System Management</li>
  </ol>
</section>

<section class="content">
  <div class="row">



     <!-- ==================================================================== -->
                 <div class="col-md-12">
                    <?php echo $message;?>
              <?php echo validation_errors(); ?>

              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <li class="active"><a href="#admin_module_mng" data-toggle="tab">
                  	<i class="fa fa-dashboard text-danger"></i> Module Management</a>
                </li>
                <li><a href="#admin_emp_license" data-toggle="tab">
                    <i class="fa fa-info-circle text-danger"></i> Employee License</a>
                </li>
                <li><a href="#admin_comp_license" data-toggle="tab">
                  	<i class="fa fa-info-circle text-danger"></i> Company License</a>
                </li>
                <li><a href="#admin_nbd" data-toggle="tab">
                    <i class="fa fa-cog text-danger"></i> MAC Address</a>
                </li>
 
                <li><a href="#admin_account" data-toggle="tab">
                	<i class="fa fa-user text-success"></i> My Account</a>
                </li>
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="admin_module_mng">
                  <ul class="products-list product-list-in-box">
                 <li class="item">
<?php
$mypages=$this->serttech_login_model->getSidebar();
if(!empty($mypages)){
	foreach($mypages as $mod){
		echo ' <div class="col-md-4">
<div style="background-color:#D9F3FB;border-left:5px solid #0C42EC;" class="callout">
               <div style="background-color:#D9F3FB;text-align:center;font-weight:bold;" class=""> <p class="text-danger">'.$mod->sidebar.'</p></div>
		';
		$sidebar_link = $this->serttech_login_model->get_sidebar_link($mod->sidebar);
		if(!empty($sidebar_link)){

			foreach($sidebar_link as $link){
if ($link->InActive=="0"){
	$color="text-danger";
	$todo="disable_feature";

}elseif($link->InActive=="1"){
	$color="text-success";
	$todo="enable_feature";

}else{

}

			echo $link->sys_mng_name. '<a href="'.base_url().'serttech/serttech_login/'.$todo.'/'.$link->page_module.'"  title="Click to hide '.$link->sys_mng_name.' " ><i class="fa fa-power-off '.$color.' pull-right"></i></a>'.'<br>';

			}

		}else{

		}
?>
     
              
              </div>
      </div>
<?php
	}
}else{
	echo "No modules yet.";
}




 ?>

                    </li><!-- /.item -->
               </ul>
                  </div><!-- /.tab-pane -->

<div class="tab-pane" id="admin_emp_license">
<ul class="products-list product-list-in-box">

<li class="item">
<div class="col-md-6">

<form name="loginForm" action="<?php echo base_url()?>serttech/serttech_login/employee_license" method="post" novalidate>
<?php
if(!empty($my_emp_license)){
$mylicense= $my_emp_license->myhris;
}else{
$mylicense="";
}
?>

<div class="form-group">
<label for="employee_license">Employee License</label>
<div class="input-group">
<div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
<input type="number" class="form-control" id="employee_license" placeholder="Employee License" ng-model="emp_license" name="employee_license" required value="<?php echo $mylicense;?>">
</div>
</div>

<button class="btn btn-primary pull-left" ><i class="fa fa-sign-in fa-lg"></i> Save</button>
</form>     

</div><!-- /.col -->
</li><!-- /.item -->

</ul>
</div><!-- /.tab-pane -->


<div class="tab-pane" id="admin_comp_license">
<ul class="products-list product-list-in-box">

<li class="item">
<div class="col-md-6">

<form name="loginForm" action="<?php echo base_url()?>serttech/serttech_login/company_license" method="post" novalidate>
<?php
if(!empty($my_emp_license)){
$my_complicense= $my_emp_license->myhris_c;
}else{
$my_complicense="";
}
?>

<div class="form-group">
<label for="employee_license">Company License</label>
<div class="input-group">
<div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
<input type="number" class="form-control" id="company_license" placeholder="Company License" ng-model="emp_license" name="company_license" required value="<?php echo $my_complicense;?>">
</div>
</div>

<button class="btn btn-primary pull-left" ><i class="fa fa-sign-in fa-lg"></i> Save</button>
</form>     

</div><!-- /.col -->
</li><!-- /.item -->

</ul>
</div><!-- /.tab-pane -->




<!-- //============= -->
                  <div class="tab-pane" id="admin_nbd">
                     <ul class="products-list product-list-in-box">

                    <li class="item">
                       <div class="col-md-6">
              <div class="">
        

                <a href="<?php echo base_url()?>nbd" target="_blank" class="btn btn-info" role="button">
<i class="fa fa-arrow-right"></i>
                Register Mac Address</a>
              </div>

            </div><!-- /.col -->
                    </li><!-- /.item -->

                  </ul>
                  </div><!-- /.tab-pane -->
<!-- //============= -->


                  <div class="tab-pane" id="admin_account">
                     <ul class="products-list product-list-in-box">

                    <li class="item">
                       <div class="col-md-6">

            <form name="loginForm" action="<?php echo base_url()?>serttech/serttech_login/serttech_account" method="post" novalidate>

				<div class="form-group">
				  <label for="username">Username</label>
				<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-user fa-lg"></i></div>
				  <input type="username" class="form-control" id="username" placeholder="username" ng-model="username" name="username" required value="<?php echo $serttech_account->username;?>">
				</div>
				</div>
				<div class="form-group">
				  <label for="password">Password</label>
				<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-key fa-lg"></i></div>
				  <input type="password" class="form-control" id="password" placeholder="password" ng-model="password" name="password" required value="<?php echo $serttech_account->myhris;?>" title="<?php echo $serttech_account->myhris;?>">
				</div>
				</div>

				<button class="btn btn-primary pull-left" ><i class="fa fa-sign-in fa-lg"></i> Save</button>
			</form>     

            </div><!-- /.col -->
                    </li><!-- /.item -->

                  </ul>
                  </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->






          <!-- ============================================================= --> 


  </div>
</section>
</div>


 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->

  <!-- Placed at the end of the document so the pages load faster --> 
<script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script> 
<script src="<?php echo base_url()?>public/app.min.js"></script> 
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url()?>public/chartjs/Chart.js"></script>
<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>

  