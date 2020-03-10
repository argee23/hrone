<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My HRIS- Serttech<?php //echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
    </head>
<!-- header logo: style can be found in header.less -->
     <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>

    <?php require_once(APPPATH.'views/include/header_serttech.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar_serttech.php');?>

<body>  
<div class="col-md-12" style="padding-top:20px;">
    <div class="col-md-3">
      <div class="box box-solid box-default">
        <div class="box-header">
        <h5 class="box-title">
            <i class='fa fa-cog fa-spin'></i> <span> Recruitment Settings</span>
           
        </h5>

          <a class='fa fa-caret-square-o-right pull-right' aria-hidden='true' data-toggle='tooltip' title='Click to view system settings!' onclick="get_setting('view_all_settings');"></a>
          <a class='fa fa-plus-square pull-right' aria-hidden='true' data-toggle='tooltip' title='Click to add new system settings!' onclick="get_setting('add_new_settings');"></a>
          <a class='glyphicon glyphicon-search pull-right' data-toggle='collapse' data-target='#collapse_search' style='cursor:pointer;' aria-hidden='true' data-toggle='tooltip'  title='Click to search system settings!' ></a>
        
          <div id="collapse_search" class="collapse" style="padding-top: 5px;">
            <input type="text" class="form-control" style="border:1px solid red;" placeholder="Enter Search Criteria" onkeyup="search_settings(this.value);">
            <input type="hidden" id='search_val'>
          </div>
       
       </div><div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark" style="height:710px;overflow: scroll;">
          <ul class="nav nav-pills nav-stacked" id="rec_main">
           <?php foreach($details as $row){?>
                <li class="my_hover">
                   <a data-toggle="tab" href="#" style="cursor: pointer;" onclick="get_setting('<?php echo $row->code;?>');"><i class='fa fa-folder-open'></i><span><?php echo $row->policy_title;?></span></a>
                </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>

  <div class="col-md-9" >
    <div class="panel box box-success" style="height:750px;margin-bottom:100px;overflow: scroll;" id="main_res">

    </div>
  </div>
</div>

 </div>

    <script src="<?php echo base_url()?>public/validation.js"></script>
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


    <script type="text/javascript" src="<?php echo base_url()?>public/nemz_niceditor/js/nicEdit.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>

  </body>
</html>
  <?php require_once(APPPATH.'views/serttech/js_functions.php');?>
