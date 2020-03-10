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
          <div class="box box-primary box-solid">
            <div class="box-header">
              <h4 class="box-title"><a href="#quickview" data-toggle="collapse">Quick View</a></h4>
            </div>
            <div class="box-body" id="quickview">
              <div class="row">
                <!-- <div class="col-md-12">
                  <label for="">Company</label>
                  <div class="form-group">
                    <select name="company[]" id="company" class="selectpicker" data-live-search="true" data-width="100%" data-style="btn-primary" multiple>
                      <?php foreach ($companyList as $company): ?>
                        <option value="<?php echo $company->company_id ?>"><?php echo $company->company_name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div> -->
                <!-- end col-md-12 -->
              </div>
              <!-- end row -->
              <a href="<?php echo base_url()?>app/report_analytics/load_ec_chart"><h4>Employee Count</h4></a>
            </div>
            <!-- box-body -->
            <div class="box-footer">
              <!-- <button class="btn btn-lg btn-default btn-block" id="btnView">Submit</button> -->
            </div>
          </div>
          <!-- box -->
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
                  <div class="form-group">
                    <label for="">Location</label>
                    <select name="location[]" id="location" class="selectpicker" data-live-search="true" data-width="100%" data-style="btn-default" multiple>
                      <?php foreach ($locationList as $location): ?>
                        <option value="<?php echo $location->location_id ?>"><?php echo $location->location_name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <!-- col-md-4 -->
              </div>
              <!-- row -->

              <div class="row">

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Department</label>
                    <select name="department[]" id="department" class="selectpicker" data-live-search="true" data-width="100%" data-style="btn-default" multiple>
                      <?php foreach ($company_department as $com_dept): ?>
                        <optgroup label="<?php echo $com_dept->company_name ?>">
                          <?php  
                          $comdeptList = $this->general_model->comdeptList($com_dept->company_id);
                          foreach ($comdeptList as $department): ?>
                            <option value="<?php echo $department->department_id ?>"><?php echo $department->dept_name ?></option>
                          <?php endforeach ?>
                        </optgroup>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <!-- col-md-3 -->

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Division</label>
                    <select name="division[]" id="division" class="selectpicker" data-live-search="true" data-width="100%" data-style="btn-default" multiple>
                      <?php foreach ($company_division as $com_div): ?>
                        <optgroup label="<?php echo $com_div->company_name ?>">
                          <?php  
                          $comdivList = $this->general_model->comdivtList($com_div->company_id);
                          foreach ($comdivList as $division): ?>
                            <option value="<?php echo $division->division_id ?>"><?php echo $division->division_name ?></option>
                          <?php endforeach ?>
                        </optgroup>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <!-- col-md-3 -->

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Section</label>
                    <select name="section[]" id="section" class="selectpicker" data-live-search="true" data-width="100%" data-style="btn-default" multiple>
                      <?php foreach ($department_section as $dept_sect): ?>
                        <optgroup label="<?php echo $dept_sect->dept_name ?>">
                          <?php  
                          $deptsectList = $this->general_model->deptsectList($dept_sect->department_id);
                          foreach ($deptsectList as $section): ?>
                            <option value="<?php echo $section->section_id ?>"><?php echo $section->section_name ?></option>
                          <?php endforeach ?>
                        </optgroup>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <!-- col-md-3 -->

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Sub-section</label>
                    <select name="subsection[]" id="subsection" class="selectpicker" data-live-search="true" data-width="100%" data-style="btn-default" multiple>
                      <?php foreach ($section_subsection as $sect_subsect): ?>
                        <optgroup label="<?php echo $sect_subsect->section_name ?>">
                          <?php  
                          $sectsubList = $this->general_model->sectsubList($sect_subsect->section_id);
                          foreach ($sectsubList as $subsection): ?>
                            <option value="<?php echo $subsection->subsection_id ?>"><?php echo $subsection->subsection_name ?></option>
                          <?php endforeach ?>
                        </optgroup>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <!-- col-md-3 -->
              </div>
              <!-- row -->
              
              <div class="row">
                <div class="col-md-4">
                  <label for="">View by:</label>
                  <select name="view_by" id="view_by" data-width="100%" class="selectpicker">
                    <option value="A.company_id">per Company</option>
                    <option value="A.region">per Region</option>
                    <option value="A.location">per Location</option>
                    <option value="A.department">per Department</option>
                    <option value="A.division_id">per Sub-department</option>
                    <option value="A.section">per Section</option>
                    <option value="A.subsection">per Sub-section</option>
                  </select>
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

            <table class="table table-hover table-responsive table-condensed table-bordered">
              <thead>
                <tr class = "info">
                  <td><strong>Company Name</strong></td>
                  <td align="center"><strong>No. of Employees</strong></td>
                </tr>
              </thead>
              <tbody>
                <?php $count_filter=0; $total_count=0; foreach ($companyList as $ec): ?>
                  <tr>
                    <td><?php echo ucwords($ec->company_name)?></td>
                    <?php                       
                        $ci = & get_instance();
                        $ci->load->model("app/report_analytics_model");
                        $count_filter = $ci->report_analytics_model->company_count($ec->company_id);
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
                    type: 'bar',
                    data: {
                        labels: [<?php foreach ($companyList as $company) { echo "'".$company->company_name."', "; }?>],
                        datasets: [{
                            label: "No. of Employees",
                            data: [
                            <?php  $b = 1;
                            foreach ($companyList as $co) {
                              $ci = & get_instance();
                              $ci->load->model("app/report_analytics_model");
                              $count_company = $ci->report_analytics_model->company_count($co->company_id);

                            echo $count_company.",";
                            $b++;}
                             ?>
                            ],
                            // backgroundColor: [
                            //     <?php $c = 1; $b=$b-1;
                            //     while($c <= $b){
                            //       echo "'rgba(".rand(0,359).",".rand(0,359).",".rand(0,359).",1)', ";
                            //     $c++;}?>
                            // ]
                            backgroundColor: ["rgba(100,100,4)"]
                        },
                        {
                            label: "No. of Employees",
                            data: [
                            <?php  $b = 1;
                            foreach ($companyList as $co) {
                              $ci = & get_instance();
                              $ci->load->model("app/report_analytics_model");
                              $count_company = $ci->report_analytics_model->company_count($co->company_id);

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