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
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
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
<section class="content-header">
  <h1>
    Reports
 <small>PMS</small>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Reports</a></li>
    <li class="active">PMS</li>
  </ol>
</section>


  <!-- Main content -->
   <div class="col-sm-4">
      <div class="box box-solid box-success">
        <div class="box-header">
        <h5 class="box-title"><i class='fa fa-calendar'></i> <span>Time Reports</span></h5>
       </div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">

<ul class="nav nav-pills nav-stacked">  
<li class="bg-success">Forms Format</li>
  <li>
    <a target="_blank" style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" href="<?php echo base_url().'app/report_pms/excel_general_forms2';?>"><i class='fa fa-calendar'></i> <span>Export to Excel General Forms</span>
    </a>
  <!--   <a target="_blank" style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" href="<?php echo base_url().'app/report_pms/testExcelStyle';?>"><i class='fa fa-calendar'></i> <span>Test Excel Style</span>
    </a> -->
  </li>
</ul>
<ul class="nav nav-pills nav-stacked">  
<li class="bg-success">Evaluation</li>
  <li>
    <a target="_blank" style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="get_all_evaluation('pending');"><i class='fa fa-calendar'></i> <span> Pending  </span>
    </a>
    <a target="_blank" style="width:98%;margin-left:1px;text-align:left;cursor: pointer;"  onclick="get_all_evaluation('evaluated');"><i class='fa fa-calendar'></i> <span> Evaluated </span>
    </a>
  </li>
</ul>
<ul class="nav nav-pills nav-stacked">  
<li class="bg-success">Approval</li>
  <li>
    <a target="_blank" style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="get_all_approval('pending');"><i class='fa fa-calendar'></i> <span>Pending</span>
    </a>
    <a target="_blank" style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="get_all_approval('approved');"><i class='fa fa-calendar'></i> <span>Approved </span>
    </a>
  </li>
</ul>
<ul class="nav nav-pills nav-stacked">  
<li class="bg-success">All Appraisal</li>
  <li>
    <a target="_blank" style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="view_all();"><i class='fa fa-calendar'></i> <span> View All  </span>
    </a>

    </a>
  </li>
</ul>
<ul class="nav nav-pills nav-stacked">  
<li class="bg-success">recommendation</li>
  <li>
    <a target="_blank" style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="recommendation();"><i class='fa fa-calendar'></i> <span> recommendation  </span>
    </a>

    </a>
  </li>
</ul>
        </div>
      </div>
  </div>


  <!-- Main content -->
  <div class="col-md-8" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result" style="height:auto;overflow:scroll;"><br>
              <div style="height:600px;">
		
				
              </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div>    
  <canvas id="myChart"></canvas>	  
    </div> 
	  
  </div> 


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
	 <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>  
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>


    <!-- DataTables -->

    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script><script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	<script src="<?php echo base_url()?>public/plugins/chartjs/chart1.js"></script>  

    <script type="text/javascript">
 var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 10, 5, 2, 20, 30, 45]
        }]
    },

    // Configuration options go here
    options: {}
});

function get_all_evaluation($val){

        $.ajax({
            url: "<?php echo base_url();?>app/report_pms/get_evaluate_reports/"+$val,
			type: 'POST',
            success: function(data){
           
              $('#fetch_all_result').html(data);
            }
        });
      
	}
	function get_all_approval($val){

        $.ajax({
            url: "<?php echo base_url();?>app/report_pms/get_approval_reports/"+$val,
			type: 'POST',
            success: function(data){
           
              $('#fetch_all_result').html(data);
            }
        });
      
	}
    function view_all(){

        $.ajax({
            url: "<?php echo base_url();?>app/report_pms/get_all_reports/",
      type: 'POST',
            success: function(data){
           
              $('#fetch_all_result').html(data);
            }
        });
      
  }
      function recommendation(){

        $.ajax({
            url: "<?php echo base_url();?>app/report_pms/recommendation/",
      type: 'POST',
            success: function(data){
           
              $('#fetch_all_result').html(data);
            }
        });
      
  }



    </script>

  </body>
</html>