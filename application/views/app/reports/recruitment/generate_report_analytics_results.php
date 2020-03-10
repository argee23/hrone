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

        <div class="col-md-12" style="overflow: scroll;">
          <?php if($code=='A1'){?>
             
                   <table class="col-md-12 table table-hover" id="report_results">
                      <thead>
                          <tr class="danger">
                           <?php if($crystal_report=='default'){?>
                                <th>Company</th>
                                <th>Count</th>
                           <?php }  else {

                            foreach($crystal_report as $c)
                            {?>
                                <th><?php echo $c->label;?></th>  
                            <?php } } ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($data as $d){?>
                            <tr>
                             <?php if($crystal_report=='default'){?>
                                  <td><?php echo $d->company_name;?></td>
                                  <td><?php echo $d->total_vacancy;?></td>
                             <?php } else {
                              foreach($crystal_report as $c)
                              {
                                $field = $c->field;
                                $value=$d->$field;
                              ?>
                                  <td><?php echo $value;?></td>  
                              <?php }  }?>
                            </tr> 
                        <?php } ?>
                      </tbody>
                  </table>
          <?php } else if($code=='A2' || $code=='A7'){?>
             
                   <table class="col-md-12 table table-hover" id="report_results">
                      <thead>
                          <tr class="danger">
                           <?php if($crystal_report=='default'){?>
                                <th>Position</th>
                                <th>Count</th>
                           <?php }  else {

                            foreach($crystal_report as $c)
                            {?>
                                <th><?php echo $c->label;?></th>  
                            <?php } } ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($data as $d){?>
                            <tr>
                             <?php if($crystal_report=='default'){?>
                                  <td><?php echo $d->job_title;?></td>
                                  <td><?php echo $d->vacancy_count;?></td>
                             <?php } else {
                              foreach($crystal_report as $c)
                              {
                                $field = $c->field;
                                $value=$d->$field;
                              ?>
                                  <td><?php echo $value;?></td>  
                              <?php }  }?>
                            </tr> 
                        <?php } ?>
                      </tbody>
                  </table>
              
          <?php } else if($code=='A3'){ ?>

                     <table class="col-md-12 table table-hover" id="report_results">
                      <thead>
                          <tr class="danger">
                                <th>No</th>
                           <?php if($crystal_report=='default'){?>
                                <th>Month</th>
                                <th>Count</th>
                           <?php }  else {
                              echo "<th>Month</th>";
                            foreach($crystal_report as $c)
                            {?>
                                <th><?php echo $c->label;?></th>  
                            <?php } } ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $month=explode('-',$data[0]);
                              $count=explode('-',$data[1]);
                              $count_val = count($month);


                              for($ii=0; $ii < $count_val;$ii++){

                              $c = $count[$ii];
                              $m = $month[$ii];
                              ?>
                            <tr>
                              <td><?php echo $ii +1; ?></td>
                             <?php if($crystal_report=='default'){?>
                                  <td><?php echo $m; ?></td>
                                  <td><?php echo $c;?></td>
                             <?php } else {
                                echo "<td>".$m."</td>";
                              foreach($crystal_report as $cc)
                              {
                                $field = $cc->field;
                                if($field=='company_id'){ $value= $company_details->company_id;  } else if($field=='company_name'){ $value= $company_details->company_name; } else{  $value=$c; }
                              ?>
                                  <td><?php echo $value;?></td>  
                              <?php }  }?>
                            </tr> 
                        <?php } ?>
                      </tbody>
                  </table>
              

          <?php } else if($code=='A4'){?>

                  <table class="col-md-12 table table-hover" id="report_results">
                      <thead>
                          <tr class="danger">
                           <?php if($crystal_report=='default'){?>
                                <th>Company</th>
                                <th>Count</th>
                           <?php }  else {

                            foreach($crystal_report as $c)
                            {?>
                                <th><?php echo $c->label;?></th>  
                            <?php } } ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($data as $d){?>
                            <tr>
                             <?php if($crystal_report=='default'){?>
                                  <td><?php echo $d->company_name;?></td>
                                  <td><?php echo $d->applicant_count;?></td>
                             <?php } else {
                              foreach($crystal_report as $c)
                              {
                                $field = $c->field;
                               if($field=='count'){ $value=$d->applicant_count; } else if($field=='interview_date'){ $value=$date; } else if($field=='interview_time'){ $value=$time; } else{  $value=$d->$field;  }
                              ?>
                                  <td><?php echo $value;?></td>  
                              <?php }  }?>
                            </tr> 
                        <?php } ?>
                      </tbody>
                  </table>

          <?php } else if($code=='A5'){ ?>

                 <table class="col-md-12 table table-hover" id="report_results">
                      <thead>
                          <tr class="danger">
                           <?php if($crystal_report=='default'){?>
                                <th>Company</th>
                                <th>Count</th>
                           <?php }  else {

                            foreach($crystal_report as $c)
                            {?>
                                <th><?php echo $c->label;?></th>  
                            <?php } } ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($data as $d){?>
                            <tr>
                             <?php if($crystal_report=='default'){?>
                                  <td><?php echo $d->company_name;?></td>
                                  <td><?php echo $d->vacancy_count;?></td>
                             <?php } else {
                              foreach($crystal_report as $c)
                              {
                                $field = $c->field;
                                $value=$d->$field;  

                              ?>
                                  <td><?php echo $value;?></td>  
                              <?php }  }?>
                            </tr> 
                        <?php } ?>
                      </tbody>
                  </table>

          <?php } else if($code=='A6'){?>

               <table class="col-md-12 table table-hover" id="report_results">
                      <thead>
                          <tr class="danger">
                           <?php if($crystal_report=='default'){?>
                                <th>Company</th>
                                <th>Count</th>
                           <?php }  else {

                            foreach($crystal_report as $c)
                            {?>
                                <th><?php echo $c->label;?></th>  
                            <?php } } ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($data as $d){?>
                            <tr>
                             <?php if($crystal_report=='default'){?>
                                  <td><?php echo $d->company_name;?></td>
                                  <td><?php echo $d->applicant_count;?></td>
                             <?php } else {
                              foreach($crystal_report as $c)
                              {
                                $field = $c->field;
                               if($field=='date_range'){ $value=$date_range; } else if($field=='count'){ $value=$d->applicant_count; } else { $value=$d->$field;  }  
                              ?>
                                  <td><?php echo $value;?></td>  
                              <?php }  }?>
                            </tr> 
                        <?php } ?>
                      </tbody>
                  </table>


          <?php } else if($code=='A8'){  ?>

                  <table class="col-md-12 table table-hover" id="report_results">
                      <thead>
                          <tr class="danger">
                           <?php if($crystal_report=='default'){?>
                                <th>Employee</th>
                                <th>Count</th>
                           <?php }  else {

                            foreach($crystal_report as $c)
                            {?>
                                <th><?php echo $c->label;?></th>  
                            <?php } } ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($data as $d){?>
                            <tr>
                             <?php if($crystal_report=='default'){?>
                                  <td><?php echo $d->fullname;?></td>
                                  <td><?php echo $d->count;?></td>
                             <?php } else {
                              foreach($crystal_report as $c)
                              {
                                $field = $c->field;
                                if($field=='date_range'){ $value=$date_range;   } else{ $value=$d->$field;   }
                                
                              ?>
                                  <td><?php echo $value;?></td>  
                              <?php }  }?>
                            </tr> 
                        <?php } ?>
                      </tbody>
                  </table>


          <?php  } else if($code=='A9'){ ?>


                  <table class="col-md-12 table table-hover" id="report_results">
                      <thead>
                          <tr class="danger">
                           <?php if($crystal_report=='default'){?>
                                <th>Company</th>
                                <th>Count</th>
                           <?php }  else {

                            foreach($crystal_report as $c)
                            {?>
                                <th><?php echo $c->label;?></th>  
                            <?php } } ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($data as $d){?>
                            <tr>
                             <?php if($crystal_report=='default'){?>
                                  <td><?php echo $d->company_name;?></td>
                                  <td><?php echo $d->total_vacancy;?></td>
                             <?php } else {
                              foreach($crystal_report as $c)
                              {
                                $field = $c->field;
                                if($field=='date_range'){ $value=$date_range;   } else if($field=='count'){ $value= $d->total_vacancy; } else{ $value=$d->$field;   }
                                
                              ?>
                                  <td><?php echo $value;?></td>  
                              <?php }  }?>
                            </tr> 
                        <?php } ?>
                      </tbody>
                  </table>


          <?php } ?>

          </div>
           
        </div>
        <div class="col-md-2"></div>
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
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  

    <script type="text/javascript">
       $(function () {
        $('#report_results').DataTable({
          "pageLength": -1,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
    </script>
    <?php require_once(APPPATH.'views/app/report_analytics/recruitment/functions.php'); ?>
  </body>
</html>