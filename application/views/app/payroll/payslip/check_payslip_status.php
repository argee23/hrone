<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
   
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

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Payroll
    <small>Generate Payslip</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo base_url()?>app/payroll_generate_payslip/index">Payroll</a></li>
    <li>Generate Payslip</li>
    <li class="active">Check Payslip Status</li>
  </ol>
</section>

<section class="content">

<div class="row">
<div class="table-responsive">


<?php
if(!empty($employee)){
?>
  <table  class="table table">
  <thead>
  	<tr>
  		<th>Employee ID</th>
  		<th>Name</th>
  		<th>Payroll Status</th>
  	</tr>
  </thead>
  <tbody>
<?php
	$total_posted=0;
	$total_not_posted=0;

	foreach($employee as $e){
	$JustCheckPayslipStat=$this->payroll_generate_payslip_model->JustCheckPayslipStat($payroll_period_id,$e->company_id,$e->employee_id,$mc);

	if(!empty($JustCheckPayslipStat)){
		$payslip_stat="POSTED";
		$payslip_stat_class='class="bg-primary"';
		$total_posted++;
	}else{
		$payslip_stat="NOT YET POSTED";
		$total_not_posted++;
		$payslip_stat_class='class="bg-danger"';
	}
echo '
	<tr>
		<td>'.$e->employee_id.'</td>
		<td>'.$e->name.'</td>
		<td '.$payslip_stat_class.'>'.$payslip_stat.'</td>
	</tr>
';

	}
	echo '
	<tr>
	<td colspan="3" class="bg-primary">Total Posted: '.$total_posted.'</td>
	</tr>
	<tr>
	<td colspan="3" class="bg-danger">Total Not Yet Posted: '.$total_not_posted.'</td>
	</tr>
	';

?>
</tbody>
</table>

<?php
}else{

}

?>
	
</div>
</div>


</section>
</body>

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
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>

    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>


    <script type="text/javascript">

      $(function () {
        $("#example1").DataTable();
      });
    </script>

  </body>
</html>
