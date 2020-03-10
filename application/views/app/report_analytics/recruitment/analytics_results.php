<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Analytics Report</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/morris.js/assets/css/morris.css'?>">
    <script src="<?php echo base_url()?>public/morris.js/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url()?>public/morris.js/assets/js/raphael-min.js"></script>
    <script src="<?php echo base_url()?>public/morris.js/assets/js/morris.min.js"></script>
  </head>

    <?php require_once(APPPATH.'views/include/header.php');?>
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

    <script type="text/javascript">
        function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        }
    </script>
    <style type="text/css" media="print">
        @page 
        {
        size: auto;   /* auto is the initial value */
        margin: 0mm; 
        margin-top: 50px; /* this affects the margin in the printer settings */
        }
    </style>

<body>
<div class="content-wrapper2">
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
      <div class="col-md-12 row" >
        <div class="col-md-12" id="print" >
        <h3><center><u><?php echo $title;?></u></center></h3>
              <div id="graph" style="margin-top:50px;">

              </div>
       <?php require_once(APPPATH.'views/app/report_analytics/recruitment/analytics.php'); ?>   

        <?php $c=$graph;?>  
        <script>
          Morris.<?php echo $c;?>({
          element: 'graph',
          data: <?php echo $data;?>,
          xkey: '<?php echo $x;?>',
          ykeys: ['<?php echo $y;?>'],
          labels: ['<?php echo $label;?>'],
          pointStrokeColors: ['black'],
          barColors : [<?php echo $color;?>],
          xLabelAngle: 40,
          xLabelMargin: 10,
          resize: true,
          hideHover:true,
          labelTop: true,
           parseTime: false
        });
        </script>
    <style type="text/css">
      .morris-hover{position:absolute;z-index:1000;background-color: white;border-radius: 10px 10px 10px 10px;}
      #morris-chart-bar { height:350px; padding-bottom:25px;} svg { height:500px;}
    </style>

        </div>
         <button type="submit" class="btn btn-danger pull-right btn-xs" onclick="printDiv('print')"><i class="fa fa-print"></i> Print</button>
      </div>
    </div>
  </div>
  </section>
</div>

<footer class="footer ">
<div class="container-fluid">
<br>
<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
</div>
</footer>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <?php require_once(APPPATH.'views/app/report_analytics/recruitment/functions.php'); ?>
  </body>
</html>