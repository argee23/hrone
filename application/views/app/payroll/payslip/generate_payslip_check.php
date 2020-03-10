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
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

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
    <li class="active">Generate Payslip</li>
  </ol>
</section>

<section class="content">
 <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Payroll Period Group</th>
            <th>Active Compensation</th>
        </tr>
    </thead>

    <tbody>
<?php
$total_no_compen=0;
$total_with_compen=0;

$total_no_group=0;
$total_with_group=0;

$company_id=$this->uri->segment("4");
if(!empty($check_employee_list)){
    foreach($check_employee_list as $emp){
        $employee_id=$emp->employee_id;
            $check_payroll_group=$this->payroll_generate_payslip_model->check_employee_list_payroll_period($company_id,$employee_id);
                if(!empty($check_payroll_group)){
                    $payroll_period_group_name=$check_payroll_group->group_name;
                    $payroll_period_group_name_check='<i class="fa fa-check-square"></i>';
                    $total_with_group++;
                }else{
                    $payroll_period_group_name="";
                    $payroll_period_group_name_check='<i class="fa fa-remove text-danger"></i>';
                    $total_no_group++;
                }

             $check_compensation=$this->payroll_generate_payslip_model->check_employee_list_compensation($company_id,$employee_id);
                if(!empty($check_compensation)){
                    $salary_rate=$check_compensation->salary_rate_name.' , date effective: ';
                    $salary_rate_effective=$check_compensation->date_effective;
                    $salary_rate_check='<i class="fa fa-check-square"></i>';
                    $total_with_compen++;
                }else{
                    $salary_rate="";
                    $salary_rate_effective="";
                    $salary_rate_check='<i class="fa fa-remove text-danger"></i>';
                    $total_no_compen++;
                }
    echo 
    '
            <tr>
                <td>'.$employee_id.'</td>
                <td>'.$emp->fullname.'</td>
                <td>'.$payroll_period_group_name_check." ".$payroll_period_group_name.'</td>
                <td>'.$salary_rate_check." ".$salary_rate.$salary_rate_effective.'</td>
            </tr>

    ';


    }
}else{


}
?>


    </tbody>

</table>

<?php 
echo '<div class="col-md-12" style="height:200px;">

<button class="btn btn-success col-md-6">Active Employees With Compensation: '.$total_with_compen.'</button>
<button class="btn btn-danger col-md-6">Active Employees Without Compensation: '.$total_no_compen.'</button>

<button class="btn btn-primary col-md-6">Active Employees With Payroll Period Group: '.$total_with_group.'</button>
<button class="btn btn-warning col-md-6">Active Employees Without Payroll Period Group: '.$total_no_group.'</button>

</div>';


?>

</section>

 <?php require_once(APPPATH.'views/include/footer.php');?>
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

    <script>
        

      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();
      });
    </script>

  </body>
</html>