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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables2/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
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
    201 Employee Files
    <small>Employees Masterlist</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>201 Employee Files</li>
    <li class="active">Employees Masterlist</li>
  </ol>
</section>

      <div class="container-fluid">
      <!-- ===================================================================================== -->
      
              <div class="box">
              
              <?php echo $message;?>
              <?php echo validation_errors(); ?>
              <br>
                <div class="box-header">
                  <!-- <h3 class="box-title"></h3> -->
                  <a href="#filter" role="button" data-toggle="collapse" class="btn btn-warning btn-xs"><i class="fa fa-arrow-down"></i> More Filter Options</a>
                  <a href="<?php echo base_url()?>app/employee/add_employee" type="button" class="btn btn-primary btn-xs pull-right"><i class="fa fa-user-plus"></i> Add Employee</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  

                  </div>
                  <div id="search_here">
                  <table id="user_table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>User ID</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>User Role</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($user as $user){if($user->InActive == 0){ $inactive = 'Active';}else{ $inactive = 'Inactive';}?>

                      <tr>
                        <td><?php echo $user->user_id?></td>
                        <td><?php echo $user->employee_id?></td>
                        <td><?php echo $user->name?></td>
                        <td><?php echo $user->role_name?></td>
                        <td><?php echo $user->dept_name?></td>
                        <td><?php echo $user->section_name?></td>
                        <td>
                            <a href="<?php echo base_url()?>app/user/edit_user"><i class="fa fa-pencil-square-o fa-lg text-primary pull-right" data-toggle="tooltip" data-placement="left" title="Modify <?php echo $user->name?>'s User Account"></i></a>
                            <a href="<?php echo base_url()?>app/user/delete_user"><i class="fa fa-times-circle fa-lg text-danger pull-right" data-toggle="tooltip" data-placement="left" title="Delete <?php echo $user->name?>'s User Account"></i></a>
                        </td>
                      </tr>
                      <?php }?>
                    </tbody>
                  </table>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

      <!-- ===================================================================================== -->
      </div>
      
             
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
    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables2/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables2/dataTables.bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }


      $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();

        $("#user_table").DataTable();
      });
    </script>

  </body>
</html>