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
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Recruitment
       <small>Requirements</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Requirements</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

  


<div class="row">
      <?php echo $message;?>
        <?php echo validation_errors(); ?>
  <div class="col-md-6">
    <div class="panel panel-success">
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Requirements File Maintenance</strong> <a onclick="addRequirement()" type="button" class="btn btn-sm btn-success pull-right" title="Add"><i class="fa fa-plus"></i></a></div>

  <table class="table table-hover table-striped">
  <tr>
    <th>Item Name</th>
   <!--  <th width="20%">Allow file upload</th> -->
    <th width="15%">Status</th>
    <th style="text-align: right;width: 10%;">Option</th>
  </tr>
  <?php 
if(!empty($requirementsList)){
   foreach($requirementsList as $req){
?>
<tr style="<?php if($req->InActive=="1"){ ?>color: #B62304;<?php }else{}?>">
    <td><?php echo $req->item_name;?></td>
   <!--  <td><?php //if($req->IsUploadable=="1"){ echo "Yes";}elseif($req->IsUploadable=="0"){ echo "No";}else{ echo "";} ?></td> -->
    <td><?php if($req->InActive=="0"){ 
        echo '<a href="'.base_url().'app/recruitment/disable_requirement/'.$req->req_id.'"  data-toggle="tooltip" data-placement="left" title="Disable '.$req->item_name.' " role="button" class="btn btn-danger btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; enabled';
        }else {
        echo '<a href="'.base_url().'app/recruitment/enable_requirement/'.$req->req_id.'"  data-toggle="tooltip" data-placement="left" title="Enable '.$req->item_name.' " role="button" class="btn btn-success btn-xs"><i class="fa fa-power-off"></i></a>&nbsp;&nbsp; disabled';
           } ?></td>
    <td>
    <?php 
        $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editRequirement('.$req->req_id.')"></i>';
        $delete = anchor('app/recruitment/delete_requirement/'.$req->req_id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right" ></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete','onclick'=>"return confirm('Are you sure you want to permanently delete ".$req->item_name."?')"));
   
    if($req->InActive=="1"){ }else{  echo $edit. $delete; }
    ?>
    </td>
 </tr>
<?php
}
}else{
?>
  <tr>
    <td colspan="4">No requirements list yet.</td>
  </tr>
<?php
}
 ?>
    
  </table>
    </div>
  </div>

  <div class="col-md-6" id="col_3"></div>

  <div class="col-md-6">
    <div class="panel panel-success">
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Job Vacancies Requirements Management</strong> </div>
      <div class="panel-body">
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
}else{
?>

          <div class="form-group">              
          <select class="form-control select2" name="company_id" id="company_id" style="width: 100%;" onchange="gotoPage()" >

              <option selected="selected" disabled="disabled" value="">-Add Position-</option>
<option selected="selected" disabled="disabled" value="">-All-</option>
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
<?php } ?>

 <div class="col-md-12" id="show_jobs">

<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
?>

  <div class="col-md-12">
  <div class="box box-default">
  <div class="box-header">
  <strong>
    </strong>

  </div>
  <div class="box-body">


<!-- Position (s) -->

  <div class="col-md-12">
  <div class="panel panel-info">
  <div class="panel-heading">
  <strong>Job Requirements

  </strong> 
  </div>
  <div class="panel-body">
  
    <table id="" class="table table-bordered table-striped">
      <thead>
      <tr>
      <th width="20%">Position</th>
      <th width="50">Requirements</th>
      <th width="15%">Job Status</th>
      <th width="7%">Option</th>
      </tr>
      </thead>
      <tbody>
      <?php
$admin_username=$this->session->userdata('employer_username'); // employer username
$rec_company_id=$this->general_model->logged_employer_company();
$company_id=$rec_company_id->company_id;
$cid=$company_id;
$jobsList=$this->general_model->jobsList($company_id);


       foreach($jobsList as $job){?>
      <tr>

      <td><b><?php echo $job->job_title; ?></b>
      <td>
    <?php 
echo $jobs_not_allow=anchor('app/recruitment/to_not_allow_upload_all/'.$job->job_id,'<i class="fa fa-power-off fa-lg text-danger"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Not Allowed to upload?' ))." All : Not Allowed &nbsp;&nbsp;&nbsp;";

echo $jobs_allow=anchor('app/recruitment/to_allow_upload_all/'.$job->job_id,'<i class="fa fa-power-off fa-lg text-success"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Not Allowed to upload?' ))." All : Allowed";
echo "<br><br>";
          foreach($act_req_List as $act_req){
            $req_id=$act_req->req_id;
$may_check=$this->general_model->list_req_of_job($job->job_id,$req_id);
                 if (!empty($may_check)){
                 foreach($may_check as $checkfile){
                   if($checkfile->is_uploadable=="1"){
                      $fileuploadable="uploadable";
                      $cl = anchor('app/recruitment/to_not_allow_upload/'.$job->job_id.'/'.$req_id,'<i class="fa fa-power-off fa-lg text-danger"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Not Allowed to upload?' ));
                   }else{
                      $fileuploadable="not uploadable";
                      $cl = anchor('app/recruitment/to_allow_upload/'.$job->job_id.'/'.$req_id,'<i class="fa fa-power-off fa-lg text-success"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Allowed to upload?' ));                      
                   }
                  echo $cl ." (<i>".$fileuploadable."</i>)&nbsp;&nbsp;";
                 }
                  $applicable="checked";
                  echo '<input type="checkbox" name="req_id[]" value="'.$req_id.'" '.$applicable.' disabled>&nbsp;'.$act_req->item_name."<br>";
                  }else{
                  $applicable="";
                  }            
          }
        ?>
      </td>
      <td><?php
 $cd=date('Y-m-d');
$company_id=$cid;

if($job->hiring_end<=$cd){
  $automatic_close_job=$this->recruitment_model->closed($job->job_id,$company_id);
}else{
  $automatic_open_job=$this->recruitment_model->open($job->job_id,$company_id);
}

       if($job->status_per_company=="1"){ 
    echo " open";

        }else {

    echo " closed";

           } ?></td>
  
      <td>
      <?php

    echo $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"  data-toggle="tooltip" data-placement="left" title="Edit" onclick="editPosition('.$job->job_id.','.$job->company_id.')"></i>';
      ?>

      </td>

      </tr>
      <?php } ?>  
      </tbody>
    </table>      
  </div>
  </div>
  </div>
    
  </div>
  </div>
  </div>





<?php
}else{
}
?>

 </div>

      </div>
    </div>
  </div> <!-- Job Vacancies Requirements Management -->




</div>

 
<script >
    function editPosition(val,cid)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/edit_position/"+val+"/"+cid,true);
        xmlhttp.send();

        }
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
            document.getElementById("show_jobs").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/recruitment/show_jobs_for_req_mng/"+company_id,false);
        xmlhttp2.send();
        }
    function addRequirement()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/add_requirement",true);
        xmlhttp.send();

        }


    function editRequirement(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/edit_requirement/"+val,true);
        xmlhttp.send();

        }
</script>

  
    
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

             
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

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>

  </body>
</html>
