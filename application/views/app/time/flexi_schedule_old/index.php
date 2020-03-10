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
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Time
       <small>Flexi Schedule</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/time_shift_table">Time</a></li>
      <li class="active">Flexi Schedule </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
  <div class="row">
    <div class="col-md-3">
              <div class="btn-group-vertical btn-block">

              <?php 
                  foreach($companyList as $loc){
                      echo "<a onclick='view(".$loc->company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_name."</strong></p></a>";
                  }
              ?>
              </div>

    </div>
    <div class="col-md-9" id="col_2">
                        
                    </div>
<script>

    // function view(val)
    //     {            
    //     if (window.XMLHttpRequest)
    //       {
    //       xmlhttp=new XMLHttpRequest();
    //       }
    //     else
    //       {// code for IE6, IE5
    //       xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    //       }
    //     xmlhttp.onreadystatechange=function()
    //       {
    //       if (xmlhttp.readyState==4 && xmlhttp.status==200)
    //         {

    //         document.getElementById("col_2").innerHTML=xmlhttp.responseText;
    //         }
    //       }
    //     xmlhttp.open("GET","<?php //echo base_url();?>app/time_flexi_schedule/view_option/"+val,true);
    //     xmlhttp.send();

    //     }

</script>
  </div>
  
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

             
<!-- Loading (remove the following to stop the loading)-->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             



 <?php require_once(APPPATH.'views/include/footer.php');?>

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>

  </body>
</html>