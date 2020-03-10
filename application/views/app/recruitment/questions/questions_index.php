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
       <small>Questions</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Recruitment</a></li>
      <li class="active">Questions</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

<div class="row">
      <?php echo $message;?>
        <?php echo validation_errors(); ?>
  <div class="col-md-6">
    <div class="panel panel-danger">
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Qualifying Question(s)</strong> 
      [<span style="font-style: italic;color: #ff0000;">Yes/No Questions</span>]
      <a onclick="addQuaQue()" type="button" class="btn btn-sm btn-success pull-right" title="Add"><i class="fa fa-plus"></i></a>
      </div>
      <div class="panel-body">
        <div class="form-group" >
          <label> Select Company:</label>
          <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="fetchQuaQue(this.value)">
            <option selected="selected" disabled="disabled" value="0">- Select Company -</option>
              <?php 
                foreach($companyList as $company){
                if($_POST['company'] == $company->company_id){
                  $selected = "selected='selected'";
                }
                else{
                  $selected = "";
                }
              ?>
                <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name ?></option>
              <?php }?>
          </select>
        </div>
        <div id="qua_que"></div>
      </div>
    </div>
  </div>

  <div class="col-md-6" id="col_3"></div>


</div>
<!-- //=======================================hr interview questions -->

<div class="row">
  <div class="col-md-6">
    <div class="panel panel-success">
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Hypothetical Question(s)</strong> 
      [<span style="font-style: italic;color: #ff0000;">questions pertaining a general idea of a certain situation</span>]
      <a onclick="addHypoPreQue()" type="button" class="btn btn-sm btn-success pull-right" title="Add"><i class="fa fa-plus"></i></a>
      </div>
      <div class="panel-body">
        <div class="form-group" >
          <label> Select Company:</label>
          <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="fetchHypoPreQue(this.value)">
            <option selected="selected" disabled="disabled" value="0">- Select Company -</option>
              <?php 
                foreach($companyList as $company){
                if($_POST['company'] == $company->company_id){
                  $selected = "selected='selected'";
                }
                else{
                  $selected = "";
                }
              ?>
                <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name ?></option>
              <?php }?>
          </select>
        </div>
        <div id="hypo_pre_que"></div>
      </div>
    </div>
  </div>

  <div class="col-md-6" id="PrelimQues"></div>

</div>
 
<!-- //=======================================hr interview questions multiple choice-->

<div class="row">
  <div class="col-md-6">
    <div class="panel panel-success">
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Multiple Choice </strong> 
        [<span style="font-style: italic;color: #ff0000;">questions pertaining to choose from the enumerated items</span>]
        <a onclick="addMCPreQue()" type="button" class="btn btn-sm btn-success pull-right" title="Add"><i class="fa fa-plus"></i></a>
      </div>
      <div class="panel-body">
        <div class="form-group" >
          <label> Select Company:</label>
          <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="fetchMCPreQue(this.value)">
            <option selected="selected" disabled="disabled" value="0">- Select Company -</option>
              <?php 
                foreach($companyList as $company){
                if($_POST['company'] == $company->company_id){
                  $selected = "selected='selected'";
                }
                else{
                  $selected = "";
                }
              ?>
                <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name ?></option>
              <?php }?>
          </select>
        </div>
        <div id="mc_pre_que"></div>
      </div>
    </div>
  </div>

  <div class="col-md-6" id="MCQues"></div>


</div>


<script >
// fetch qualifying question 
    function fetchQuaQue(val)
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
            
            document.getElementById("qua_que").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/fetch_qua_que/"+val,true);
        xmlhttp.send();

        }
//fetch hypothetical preliminary question
    function fetchHypoPreQue(val)
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
            
            document.getElementById("hypo_pre_que").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/fetch_hypo_pre_que/"+val,true);
        xmlhttp.send();

        }
//fetch multiple choice preliminary question
    function fetchMCPreQue(val)
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
            
            document.getElementById("mc_pre_que").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/fetch_mc_pre_que/"+val,true);
        xmlhttp.send();

        }

// add qualifying question
    function addQuaQue()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/add_qua_que",true);
        xmlhttp.send();

        }


    function editQuaQue(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/edit_qua_que/"+val,true);
        xmlhttp.send();

        }

// add hypothetical preliminary question
    function addHypoPreQue()
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
            
            document.getElementById("PrelimQues").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/add_hypo_pre_que",true);
        xmlhttp.send();

        }    
    function editHypoPreQue(val)
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
            
            document.getElementById("PrelimQues").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/edit_hypo_pre_que/"+val,true);
        xmlhttp.send();

        } 
// add multiple choice preliminary question
    function addMCPreQue()
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
            
            document.getElementById("MCQues").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/add_mc_pre_que",true);
        xmlhttp.send();

        } 
    function editMCPreQue(val)
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
            
            document.getElementById("MCQues").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/edit_mc_pre_que/"+val,true);
        xmlhttp.send();

        }               
// add multiple choice preliminary question
    function addMCPreQue_choice(val)
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
            
            document.getElementById("MCQues").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/add_mc_pre_que_choice/"+val,true);
        xmlhttp.send();

        } 
    function editMCPreQue_choice(val)
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
            
            document.getElementById("MCQues").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/recruitment/edit_mc_pre_que_choice/"+val,true);
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
