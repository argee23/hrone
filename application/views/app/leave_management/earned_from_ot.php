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
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body onLoad="autoload();">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Content Header (Page header) -->
              <?php  
                $current_leave_id = $this->uri->segment("4");
                $current_emp = $this->uri->segment("6");
                $trimmed_current_emp = urldecode($current_emp);

                $leave = $this->leave_management_model->get_leave_details($current_leave_id);

                //foreach($leave_details as $leave){
                $current_leave=$leave->leave_type;
                $start_value=$leave->start_value;
                $leaveEff=$leave->effectivity;               
               // }
              ?>
<section class="content-header">
  <h1>
    Administrator
    <small>Leave Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li ><a href="<?php echo base_url()?>app/leave_management/index">Leave Management</a></li>
      <li class="active"></li>View Leave Usage</li>
  </ol>
</section>

      <section class="content"> 

        <div class="box box-primary">        
      
        <?php echo validation_errors(); ?>
        <br>
          <div class="box-body">     
              <table id="ot_table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th colspan="10" ><a data-toggle="tooltip" data-placement="right" data-html="true" title="">Earned From Approved OT</a> [
                    </th>
                  </tr>
                  <tr>
                    <th>File Date</th>
                    <th>Doc Number</th>
                    <th>Status</th>
                    <th>Reason</th>
                    <th>Atro Date</th>
                    <th>No of Hours</th>
                    <th>Equivalent Credit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $earned = 0;
                    foreach($emp as $employee){
                        $array_items = count($employee);
                        $employee_id=$employee->employee_id;     
                        $earned+=$employee->equivalent_incentive_credit;  
                    ?>
                      <tr>
                          
                          <td><?php echo $employee->date_created;?></td>
                          <td><?php echo $employee->doc_no;?></td>
                          <td><?php echo $employee->status;?></td>
                          <td><?php echo $employee->reason;?></td>
                          <td><?php echo $employee->atro_date;?></td>
                          <td><?php echo $employee->no_of_hours;?></td>
                          <td><?php echo $employee->equivalent_incentive_credit;?></td>
                      </tr>
                  <?php } ?>

                </tbody>
                  <tr>
                  <td colspan="4" align="right"> </td>
                  <td class="text-danger" style="border:1px solid #000;"  align="center">TOTAL : <?php  echo $earned;//echo $sum = array_sum( explode( ',', $get_total ) );?></td>
                  <td colspan="4"></td>
                  </tr>
              </table>


            </div><!-- box-body -->
          </div>         
          </section>

          </div>
              
            <!-- Loading (remove the following to stop the loading)-->   
            <div class="overlay" hidden="hidden" id="loading">
            <i class="fa fa-spinner fa-spin"></i>
            </div>

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

        $("#emp_table").DataTable();


      });

      $(function () {
        $('#ot_table').DataTable({
          "pageLength":-1,
          "pagingType" : "simple",
          "paging": true,
           lengthMenu: [[-1,10,30,50,100], ["All",10,30,50,100]],
          "searching": false,
          "ordering": false,
          "info": true,
          "autoWidth": false
        });
      });

    </script>

  </body>
</html>