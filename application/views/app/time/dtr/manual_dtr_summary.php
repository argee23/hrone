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

    <style type="text/css">
    	.mdis{
    		width:80px !important;
    	}

    </style>
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
    Time
     <small>Daily Time Record</small>
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li >Time</li>
    <li >Daily Time Record</li>
    <li class="active">Manual DTR Summary</li>
  </ol>
</section>
  <!-- Main content -->
  <section class="content">

<div class="row">

  <div class="col-md-12"> 
   <!-- id="example1"  -->

  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_dtr/save_manual_dtr_summary/" target="_blank">

                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Emp. ID</th>
                        <th>Name</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
if(!empty($employee)){

$column_help_start='<small><i class="fa fa-question" title="';
$column_help_end='"> Help</i></small>';
	foreach($employee as $e){
//$getmysalaryrate=$this->time_dtr_model->getSalary($e->salary_rate);
$getmysalaryrate=$this->time_dtr_model->getSalary($complete_from,$e->employee_id);
$mysummary=$this->time_dtr_model->get_processed_dtr_summary($e->company_id,$payroll_period_id,$e->employee_id,$pay_period_info->month_cover);

	if(!empty($getmysalaryrate)){
		$salary_rate_name=$getmysalaryrate->salary_rate_name;
		$salary_rate=$getmysalaryrate->salary_rate;
	}else{
		$salary_rate_name="No Salary";
		$salary_rate="4";
	}

	if(!empty($mysummary)){
		$with_saved_dtr=1;
		$is_manual_dtr=$mysummary->is_manual_dtr;
			if($is_manual_dtr==""){
				$is_manual_dtr=0;
			}else{

			}
	}else{
		$with_saved_dtr=0;
		$is_manual_dtr=1;
	}

$input_box_statuses="";// initialize variable

if($with_saved_dtr==1){
	
	if($is_manual_dtr=="1"){
		$dtr_summary_type_note="This dtr summary is manually encoded.";
	}else{
		$dtr_summary_type_note="This dtr summary is base on Automatic DTR Processing";
		$input_box_statuses='disabled style="background-color:#ff0000;color:#fff;" ';
	}
}else{
	$dtr_summary_type_note="No Saved DTR yet.";
}

		echo '
<tr>
	<td >'.$e->employee_id.'</td>
	<td  class="bg-primary">'.$e->name.'<span class="pull-right">Salary Rate: '.$salary_rate_name.'</span></td>
	<td  class="bg-primary">'.$dtr_summary_type_note.'</td>
</tr>
	<tr>
		<td colspan="2">
';

if($with_saved_dtr=="1"){// with saved dtr already

$total_regular_hours=$mysummary->total_regular_hours;
$total_regular_hrs_restday=$mysummary->total_regular_hrs_restday;
$total_regular_hrs_reg_holiday=$mysummary->total_regular_hrs_reg_holiday;
$total_regular_hrs_reg_holiday_t1=$mysummary->total_regular_hrs_reg_holiday_t1;
$total_regular_hrs_reg_holiday_t2=$mysummary->total_regular_hrs_reg_holiday_t2;
$total_regular_hrs_spec_holiday=$mysummary->total_regular_hrs_spec_holiday;
$total_restday_regular_hrs_spec_holiday=$mysummary->total_restday_regular_hrs_spec_holiday;

$total_regular_nd=$mysummary->total_regular_nd;
$total_restday_nd=$mysummary->total_restday_nd;
$total_reg_holiday_nd=$mysummary->total_reg_holiday_nd;
$total_restday_reg_holiday_nd=$mysummary->total_restday_reg_holiday_nd;
$total_spec_holiday_nd=$mysummary->total_spec_holiday_nd;
$total_restday_spec_holiday_nd=$mysummary->total_restday_spec_holiday_nd;

$total_regular_overtime=$mysummary->total_regular_overtime;
$total_restday_overtime=$mysummary->total_restday_overtime;
$total_reg_holiday_overtime=$mysummary->total_reg_holiday_overtime;
$total_restday_reg_holiday_overtime=$mysummary->total_restday_reg_holiday_overtime;
$total_spec_holiday_overtime=$mysummary->total_spec_holiday_overtime;
$total_restday_spec_holiday_overtime=$mysummary->total_restday_spec_holiday_overtime;

$total_regular_overtime_nd=$mysummary->total_regular_overtime_nd;
$total_restday_overtime_nd=$mysummary->total_restday_overtime_nd;
$total_reg_holiday_overtime_nd=$mysummary->total_reg_holiday_overtime_nd;
$total_restday_reg_holiday_overtime_nd=$mysummary->total_restday_reg_holiday_overtime_nd;
$total_spec_holiday_overtime_nd=$mysummary->total_spec_holiday_overtime_nd;
$total_restday_spec_holiday_overtime_nd=$mysummary->total_restday_spec_holiday_overtime_nd;

$complete_logs_present_occ=$mysummary->complete_logs_present_occ;
$with_tk_logs_present_occ=$mysummary->with_tk_logs_present_occ;
$with_ob_logs_present_occ=$mysummary->with_ob_logs_present_occ;
$with_leave_present_occ=$mysummary->with_leave_present_occ;
$restday_w_logs=$mysummary->restday_w_logs;
$restday_wo_logs=$mysummary->restday_wo_logs;
$reg_holiday_w_logs=$mysummary->reg_holiday_w_logs;
$reg_holiday_wo_logs=$mysummary->reg_holiday_wo_logs;
$rd_reg_holiday_w_logs=$mysummary->rd_reg_holiday_w_logs;
$rd_reg_holiday_wo_logs=$mysummary->rd_reg_holiday_wo_logs;
$snw_holiday_w_logs=$mysummary->snw_holiday_w_logs;
$snw_holiday_wo_logs=$mysummary->snw_holiday_wo_logs;
$rd_snw_holiday_w_logs=$mysummary->rd_snw_holiday_w_logs;
$rd_snw_holiday_wo_logs=$mysummary->rd_snw_holiday_wo_logs;

$absences_total=$mysummary->absences_total;
$undertime_total=$mysummary->undertime_total;
$tardiness_total=$mysummary->tardiness_total;
$overbreak_total=$mysummary->overbreak_total;
$absences_occurence=$mysummary->absences_occurence;
$undertime_occurence=$mysummary->undertime_occurence;
$tardiness_occurence=$mysummary->tardiness_occurence;
$overbreak_occurence=$mysummary->overbreak_occurence;


	if($is_manual_dtr=="0"){// the saved dtr is NOT from manual compute.

	}else{

	}
}else{

$total_regular_hours=0;
$total_regular_hrs_restday=0;
$total_regular_hrs_reg_holiday=0;
$total_regular_hrs_reg_holiday_t1=0;
$total_regular_hrs_reg_holiday_t2=0;
$total_regular_hrs_spec_holiday=0;
$total_restday_regular_hrs_spec_holiday=0;

$total_regular_nd=0;
$total_restday_nd=0;
$total_reg_holiday_nd=0;
$total_restday_reg_holiday_nd=0;
$total_spec_holiday_nd=0;
$total_restday_spec_holiday_nd=0;

$total_regular_overtime=0;
$total_restday_overtime=0;
$total_reg_holiday_overtime=0;
$total_restday_reg_holiday_overtime=0;
$total_spec_holiday_overtime=0;
$total_restday_spec_holiday_overtime=0;

$total_regular_overtime_nd=0;
$total_restday_overtime_nd=0;
$total_reg_holiday_overtime_nd=0;
$total_restday_reg_holiday_overtime_nd=0;
$total_spec_holiday_overtime_nd=0;
$total_restday_spec_holiday_overtime_nd=0;

$complete_logs_present_occ=0;
$with_tk_logs_present_occ=0;
$with_ob_logs_present_occ=0;
$with_leave_present_occ=0;
$restday_w_logs=0;
$restday_wo_logs=0;
$reg_holiday_w_logs=0;
$reg_holiday_wo_logs=0;
$rd_reg_holiday_w_logs=0;
$rd_reg_holiday_wo_logs=0;
$snw_holiday_w_logs=0;
$snw_holiday_wo_logs=0;
$rd_snw_holiday_w_logs=0;
$rd_snw_holiday_wo_logs=0;

$absences_total=0;
$undertime_total=0;
$tardiness_total=0;
$overbreak_total=0;
$absences_occurence=0;
$undertime_occurence=0;
$tardiness_occurence=0;
$overbreak_occurence=0;
}
?>


<table class="table table">
	<thead>
		<tr>
			<th>Description</th>
			<th>Regular</th>
			<th>Restday</th>
			<th>Regular Holiday</th>
			<th>Regular Holiday/Restday
			<div class="datagrid">
	<table  class="table table-bordered table-striped">
	<tr>
		<td><a id="reg_hol_rd_with_logs" title="Regular Holiday that falls on a restday WITH attendance">Type 1</a></td>
		<td><a id="reg_hol_rd" title="Regular Holiday that falls on a restday WITHOUT attendance">Type 2</a></td>
	</tr>
	</table>
	</div>

			</th>
			<th>Special Holiday</th>
			<th>Special Holiday/Restday</th>
			<th>Description</th>
			<th>Total</th>
			<th>Occurence</th>
		</tr>
	</thead>
	<tbody>
<!--//============================================TIME SUMMARY- REGULAR HOURS-->		
	<tr>
		<td>Regular</td>

		<td><?php echo $column_help_start.'Enter Regular Hours Work. For Monthly Rate Employees, Default is 104 or the setup value at  time > time settings >monthly salary rate - semi monthly pay type ( regular hours base )'.$column_help_end;?>
<input type="number" step="any" class="mdis form-control" name="total_regular_hours<?php echo $e->employee_id;?>" value="<?php echo $total_regular_hours;?>" <?php echo $input_box_statuses;?>>
		</td>

		<td><?php echo $column_help_start.'Enter Restday Regular Hours Work'.$column_help_end;?>
<input type="number" step="any" class="mdis form-control" name="total_regular_hrs_restday<?php echo $e->employee_id;?>" value="<?php echo $total_regular_hrs_restday;?>"
 <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_regular_hrs_reg_holiday<?php echo $e->employee_id;?>" value="<?php echo $total_regular_hrs_reg_holiday;?>" <?php echo $input_box_statuses;?>></td>
		<td>
	<table class="table table-bordered table-striped">
	<tr>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_regular_hrs_reg_holiday_t1<?php echo $e->employee_id;?>" value="<?php echo $total_regular_hrs_reg_holiday_t1;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_regular_hrs_reg_holiday_t2<?php echo $e->employee_id;?>" value="<?php echo $total_regular_hrs_reg_holiday_t2;?>" <?php echo $input_box_statuses;?>></td>
	</tr>
	</table>
		</td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_regular_hrs_spec_holiday<?php echo $e->employee_id;?>" value="<?php echo $total_regular_hrs_spec_holiday;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_regular_hrs_spec_holiday<?php echo $e->employee_id;?>" value="<?php echo $total_restday_regular_hrs_spec_holiday;?>" <?php echo $input_box_statuses;?>></td>
		<td>absences</td>		
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="absences_total<?php echo $e->employee_id;?>" value="<?php echo $absences_total;?>" <?php echo $input_box_statuses;?>></td>		
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="absences_occurence<?php echo $e->employee_id;?>" value="<?php echo $absences_occurence;?>" <?php echo $input_box_statuses;?>></td>		
	</tr>	
<!--//============================================TIME SUMMARY- REGULAR ND-->			
	<tr>
		<td>Regular-ND</td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_regular_nd<?php echo $e->employee_id;?>" value="<?php echo $total_regular_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_nd<?php echo $e->employee_id;?>" value="<?php echo $total_restday_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_reg_holiday_nd<?php echo $e->employee_id;?>" value="<?php echo $total_reg_holiday_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_reg_holiday_nd<?php echo $e->employee_id;?>" value="<?php echo $total_restday_reg_holiday_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td>&nbsp;</td>
	</tr>
	</table>
		</td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_spec_holiday_nd<?php echo $e->employee_id;?>" value="<?php echo $total_spec_holiday_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_spec_holiday_nd<?php echo $e->employee_id;?>" value="<?php echo $total_restday_spec_holiday_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td>undertime</td>		
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="undertime_total<?php echo $e->employee_id;?>" value="<?php echo $undertime_total;?>" <?php echo $input_box_statuses;?>></td>		
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="undertime_occurence<?php echo $e->employee_id;?>" value="<?php echo $undertime_occurence;?>" <?php echo $input_box_statuses;?>></td>		
	</tr>	
<!--//============================================TIME SUMMARY- OVERTIME-->			
	<tr>
		<td>OVERTIME</td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_regular_overtime<?php echo $e->employee_id;?>" value="<?php echo $total_regular_overtime;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_overtime<?php echo $e->employee_id;?>" value="<?php echo $total_restday_overtime;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_reg_holiday_overtime<?php echo $e->employee_id;?>" value="<?php echo $total_reg_holiday_overtime;?>" <?php echo $input_box_statuses;?>></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_reg_holiday_overtime<?php echo $e->employee_id;?>" value="<?php echo $total_restday_reg_holiday_overtime;?>" <?php echo $input_box_statuses;?>></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_spec_holiday_overtime<?php echo $e->employee_id;?>" value="<?php echo $total_spec_holiday_overtime;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_spec_holiday_overtime<?php echo $e->employee_id;?>" value="<?php echo $total_restday_spec_holiday_overtime;?>" <?php echo $input_box_statuses;?>></td>
		<td>tardiness</td>		
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="tardiness_total<?php echo $e->employee_id;?>" value="<?php echo $tardiness_total;?>" <?php echo $input_box_statuses;?>></td>		
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="tardiness_occurence<?php echo $e->employee_id;?>" value="<?php echo $tardiness_occurence;?>" <?php echo $input_box_statuses;?>></td>		
	</tr>	
<!--//============================================TIME SUMMARY- OVERTIME ND-->			
	<tr>
		<td>OVERTIME-ND</td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_regular_overtime_nd<?php echo $e->employee_id;?>" value="<?php echo $total_regular_overtime_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_overtime_nd<?php echo $e->employee_id;?>" value="<?php echo $total_restday_overtime_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_reg_holiday_overtime_nd<?php echo $e->employee_id;?>" value="<?php echo $total_reg_holiday_overtime_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td>
	<table   cellpadding="1" cellspacing="3">
	<tr>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_reg_holiday_overtime_nd<?php echo $e->employee_id;?>" value="<?php echo $total_restday_reg_holiday_overtime_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td></td>
	</tr>
	</table>
		</td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_spec_holiday_overtime_nd<?php echo $e->employee_id;?>" value="<?php echo $total_spec_holiday_overtime_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="total_restday_spec_holiday_overtime_nd<?php echo $e->employee_id;?>" value="<?php echo $total_restday_spec_holiday_overtime_nd;?>" <?php echo $input_box_statuses;?>></td>
		<td>overbreak</td>		
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="overbreak_total<?php echo $e->employee_id;?>" value="<?php echo $overbreak_total;?>" <?php echo $input_box_statuses;?>></td>		
		<td><?php echo $column_help_start.$column_help_end;?>
		<input type="number" step="any" class="mdis form-control" name="overbreak_occurence<?php echo $e->employee_id;?>" value="<?php echo $overbreak_occurence;?>" <?php echo $input_box_statuses;?>></td>		
	</tr>
	<tr>
		<td >Logs Root <i class="fa fa-question" title="You must fill this column(s) IF you have an automatic other addition that is attendance base. IF NOT you may ignore this column(s)">Help</i></td>
<td>
No Forms
<input type="number" step="any" class="mdis form-control" name="complete_logs_present_occ<?php echo $e->employee_id;?>" value="<?php echo $complete_logs_present_occ;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
With TK Form
<input type="number" step="any" class="mdis form-control" name="with_tk_logs_present_occ<?php echo $e->employee_id;?>" value="<?php echo $with_tk_logs_present_occ;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
With Official Business
<input type="number" step="any" class="mdis form-control" name="with_ob_logs_present_occ<?php echo $e->employee_id;?>" value="<?php echo $with_ob_logs_present_occ;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
With Leave Form
<input type="number" step="any" class="mdis form-control" name="with_leave_present_occ<?php echo $e->employee_id;?>" value="<?php echo $with_leave_present_occ;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
Restday with logs (& approved ot form)
<input type="number" step="any" class="mdis form-control" name="restday_w_logs<?php echo $e->employee_id;?>" value="<?php echo $restday_w_logs;?>" <?php echo $input_box_statuses;?>>
<td>
	</tr>	
<tr>
		<td >Logs Root <i class="fa fa-question" title="You must fill this column(s) IF you have an automatic other addition that is attendance base. IF NOT you may ignore this column(s)">Help</i></td>
<td>
Restday without logs
<input type="number" step="any" class="mdis form-control" name="restday_wo_logs<?php echo $e->employee_id;?>" value="<?php echo $restday_wo_logs;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
Regular Holiday with logs (& approved ot form)
<input type="number" step="any" class="mdis form-control" name="reg_holiday_w_logs<?php echo $e->employee_id;?>" value="<?php echo $reg_holiday_w_logs;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
Regular Holiday without logs
<input type="number" step="any" class="mdis form-control" name="reg_holiday_wo_logs<?php echo $e->employee_id;?>" value="<?php echo $reg_holiday_wo_logs;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
Restday - Regular Holiday with logs (& approved ot form)
<input type="number" step="any" class="mdis form-control" name="rd_reg_holiday_w_logs<?php echo $e->employee_id;?>" value="<?php echo $rd_reg_holiday_w_logs;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
Restday - Regular Holiday without logs
<input type="number" step="any" class="mdis form-control" name="rd_reg_holiday_wo_logs<?php echo $e->employee_id;?>" value="<?php echo $rd_reg_holiday_wo_logs;?>" <?php echo $input_box_statuses;?>>	
</td>
</tr>

<tr>
<td >Logs Root <i class="fa fa-question" title="You must fill this column(s) IF you have an automatic other addition that is attendance base. IF NOT you may ignore this column(s)">Help</i></td>
<td>
SNW Holiday with logs (& approved ot form)
<input type="number" step="any" class="mdis form-control" name="snw_holiday_w_logs<?php echo $e->employee_id;?>" value="<?php echo $snw_holiday_w_logs;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
SNW Holiday without logs
<input type="number" step="any" class="mdis form-control" name="snw_holiday_wo_logs<?php echo $e->employee_id;?>" value="<?php echo $snw_holiday_wo_logs;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
Restday - SNW Holiday with logs (& approved ot form)
<input type="number" step="any" class="mdis form-control" name="rd_snw_holiday_w_logs<?php echo $e->employee_id;?>" value="<?php echo $rd_snw_holiday_w_logs;?>" <?php echo $input_box_statuses;?>>
</td>
<td>
Restday - SNW Holiday without logs
<input type="number" step="any" class="mdis form-control" name="rd_snw_holiday_wo_logs<?php echo $e->employee_id;?>" value="<?php echo $rd_snw_holiday_wo_logs;?>" <?php echo $input_box_statuses;?>>
</td>
</tr>

</tbody>
</table>

<input type="hidden" name="pay_type<?php echo $e->employee_id;?>" value="<?php echo $e->pay_type;?>">
<input type="hidden" name="salary_rate<?php echo $e->employee_id;?>" value="<?php echo $salary_rate;?>">
<input type="hidden" name="with_saved_dtr<?php echo $e->employee_id;?>" value="<?php echo $with_saved_dtr;?>">
<input type="hidden" name="is_manual_dtr<?php echo $e->employee_id;?>" value="<?php echo $is_manual_dtr;?>">


<?php
echo'
		</td>
	</tr>
		';
	}
}else{

}


