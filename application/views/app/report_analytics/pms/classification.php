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
 
    </script>
   


    <style type="text/css">
    @media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
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
           <?php require_once(APPPATH.'views/app/report_analytics/pms/analytics_sidebar.php'); ?>
        </div>
        <!-- col-md-4 -->

        <div class="col-md-9">
          <div class="box box-danger" >
            <div class="box-header">
              
            </div>
            <div class="box-body">

              <form  id="btnFilter" action="javascript:myFunction();">
              <div class="row">
                      <div class="col-md-3">
                  <div class="form-group">
                    <label for="">company</label>
                    <select required="" name="company" class="selectpicker" data-live-search="true" data-width="100%" onchange="get_depart(this.value);" data-style="btn-default" >
                      <option value="">select company</option>
                          <?php foreach ($companyList as $companyList): ?>

                        <option value="<?php echo $companyList->company_id; ?>"><?php echo $companyList->company_name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">classification</label>
                    <select name="classification"  id="sel_depart" class="selectpicker" data-live-search="true" data-width="100%" data-style="btn-default" >
                     
                        
                    </select>
                  </div>
                </div>
                <!-- col-md-4 -->

                <div class="col-md-3">
                  <label for="">Appraisal period date</label>
                  <select name="chart_type" id="chart_type" data-width="100%" class="selectpicker">
                              <?php foreach($get_appraisal_schedule as $get_appraisal_schedule){ ?>

    <option value="<?php echo $get_appraisal_schedule->appraisal_period_type_dates; ?>"><?php echo date("d-M-Y", strtotime($get_appraisal_schedule->appraisal_period_type_dates)); ?></option>
        <?php } ?>
                  </select>
                </div>
                <!-- col-md-4 -->
                <div class="col-md-3">
                  <label for=""></label>
                  <button  type="submit" class="btn btn-warning btn-block" id="btnFilters" ><i class="fa fa-filter" ></i> Filter</button>
                </div>
                <!-- col-md-4 -->
              </div>
              <!-- row -->
            </form>
            <div id="section-to-print">


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
    $(document).on('click','#btnFilters',function(){

    if ($("#btnFilter")[0].checkValidity()){
        $.ajax({
            url: "<?php echo base_url();?>app/report_analytics_pms/filtered_classification/",
            data:$('#btnFilter').serialize(),
            type: 'POST',
            success: function(data){
           
              $('#section-to-print').html(data);
               $('#sel_depart').selectpicker('refresh').empty();
            }
        });
      }
     });
  function get_depart(element)
 {$('#sel_depart').selectpicker('refresh').empty();
  
     jQuery.ajax({
        type: "POST",
        url: "<?php echo base_url();?>app/report_analytics_pms/get_classification/",
        dataType: 'json',
        data: {"id" : element},
        success: function(res) {
               $.each(res,function(index,data){
                    $('#sel_depart').append('<option value="'+data['classification_id']+'|'+data['classification']+'">'+data['classification']+'</option>');
             
                 });
                   $('#sel_depart').selectpicker('refresh');
        }



    });

 }

    </script>

  </body>
</html>