<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
<!-- SIDEBAR -->
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
<?php
  if($employer_type=='public')
  {
    $company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
    $account =$employer_type;
  }
  else
  {
    $company_id = 'by_company';
    $account =$employer_type;
  }  
?>
<div class="col-md-12" style="margin-top: 10px;">
  <div class="col-md-12"><?php echo $message;?></div>
</div>
<div class="content-wrapper2">


   <div class="col-sm-12" style="padding-top: 10px;"> <div class="col-md-3">
      <div class="box box-solid box-default">
        <div class="box-header">
        <h5 class="box-title">
            <i class='fa fa-cog fa-spin'></i> <span> Employer Settings</span>
        </h5>
       </div><div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark" style="height:475px;overflow: scroll;">
        <ul class="nav nav-pills nav-stacked" id="rec_main">
           <?php foreach($settings as $row){
            if($employer_type=='public' AND $row->code=='ED8'){} 
            else if($employer_type=='hris' AND $row->code=='ED7'){}
            else{
            ?>
                <li class="my_hover">
                   <a data-toggle="tab" href="#" style="cursor: pointer;" onclick="get_setting('<?php echo $row->code;?>','<?php echo $company_id;?>','<?php echo $account;?>');"><i class='fa fa-folder-open'></i><span><?php echo $row->title;?></span></a>
                </li>
            <?php } } ?>
          </ul>
        </div>
      </div>
    </div>

  <div class="col-md-9" >
    <div class="panel box box-success" style="height:auto;margin-bottom:100px;overflow: scroll;" id="main_res">

    </div>
  </div>
    </div>
</div>
 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->

 <script src="<?php echo base_url()?>public/validation.js"></script>
    <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
   
     <script src="<?php echo base_url()?>public/app.min.js"></script> 
   
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz_niceditor/js/nicEdit.js"></script>
    <!--  <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/jquery-3.1.1.min.js"></script>  -->
    <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/tinymce.min.js"></script>
  <!--  <script type="text/javascript" src="<?php echo base_url()?>public/nemz/js/bootstrap.min.js"></script> -->

   <!--  <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> -->
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

<?php require_once(APPPATH.'views/recruitment_employer/js_functions.php');?>
  </body>
</html>
