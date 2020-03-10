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
        <?php echo $message;?>
        <?php echo validation_errors(); ?>
        <br>
          <div class="box-body">     
              <table id="emp_table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th colspan="10" ><a data-toggle="tooltip" data-placement="right" data-html="true" title=""><?php echo $trimmed_current_emp." : ". $current_leave ;?> </a> [
                      <?php
                      $cutoff=$leave->cutoff;
                      require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');
                      echo "Leave Used From : $f TO $t";
                      ?>
                      ]   
                    </th>
                  </tr>
                  <tr>
                    <th>File Date</th>
                    <th>Document No/Applied Type</th>
                    <th>Leave Start Date</th>
                    <th>leave Date End</th>
                    <th>No of Days</th>
                    <th>Status</th>
                    <th>Reason</th>
                    <!-- <th>Active</th> -->
                    <th>With Pay</th>

                  </tr>
                </thead>
                <tbody>
                  <?php 
  $get_total=0; 
  $cur_total=0;

                    foreach($emp as $employee){
                        $array_items = count($employee);
                        $employee_id=$employee->employee_id;       
                        $is_per_hour=$employee->is_per_hour;

                    ?>
                  <tr >
                  <td><?php 
                   echo $employee->date_created;
                  ?></td>
                  <td><?php echo $employee->doc_no."<br><span class='text-danger'>".$employee->entry_type."</span>";?></td>
                 <td><?php echo $employee->from_date?></td>
                 <td><?php echo $employee->to_date?></td>
                 <td>
                    <?php 
                    if($is_per_hour=="1"){

                          $ph_leave_used=$this->leave_management_model->ph_leave_check_per_day($employee->doc_no);

                          if(!empty($ph_leave_used)){
                            $cur_total=round($ph_leave_used->leave_credits_deducted,2);
                            echo '<span class="text-success" title="per hour filling">'.$cur_total.'</span>';
                          }else{

                          }


                    }else{
                        if($employee->no_of_days=="0.5"){
                            echo $cur_total=$employee->no_of_days;
                          $days_between="";
                        }else{
                            $start = strtotime($employee->from_date);
                            $end = strtotime($employee->to_date);
                            echo $cur_total=$employee->days;                        
                        }
                    }


                    echo "<br>";

    
                    if($employee->with_pay==1 AND $employee->status=='approved'){
                      $get_total+=$cur_total;
                    }else{

                    }
                        //$get_total.=$days_between. $operator ;    

                 ?></td>
                 <td <?php if($employee->status=="approved"){echo 'class="text-red"';}else{echo "";}  ?>><?php echo $employee->status?></td>
                 <td><?php echo $employee->reason?></td>
                 <!-- <td  > 
                  if($employee->InActive==1){echo "YES";}else{echo "NO";} 
                  </td> -->
                 <td <?php if($employee->with_pay==1){echo 'class="text-red"';}else{echo "";}  ?> ><?php if($employee->with_pay==1){echo "YES";}else{echo "NO";}  ?></td>
                 
                  
                  </tr>
                  <?php }
              
              
                   ?>

                </tbody>
                  <tr>
                  <td colspan="4" align="right"> </td>
                  <td class="text-danger" style="border:1px solid #000;"  align="center">TOTAL : <?php  echo $get_total;//echo $sum = array_sum( explode( ',', $get_total ) );?></td>
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

    </script>

  </body>
</html>