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
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php if($this->session->userdata('is_logged_in')){
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

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Recruitment
    <small>Job Analytics</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Recruitment</li>
    <li class="active">Job Analytics</li>
  </ol>
</section>

      <!-- <div class="container-fluid"> -->
      <section class="content">
      <!-- ===================================================================================== -->
                    <?php echo $message;?>
              <?php echo validation_errors(); ?>
              <div class="box box-primary">
              

              <br>
                <div class="box-header"><strong> 
<?php 
    if($this->session->userdata('recruitment_employer_is_logged_in')){
    }else{
      echo " Select Company ";
    }
?> 


                        </strong>             
                </div>
                <div class="box-body">
<?php 
    if($this->session->userdata('recruitment_employer_is_logged_in')){
    }else{
?>                
          <div class="form-group">              
          <select class="form-control" name="company_id" id="company_id" style="width: 100%;" onchange="gotoPage()" >
              <option selected="selected" disabled="disabled" value="">-All Company-</option>
                    <?php
                    foreach($companyList as $company){
                    if($_POST['company'] == $company->company_id){
                    $selected = "selected='selected'";
                    }else{
                    $selected = "";
                    }
                    ?>
              <option value="<?php echo $company->company_id;?>" <?php echo $selected;?>><?php echo $company->company_name;?></option>
                    <?php }?>
          </select>                        
          </div>
<?php 
}
      
?>  
<!-- //====================show all applicants -->
                     <div id="show_job_tally_per_comp">  
                  <table id="example1" class="table table-bordered table-striped">
      <thead>
      <tr>
<?php 
    if($this->session->userdata('recruitment_employer_is_logged_in')){
    }else{
      echo "<th >Company</th> ";
    }
?> 

      
      <th >Position</th>
      <th >Slot</th>
      <th >Current Available</th>
<?php
              if(!empty($app_active_optionList)){
                  foreach($app_active_optionList as $stat_opts){
?>
<th><?php echo $stat_opts->status_title; ?></th>
<?php
                 } }else{
                  }
?>
      </tr>
      </thead>
      <tbody>
      <?php foreach($alljobsList as $jobs){?>
      <tr>
<?php 
    if($this->session->userdata('recruitment_employer_is_logged_in')){
    }else{
      echo "<td >".$jobs->company_name."</td> ";
    }
?> 

      <td><b><?php echo $jobs->job_title; ?></b> </td>
     <td><?php echo $jobs->job_vacancy; ?></td>
     <td><?php

$jobs->company_id; 
$hired_app=$this->general_model->hired_applicantList($jobs->company_id,$jobs->job_id);
$array_items = count($hired_app);
echo $jobs->job_vacancy-$array_items;

      ?></td>
<?php

              if(!empty($app_active_optionList)){
                  foreach($app_active_optionList as $stat_opts){
?>
<td>

<?php 

$app_stat=$this->general_model->appStatus_List($jobs->company_id,$jobs->job_id,$stat_opts->app_stat_id);
$array_items2 = count($app_stat);

 if($array_items2=="0"){
  $change_bg="";
 }else{
  $change_bg='style="background-color:#ff0000;"';
 }
echo '<a data-toggle="collapse" data-target="#seemore_'.$jobs->company_id.'_'.$jobs->job_id.'_'.$stat_opts->app_stat_id.'" ><span class="badge" '.$change_bg.'>'.$array_items2.'</span></a><br>
<div id="seemore_'.$jobs->company_id.'_'.$jobs->job_id.'_'.$stat_opts->app_stat_id.'" class="collapse">';

foreach($app_stat as $app){
  //echo $app->fullname."<br>";

   echo '<a href="'.base_url().'app/recruitment/applicant_profile/'.$app->employee_info_id.'/'.$app->applicant_id.'/'.$app->job_id.'" data-toggle="tooltip"  title="Click to view resume of '.$app->fullname.' " role="button" class="btn btn-default btn-xs"><i class="fa fa-arrow-right text-danger"></i> &nbsp;&nbsp;'.$app->fullname.'</a><br>';
}


echo '</div>';




?></td>
<?php
              } }else{
                  }
?>
      </tr>
      <?php } ?>  
      </tbody>
    </table>   
                      </div>             
                </div><!-- /.box-body -->
              </div><!-- /.box -->

      <!-- ===================================================================================== -->
  <script >
function gotoPage()
        {  
        var company_id = document.getElementById("company_id").value;
        if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
            document.getElementById("show_job_tally_per_comp").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/recruitment/show_job_tally_per_comp/"+company_id,false);
        xmlhttp2.send();

        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
        }

    function addAppStatOpt()
        {          
            
        if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/add_status_option",true);
        xmlhttp.send();

        }
    function editStatOpt(val)
        {          
            
        if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/edit_status_option/"+val,true);
        xmlhttp.send();

        }
</script>
 
      </section>
             
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

        $("#example1").DataTable();
      });
    </script>

  </body>
</html>