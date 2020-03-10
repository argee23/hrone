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
   <?php echo $message;?>
        <?php echo validation_errors(); ?>
  <div class="col-md-3" style="padding-bottom: 50px;" id="add_filtering">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12"><br>
            <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
                <ul class="nav nav-pills nav-stacked">
                 <li class="my_hover"><a style='cursor: pointer;' href="<?php echo base_url()?>app/downloadable_forms/get_downloadable_company/All"><i class='fa fa-circle-o'></i> <span> All Companies</span></a></li>
                    <?php
                   foreach ($companyList as $company)
                    { ?>
                        <li class="my_hover"><a style='cursor: pointer;' href="<?php echo base_url()?>app/downloadable_forms/get_downloadable_company/<?php echo $company->company_id?>"><i class='fa fa-circle-o'></i> <span>  <?php echo $company->company_name?> </span></a></li>
                      <?php
                    }
                   ?>
                </ul>
                 
            </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
  <div class="col-md-9" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info"  id="fetch_all_result">
       <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Downloadable Forms</h4></ol>
            <div class="col-md-12"><br>
                <table class="table table-bordered" id="downloadable">
                  <thead>
                      <tr class="danger">
                          <th>Company</th> 
                          <th>Title</th>
                          <th>Description</th>
                          <th>Filename</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php foreach($downloadable as $d){?>
                      <tr>
                          <td><?php echo $d->company_name;?></td>
                          <td><?php echo $d->file_name;?></td>
                          <td><?php echo $d->file_description;?></td>
                          <td><?php echo $d->filename;?></td>
                          <td>
                             <a class='<?php echo $del_dis_dl_forms;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  onclick="action_downloadable('delete','<?php echo $d->company_id;?>','<?php echo $d->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Delete Downloadable Form'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
                             <a class='<?php echo $edit_dl_forms;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  data-toggle='modal' data-target='#modal' href='<?php echo base_url('app/downloadable_forms/update_downloadable_forms')."/".$d->company_id."/".$d->id;?>'; aria-hidden='true' data-toggle='tooltip' title='Click to Update Downloadable Form'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                            <?php if($d->InActive==1)
                            {?>
                              <a class='<?php echo $ena_dis_dl_forms;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'   onclick="action_downloadable('enable','<?php echo $d->company_id;?>','<?php echo $d->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Enable Downloadable Form'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } else{?>
                              <a class='<?php echo $ena_dis_dl_forms;?>' style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'   onclick="action_downloadable('disable','<?php echo $d->company_id;?>','<?php echo $d->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Disable Downloadable Form'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
                           
                            <?php } ?>
                            <a class='<?php echo $download_dl_forms;?>' href="<?php echo base_url(); ?>app/downloadable_forms/download_forms/<?php echo $d->filename; ?>" title="Download File" ><i class="fa fa-download"></i> </a>
                          </td>
                      </tr>
                  <?php }?>
                  </tbody>
                </table>
            </div>  
            <div class="btn-group-vertical btn-block"> </div>   
      </div>             
    </div> 
  </div> 
    

     <div id="modal" class="modal fade" role="dialog">
       <div class="modal-dialog">
           <div class="modal-content modal-lg">
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
          "pageLength": 6,
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