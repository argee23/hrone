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
    <?php require_once(APPPATH.'views/include/header_serttech.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar_serttech.php');?>

<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Public Recruitment Management
    <small>Job Management </small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>serttech/serttech_login/myhome"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Public Recruitment Management</li>
    <li >Job Management</li>
  </ol>
</section>

<section class="content">
  <div class="row">
     <!-- ==================================================================== -->
                 <div class="col-md-12">
                    <?php echo $message;?>
              <?php echo validation_errors(); ?>

              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
     
                <li  class="active"><a href="#registered_employers" data-toggle="tab">
                    <i class="fa fa-cog text-danger"></i> Job Management</a>
                </li>
 

                </ul>
                <div class="tab-content">
 
                  <div class="active tab-pane" id="registered_employers">
                     <ul class="products-list product-list-in-box">

                    <li class="item">
            <div class="col-md-12">


          <div class="form-group">              
          <select class="form-control select2" name="company_id" id="company_id" style="width: 100%;" onchange="gotoPage()" >

              <option selected="selected" disabled="disabled" value="">-Select Company-</option>
              <option selected="selected" disabled="disabled" value="">-All-</option>
              <?php
              $companyList=$this->serttech_login_model->employers_job();

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
<div id="view_jobs">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th width="15%">Company</th>
        <th width="30%">Position</th>
        <th width="20%">Posted to the public Status</th>
        <th width="30%">Option

<?php
echo '<a href="'.base_url().'serttech/mypublic_recruitment/approve_all_c" class="btn btn-success btn-sm pull-right" ><i class="fa fa-check text-success"></i>Approve All</a>'.'&nbsp;&nbsp;&nbsp;';
echo '<a href="'.base_url().'serttech/mypublic_recruitment/disapprove_all_c" class="btn btn-danger btn-sm pull-right" ><i class="fa fa-remove text-danger"></i>Disapprove All</a>'.'&nbsp;&nbsp;&nbsp;';
?>

        </th>
      </tr>
      </thead>
    <tbody>

<?php foreach($alljobsList as $jobs){
$job_specs=$this->recruitment_model->getjob_specs($jobs->job_specialization);
$thejob_specizalization=$job_specs->cValue;

if($this->session->userdata('is_serttech_logged_in')){
  if($jobs->admin_verified=="1"){
      $admin_verification_result="<td class='text-success'>displayed to the public</td>";
  }else if($jobs->admin_verified=="waiting"){
      $admin_verification_result="<td class='text-warning'>waiting for admin verification</td>";
  }else if($jobs->admin_verified=="0"){
       $admin_verification_result="<td class='text-danger'>not allowed to be displayed to public</td>";
  }else{
        $admin_verification_result="<td>code error";
  }
}else{
  $admin_verification_result='';
}
        ?>
      <tr>
      <td><?php echo $jobs->company_name; ?></td>

      <td><b><?php echo $jobs->job_title; ?></b>

<button data-toggle="collapse" data-target="#seemore_<?php echo $jobs->job_id."_".$jobs->company_id;?>" class="btn-info pull-right">see more</button>

<div id="seemore_<?php echo $jobs->job_id."_".$jobs->company_id;?>" class="collapse">
Slot: <button class="btn-default"><?php echo $jobs->job_vacancy; ?></button><br>
Salary: <button class="btn-danger"><?php echo $jobs->salary; ?></button><br>
Job Specialization: <button class="btn-default"><?php echo $thejob_specizalization; ?></button><br>
Job Description: <button class="btn-default"><?php echo nl2br($jobs->job_description); ?></button><br>
Job Qualification: <button class="btn-default"><?php echo nl2br($jobs->job_qualification); ?></button><br>
<span class="label label-primary">Hiring Start : <?php echo $jobs->hiring_start; ?></span><br>
<span class="label label-warning">Closed On : <?php echo $jobs->hiring_end; ?></span>
</div>
      </td>
   
       <?php 
 $cd=date('Y-m-d');
if($jobs->hiring_end<=$cd){
  $automatic_close_job=$this->recruitment_model->closed($jobs->job_id,$jobs->company_id);
}else{
  $automatic_open_job=$this->recruitment_model->open($jobs->job_id,$jobs->company_id);
}
       echo $admin_verification_result; ?>
      <td>
<?php
if ($jobs->admin_verified=="waiting"){
$color="text-danger";
$todo="approve_job";
$bg="";

}elseif($jobs->admin_verified=="1"){
$color="text-success";
$todo="disapprove_job";
$bg="class='text-danger'";
}elseif($jobs->admin_verified=="0"){
$color="text-danger";
$todo="approve_job";
$bg="class='text-danger'";
}else{
$color="";
$todo="";
$bg="";
}

echo  $enable_disable= '<a href="'.base_url().'serttech/mypublic_recruitment/'.$todo.'/'.$jobs->job_id.'"  " ><i class="fa fa-power-off '.$color.' pull-right"></i></a>'.'<br>';
?>

      </td>

      </tr>
      <?php } ?>  
      </tbody>
    </table>   

</div>

            </div><!-- /.col -->




                    </li><!-- /.item -->

                  </ul>
                  </div><!-- /.tab-pane -->
<!-- //============= -->
<!-- //============= -->
<div class="tab-pane" id="job_management">
<ul class="products-list product-list-in-box">

<li class="item">
<div class="col-md-6">
<div class="">

Job Management

</div>

</div><!-- /.col -->
</li><!-- /.item -->

</ul>
</div><!-- /.tab-pane -->
<!-- //============= -->

       

                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->

          <!-- ============================================================= --> 
  </div>
</section>
</div>
<script type="text/javascript">
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
            document.getElementById("view_jobs").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>serttech/mypublic_recruitment/view_company_jobs/"+company_id,true);
        xmlhttp2.send();
        }


      function viewJob(val)
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
            
            document.getElementById("view_jobs").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/mypublic_recruitment/view_company_jobs/"+val,true);
        xmlhttp.send();

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

      function add_bill()
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
            
            document.getElementById("view_jobs").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/mypublic_recruitment/add_bill/",true);
        xmlhttp.send();

        }    

</script>
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

    <script>

      $(function () {

        $("#example1").DataTable();



      });
    </script>

  </body>
</html>