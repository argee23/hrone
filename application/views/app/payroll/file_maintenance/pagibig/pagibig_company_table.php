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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">

    
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
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Payroll
    <small>File Maintenance</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Payroll</li>
    <li class="active">File Maintenance</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">
<!-- FILE MAINTENACE LIST ================================================================================================= -->
      
      <div id="pagibig_print">

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>PAGIBIG TABLE</strong><a href="<?php echo base_url(); ?>app/payroll_file_maintenance/" type="button" class="btn btn-primary btn-xs pull-right" title="Enable account" ><i class="fa fa-arrow-circle-left"></i> Select a company</a></div>

            <div class="box-body">
            <div class="panel panel-success">
            <div class="box-body">
            <div class="row">

            <?php $current_date =  (date('Y', strtotime(date("Y-m-d")))); 
                  $previous_date     = $current_date - 1;
            ?>
            

            <div class="col-md-12">
              <div class="form-group">

              <?php// if($pagibig_current_date === false){ ?>
              <a href="<?php echo site_url('app/payroll_file_maintenance/pagibig_copy_employee/'. $company.''); ?>" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Re-enroll employees to pagibig current year" onClick="return confirm('Are you sure you want to re-enroll the employees to pag-ibig table current year?')" ><i class="fa fa-clipboard fa-2x text-danger pull-right"></i></a>
              <?php //} ?>

              <a href="<?php echo site_url('app/payroll_file_maintenance/pagibig_copy_setting/'. $company.''); ?>" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Copy company setting to employee pag-ibig table" onClick="return confirm('Are you sure you want to copy the company setting to employee pag-ibig table?')" ><i class="fa fa-tasks fa-2x text-success pull-right"></i></a>
              
              </h5></div>

               <br>
              <div class="box box-info"></div>

            </div>

            <div class="col-md-6">

              <div class="col-md-6">
              <div class="form-group">
              <label for="company">Effective year</label>
                <select class="form-control" name="date" id="date" onchange="applyFilter()">
                <?php
                  foreach($pagibig_date as $date){
                    if($_POST['year'] == $date->year){
                      $selected = "selected='selected'";
                    }else{
                      $selected = "";
                    }
                  ?>
                  <option value="<?php echo $date->year;?>" <?php echo $selected;?>><?php echo $date->year;?></option>
                <?php }?>
                </select>
              </div>
              </div>

            </div>



            <div class="col-md-12">
            <div class="form-group">   
            <div id="pagibig_table">    

            <div id="search_here">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width:15%" >EMPLOYEE ID</th>
                    <th style="width:35%" > EMPLOYEE NAME</th>
                    <th> AMOUNT</th>
                    <th style="width:15%" >DEDUCTION PER</th>
                    <th style="width:15%" >TYPE</th>
                    <th></th>
                  </tr>
                </thead>
              <tbody>
              <?php 
              $check = false;
              foreach($payroll_pagibig as $pagibig){ ?>
              <tr>
                <td><?php echo $pagibig->employee_id; ?></td>
                <td><?php echo $pagibig->last_name.', '.$pagibig->first_name.' '.$pagibig->middle_name.' '.$pagibig->name_extension; ?></td>
                <td><?php echo $pagibig->amount; ?></td>
                <td><?php echo $pagibig->cut_off_name; 
//             if($x=="1"){
//                 $extension="st";
//             }elseif($x=="2"){
//                 $extension="nd";
//             }elseif($x=="3"){
//                 $extension="rd";
//             }elseif($x=="4" OR $x=="5" ){
//                 $extension="th";
//             }else{
//                 $extension="";
//             }

// if($x=="per_payday"){
//   echo "every pay day";
// }else{
//   if($x){
//     echo $x.$extension." cutoff";
//   }else{

//   }

// }

                ?></td>
                <td><?php echo $pagibig->pagibig_type_name; ?></td>
                <td>

                <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="pagibig_table_edit('<?php echo $pagibig->pagibig_table_id; ?>')"></i></div>
                </td>
              </tr>
              <?php $check = true;
              } ?>
            </tbody>
            </table>

            </div>
            </div>



            </div>
            </div>
            </div>


            </div>
            </div>
            </div>
            </div>
                      
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
     <!-- </div>  row -->

  <script>
    function applyFilter()
    {  
      var company    = "<?php echo $company;?>";
      var date       = document.getElementById("date").value;
          
      if (window.XMLHttpRequest)
        {
        xmlhttp=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttp.onreadystatechange=function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {
          
          document.getElementById("search_here").innerHTML=xmlhttp.responseText;
          }
        }
       xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/pagibig_table_result/"+company+"/"+date,false);
      xmlhttp.send();

      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });

    }
    function pagibig_table_edit(val)
    {            
        if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {

            document.getElementById("pagibig_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/getpagibigTable_edit/"+val,true);
        xmlhttp.send();
    }

  </script>


<!-- FILE MAINTENANCE LIST ================================================================================================= -->
        <div class="col-md-8" id="col_2"></div>
        </div>
      </div><!-- /.box-body -->
       
<!-- Loading (remove the following to stop the loading) -->   
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
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable();
      });
    </script>

  </body>
</html>