?>



                    </tbody>
                  </table>



<input type="hidden" name="company_id" value="<?php echo $company_id;?>">
<input type="hidden" name="comp_division_setting" value="<?php echo $comp_division_setting;?>">
<input type="hidden" name="sub_sec_setting" value="<?php echo $sub_sec_setting;?>">
<input type="hidden" name="pay_type_group" value="<?php echo $pay_type_group;?>">
<input type="hidden" name="selected_individual_employee_id" value="<?php echo $selected_individual_employee_id;?>">
<input type="hidden" name="payroll_period_id" value="<?php echo $payroll_period_id;?>">
<input type="hidden" name="month_cover" value="<?php echo $pay_period_info->month_cover;?>">

<!-- // start pass array values on filtering-->
<input type="hidden" name="check_employee_division" value="<?php echo $check_employee_division;?>">
<input type="hidden" name="check_employee_dept" value="<?php echo $check_employee_dept;?>">
<input type="hidden" name="check_employee_sect" value="<?php echo $check_employee_sect;?>">
<input type="hidden" name="check_employee_sub_section" value="<?php echo $check_employee_sub_section;?>">

<input type="hidden" name="selected_locations" value="<?php echo $selected_locations;?>">
<input type="hidden" name="selected_classifications" value="<?php echo $selected_classifications;?>">
<input type="hidden" name="selected_employments" value="<?php echo $selected_employments;?>">
<input type="hidden" name="check_employee_status" value="<?php echo $check_employee_status;?>">
<!-- // end pass array values on filtering-->



 <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-arrow-right"></i> Generate</button>

                  </form>
 </div>




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



	<?php


// $ds=$this->time_dtr_model->get_processed_dtr_summary($company_id,$pay_period,$employee_id,$month_cover);
// if(!empty($ds)){
// 	$dtr_status="Processed";
// 	$dtr_status_class='style="color:#000 !important;"';
// 	$absences_total=$ds->absences_total;
// 	$total_process++;
// }else{
// 	$dtr_status="Not Yet Processed";
// 	$absences_total="";
// 	$dtr_status_class='style="color:#ff0000 !important;"';
// 	$total_unprocess++;
// }

// 	echo '
// 		<tr >
// 			<td width="10%" '.$dtr_status_class.'>'.$employee_id.'</td>
// 			<td width="20%" '.$dtr_status_class.'>'.$name.'</td>
// 			<td width="10%" '.$dtr_status_class.'>'.$dtr_status.'</td>
		
// 		</tr>

// 	';
	//<th width="5%">'.$absences_total.'</th>
	?>

