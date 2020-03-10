<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
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
    
    <h1>
       Administrator
       <small>Downloadable Forms</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Administrator</a></li>
      <li class="active">Downloadable Forms</li>
    </ol>
  </section>
  <br>
  <div class="col-md-12">
   <?php echo $message;?>
        <?php echo validation_errors(); ?>
  </div>
  <div class="col-md-12" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info"  id="fetch_all_result">
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Default Working Schedule Color Code</h4></ol>
            <div class="col-md-12"><br>
                <table class="table table-bordered" id="downloadable">
                  <thead>
                      <tr class="danger">
                          <th>ID</th> 
                          <th>Type</th>
                          <th>Color Code</th>
                          <th> Code</th>
                          <th>Details</th>
                          <th>Identification</th>
                           <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                 <?php $i=1; foreach($details as $d){?>
                      <tr>
                          <td><?php echo $d->id.").";?></td>
                          <td><?php echo $d->title;?></td>
                          <td><?php echo $d->color_code;?></td>
                          <td><input type="color" class="form-control" value="<?php echo $d->color_code;?>" style='width: 200px;' disabled></td>
                           <td><?php echo $d->details;?></td>
                          <td><?php echo $d->identification;?></td>
                          <td>
                            <?php echo "<a type='button' class='<?php echo $edit_ws_color_code;?>' style='cursor:pointer;color:".$system_defined_icons->icon_edit_color.";'  data-toggle='modal' data-target='#modal' data-toggle='tooltip' title='Update Color Code '  href='".base_url('app/working_schedule_color_code/update_color_code')."/".$d->id."'>";?>
                             <i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i>
                             </a>
                          </td>
                      </tr>
                 <?php $i++; } ?>
                  </tbody>
                </table>
            </div>  
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
    

     <div id="modal" class="modal fade" role="dialog">
       <div class="modal-dialog">
           <div class="modal-content modal-md">
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
    <!--//==========Start Js/bootstrap==============================//-->
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
    <!--//==========End Js/bootstrap==============================//-->
    <script type="text/javascript">
       $(function () {
        $('#downloadable').DataTable({
          "pageLength": -1,
           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] ,
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