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

              <form action="<?php echo base_url()?>app/report_analytics/get_employee_count_region" method="post" id="get_employee_count">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Region</label>
                    <select name="region[]" id="region" class="selectpicker" data-live-search="true" data-width="100%" data-style="btn-default" multiple>
                      <?php foreach ($regionList as $region): ?>
                          <option value="<?php echo $region->region_id ?>"><?php echo $region->region_name ?></option>
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
                  <label for=""></label>
                  <button type="submit" class="btn btn-warning btn-block" id="btnFilter"><i class="fa fa-filter"></i> Filter</button>
                </div>
                <!-- col-md-4 -->
              </div>
              <!-- row -->
            </form>
            <div id="filtered_chart">
            <canvas id="myChart"></canvas>
            <!-- <canvas id="bar-chart-grouped"></canvas> -->
            
            <table class="table table-hover table-responsive table-bordered">
              <thead>
                <tr class="info">
                  <td><strong>Region Name</strong></td>
                  <td align="center"><strong>Employee Count</strong></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($this->input->post("region") as $key => $r_id): 
                  $reg = $this->report_analytics_model->get_region_details($r_id);
                ?>
                <tr>
                  <td><?php echo $reg->region_name ?></td>
                  <?php
                    $ci = & get_instance();
                    $ci->load->model("app/report_analytics_model");
                    $count_filter = $ci->report_analytics_model->get_region_filtered($reg->region_id);?>
                    <td align="center"><?php echo $count_filter; ?></td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>

                 <script>
                var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: <?php echo "'".$chart_type."'";?>,
                    data: {
                        labels: [<?php $countby = ""; $id="";
                        foreach ($this->input->post("region") as $key => $region_id) {

                          $region1 = $this->report_analytics_model->get_region_details($region_id);
                          $viewby = $region1->region_name;

                          echo "'".$viewby."', "; } ?>],
                        datasets: [
                        {
                            label: "No. of Employees",
                            data: [
                            <?php  $b = 1;
                              foreach ($this->input->post("region") as $key => $region_id2) {
                                $ci = & get_instance();
                                $ci->load->model("app/report_analytics_model");
                                $region_count = $this->report_analytics_model->get_region_count($region_id2);

                              echo $region_count.",";
                              $b++;}
                             ?>
                            ],
                            backgroundColor: [
                                <?php $c = 1; $b=$b-1;
                                while($c <= $b){
                                  echo "'rgba(".rand(0,359).",".rand(0,359).",".rand(0,359).",1)', ";
                                $c++;}?>
                            ]
                        }
                        ]
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