<!-- VIEW MEMBER OF GROUP -->
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
//$deac_act_flexi_group_mem=$this->session->userdata('deac_act_flexi_group_mem');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>

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
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    System Setting
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">System Settings</li>
  </ol>
</section>
  <!-- Main content -->
  <section class="content">


<div class="row">

<div class="col-md-6">

<div class="box box-success">

<?php require(APPPATH.'views/app/system_setting/settings_contents.php');?>

</div>   
</div>



<div class="col-md-6">
  <div class="well" style="height: 200px;">

            <form method="post" action="<?php echo base_url()?>app/system_settings/save_setting" >
                  <input type="hidden" name="setting_type" value="<?php echo $topic_details->is_single_setting;?>">
                  <input type="hidden" name="topic_id" value="<?php echo $topic_details->id?>">
  <?php
  if(($topic_details->is_single_setting=="1")AND($topic_details->single_value_type=="yes-no")){
    //Show Web Bundy
    //Show Biometrics Machine Syncronizer
  ?>


                  <div class="form-group">
                  <label ><?php echo $topic_details->topic;?></label>
                  <select class="form-control" name="single_value" id="single_value">
                  <option selected="selected" disabled value="">~Select a Setting~</option>

                  <option value="yes" <?php if ($topic_details->single_value=="yes"){ echo 'selected';}else{}?>>Yes</option>
                  <option value="no"<?php if ($topic_details->single_value=="no"){ echo 'selected';}else{}?>>No</option>
                  </select>
                  </div>

  <?php
  }else if(($topic_details->is_single_setting=="1")AND($topic_details->single_value_type=="specific_web_function_type")){
    //Web Bundy Functions Type
  ?>
                  <div class="form-group">
                  <label ><?php echo $topic_details->topic;?></label>
                  <select class="form-control" name="single_value" id="single_value">
                  <option selected="selected" disabled value="">~Select a Setting~</option>
                    <?php
                    if(!empty($web_bundy_functionList)){
                      foreach($web_bundy_functionList as $w){
                          if ($topic_details->single_value==$w->param_id){
                            $sel="selected";
                          }else{
                            $sel="";
                          }
                        echo '
                        <option value="'.$w->param_id.'" '.$sel.'>'.$w->cValue.'</option>
                        ';
                      }
                    }else{

                    }
                    ?>

                  </select>
                  </div>

 <?php
  }else if(($topic_details->is_single_setting=="1")AND($topic_details->single_value_type=="mainpage_theme")){
    //Web Bundy Functions Type
  ?>
                  <div class="form-group">
                  <label ><?php echo $topic_details->topic;?></label>
                  <select class="form-control" name="single_value" id="single_value">
                  <option selected="selected" disabled value="">~Select a Setting~</option>
                    <?php
                    if(!empty($mainPageui)){
                      foreach($mainPageui as $w){
                          if ($topic_details->single_value==$w->cValue){
                            $sel="selected";
                          }else{
                            $sel="";
                          }
                        echo '
                        <option value="'.$w->cValue.'" '.$sel.'>'.$w->cValue.'</option>
                        ';
                      }
                    }else{

                    }
                    ?>

                  </select>
                  </div>



  <?php
  }else if(($topic_details->is_single_setting=="1")AND($topic_details->single_value_type=="specific_system_trial")){
    //System Trial Start Date-End Date
  ?>
                  <div class="form-group">
                  <label ><?php echo $topic_details->topic;?></label>
                  <br>
                  <?php 

                  if($topic_details->single_value){
                     list($ff,$tt) = explode(" to ",$topic_details->single_value);
                  }else{
                    $ff="";
                    $tt="";
                  }
                          
                  ?>
                  Trial Start<input type="date" class="form-control" name="single_value_from" required value="<?php echo $ff;?>">
                  Trial End<input type="date" class="form-control" name="single_value_to" required value="<?php echo $tt;?>">
                  
                  </div>

  <?php
  }else{

  }
  ?>





            <div class="form-group">
            <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-floppy-o"></i> SAVE</button>
            </div>
            </form>

  </div>   
</div>






</div>

 
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

             
<!-- Loading (remove the following to stop the loading)-->   
<div class="overlay" hidden="hidden" id="loading">
<i class="fa fa-spinner fa-spin"></i>
</div>
<!-- ./ end loading -->
             


<footer class="footer ">
<div class="container-fluid">

<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<div class="text-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</div>
</div>
</footer>
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
    <script src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>

    <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>


    <script type="text/javascript">

      $(function () {
        $("#example1").DataTable();
      });
    </script>

  </body>
</html>