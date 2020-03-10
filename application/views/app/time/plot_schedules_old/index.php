<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sert Technology Inc</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
       <?php require_once(APPPATH.'views/app/time/plot_schedules/calendar.php');?>
     <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
  </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>
  <body>
  <!-- Start Content Wrapper. Contains page content -->
  <div class="content-wrapper2">
  <!-- Start Content Header (Page header) -->
    <section class="content-header">
      <h1>Time<small>Plot Schedules</small></h1>
     <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="">Time</a></li>
        <li class="active">Plot Schedules</li>
      </ol>
    </section>
    <br>
     <div class="col-sm-3" style="height:auto;padding-bottom: 30px;">
         <div class="box box-solid box-success">
         <div class="box-header">
          <h5 class="box-title"><i class='fa fa-clipboard'></i> <span>Plot Schedules</span></h5>
          </div>
          <div style="height: 420px;">
             <ul class="nav nav-pills nav-stacked">
                <li><a style='cursor: pointer;' onclick="lock_plotting();"><i class='fa fa-circle-o text-success'></i> <span>Lock Plotting per Payroll Period Management</span></a></li>
                  <!-- <li><a style='cursor: pointer;'><i class='fa fa-circle-o text-success'></i> <span>Manual Upload</span></a></li>  -->
                  <li><a style='cursor: pointer;' onclick="individual_plotting();"><i class='fa fa-circle-o text-success'></i> <span>Individual Plotting</span></a></li> 
                  <li><a style='cursor: pointer;' onclick="group_by_admin();"><i class='fa fa-circle-o text-success'></i> <span>Group Created by Admin</span></a></li> 
                  <li><a style='cursor: pointer;' onclick="view_section_mngr_group();"><i class='fa fa-circle-o text-success'></i> <span>Viewing of all Plotted Schedule of Section Managers</span></a></li>
                  <li><a style='cursor: pointer;' onclick="manual_upload();"><i class='fa fa-circle-o text-success'></i> <span>Manual Uploading</span></a></li>
              </ul>
          </div>
          </div>
          <div class="btn-group-vertical btn-block"></div>  
          </div>
        </div>  
    <div class="col-md-9" style="padding-bottom: 50px;height: 100%;">
      <div class="box box-success">
        <div class="panel panel-info">
              <div class="col-md-12" id="fetch_all_result"><br>
                <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Plot Schedules</h4></ol>
                <div style="height: 340px";>
                </div>
              </div>
              <div class="btn-group-vertical btn-block"> </div>   
        </div>             
      </div> 
    </div> 
    
    <div class="modal modal-primary fade" id="search_employee_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Select Employees</h4>
                  </div>
                 <div class="modal-body">                             
                    <input onKeyUp="ip_employee_list(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                    <span id="Search_Employee_Result"></span>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>                          
            </div>
        </div>
    </div> 

    <!--Start footer-->
    <footer class="footer">
    <div class="container-fluid">
    <br>
    <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
    <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
    </div>
    </footer>
    <!--END footer-->
    
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
     <?php require_once(APPPATH.'views/app/time/plot_schedules/js_functions.php');?>