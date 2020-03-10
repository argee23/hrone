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
    <!-- Vex -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <!-- ChartJS -->
    <script src="<?php echo base_url()?>public/chartjs/Chart.min.js"></script>
    <script src="<?php echo base_url()?>public/chartjs/moment.js"></script>
    <script>
       //  window.onload = function() {
       //   <?php echo $onload ?>; 
       // };
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
    Employee 201 Analytics
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Reports</li>
    <li>Analytics</li>
    <li class="active">Employee 201</li>
  </ol>
</section>
  <!-- Main content -->
  <section class="content">

  <div class="box box-default">
    <div class="box-body">
      <div class="row">
        <div class="col-md-3">
          <?php require_once(APPPATH.'views/app/report_analytics/analytics_sidebar.php'); ?>
        </div>
        <!-- col-md-4 -->

        <div class="col-md-9">
          <div class="box box-danger">
            <div class="box-header">
              
            </div>
            <div class="box-body">

              <form action="<?php echo base_url()?>app/report_analytics/get_employee_count" method="post" id="get_employee_count">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Company</label>
                    <select name="company[]" id="company" class="selectpicker" data-live-search="true" data-width="100%" data-style="btn-default" multiple>
                      <?php foreach ($companyList as $company): ?>
                        <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <!-- col-md-4 -->

                <div class="col-md-4">
                  <label for="">Chart Type:</label>
                  <select name="chart_type" id="chart_type" data-width="100%" class="selectpicker">
                    <option value="bar">Bar</option>
                    <option value="line">Line</option>
                  </select>
                </div>
                <!-- col-md-4 -->
                <div class="col-md-4">
                  <label for="">Action</label>
                  <button type="submit" class="btn btn-warning btn-block" id="btnFilter"><i class="fa fa-filter"></i> Filter</button>
                </div>
                <!-- col-md-4 -->
              </div>
              <!-- row -->
            </form>
            <div id="filtered_chart">
            <canvas id="myChart"></canvas>

            <table class="table table-hover table-responsive table-condensed table-bordered">
              <thead>
                <tr class = "info">
                  <td><strong>Company Name</strong></td>
                  <td align="center"><strong>No. of Employees</strong></td>
                </tr>
              </thead>
              <tbody>
                <?php $count_filter=0; $total_count=0; foreach ($this->input->post("company") as $key => $company_id):

                   $ec = $this->general_model->get_company_info($company_id);
                ?>
                  <tr>
                    <td><?php echo ucwords($ec->company_name)?></td>
                    <?php                       
                        $ci = & get_instance();
                        $ci->load->model("app/report_analytics_model");
                        $count_filter = $ci->report_analytics_model->company_count($company_id);
                     ?>
                    <td align="center"><?php echo $count_filter ?></td>
                  </tr>
                <?php $total_count = $total_count + $count_filter; $count_filter++; endforeach ?>
                <tr>
                  <td align="right"><strong>TOTAL</strong></td>
                  <td class="danger" align="center"><strong><?php echo $total_count ?></strong></td>
                </tr>
              </tbody>
            </table>

                <script>
                var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: <?php echo "'".$this->input->post("chart_type")."'";?>,
                    data: {
                        labels: [
                          <?php 
                            foreach ($this->input->post("company") as $key => $company_id) {

                              $company = $this->general_model->get_company_info($company_id);

                              echo "'".$company->company_name."', "; 
                          }?>
                          ],
                        datasets: [{
                            label: "No. of Employees",
                            data: [
                            <?php  $b = 1;
                            foreach ($this->input->post("company") as $key => $co) {
                              $ci = & get_instance();
                              $ci->load->model("app/report_analytics_model");
                              $count_company = $ci->report_analytics_model->company_count($co);

                            echo $count_company.",";
                            $b++;}
                             ?>
                            ],
                            backgroundColor: [
                                <?php $c = 1; $b=$b-1;
                                while($c <= $b){
                                  echo "'rgba(".rand(0,359).",".rand(0,359).",".rand(0,359).",1)', ";
                                $c++;}?>
                            ]
                        }]
                    },
                    options: {
                      scales: {
                        xAxes: [{
                            stacked: false,
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                min: 0,
                                autoSkip: false
                            }
                        }]
                    }
                  }
                });
                </script>
            </div>
              
            </div>
            <!-- box-body -->
          </div>
          <!-- box -->
        </div>
        <!-- col-md-8 -->
      </div>
      <!-- row -->
    </div>
    <!-- box-body -->
  </div>
  <!-- box -->
 
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<footer class="footer ">
<div class="container-fluid">
<br>
<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
</div>
</footer>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- Bootstrap Select -->
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Vex -->
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>

    <script>

    $( function(){

      $('.selectpicker').selectpicker({
        // style: 'btn-info',
        // size: 4
      });

    });
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>

  </body>
</html>