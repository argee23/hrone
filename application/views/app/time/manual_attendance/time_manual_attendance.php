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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">

    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    <script>
    function printProfile(divID) {

      var printContents = document.getElementById(divID).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;

    }
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
    Time
    <small>Manual Attendance</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Time</li>
    <li class="active">Manual Attendance</li>
  </ol>
</section>

      <div class="container-fluid">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">
      
<!-- TIME MANUAL ATTENDANCE ================================================================================================= -->
		
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>MANUAL ATTENDANCE</strong></div>
            <div class="btn-group-vertical btn-block">

  <!--           <a onclick="template_withBreak()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Excel Template <i class="fa fa-arrow-right"></i> Attendance with Break </strong></p></a> -->

            <a onclick="template_withoutBreak()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Excel Template <i class="fa fa-arrow-right"></i> Attendance <span class="text-danger">without</span> Break</strong></p></a>

            <a onclick="template_dtr_summary()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Excel Template <i class="fa fa-arrow-right"></i> DTR Summary </p></a>

            <a onclick="update_dtr_summary()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Excel Template <i class="fa fa-arrow-right"></i> Update No.of regular days in<br> Manual DTR Summary </p></a>

            <?php
            $MyActiveBioType=$this->time_biometrics_setup_model->ActiveBioType();
            if(!empty($MyActiveBioType)){
              foreach($MyActiveBioType as $actbio){
                $actbio->id;
                $auto_onclick="chosen_bio_".$actbio->id."(".$actbio->id.")";

                $auto_function="chosen_bio_".$actbio->id."(val)";
                $goto_controller="chosen_bio_index";

            ?>

        <script>
        function <?php echo $auto_function?>
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

                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/time_manual_attendance/<?php echo $goto_controller;?>/"+val,true);
            xmlhttp.send();
        }                    
        </script>

            <a onclick="<?php echo $auto_onclick;?>" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>
              <?php echo $actbio->brand_name." &nbsp;".$actbio->bio_name; ?>
            </strong></p>
            </a>

            <?php
                
              }
            }else{

            }
            ?>

            </div>  
           </div>             
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     









<!--//======================================Employee List Modal Container ==============================//-->
<div class="modal modal-primary fade" id="showEmployeeList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                </div>
          <div class="modal-body">
                                           
  <input onKeyUp="getEmployeeList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                        <span id="showSearchResult">                        </span>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>                          
                  </div>
                </div>
            </div><!-- /.box-body -->
<!--//====================================== End Employee List Modal Container ==============================//-->










<!-- SCRIPT -->
<script>


function autoload()
{
  getEmployeeList(''); 
}
function getEmployeeList(val)
{ 
  var info = $('#company_id').val();
          //var cSearch = document.getElementById("cSearch").value;
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
    document.getElementById("showSearchResult").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","<?php echo base_url();?>app/time_manual_attendance/showSearchEmployee/"+val+"/"+info,true);
  xmlhttp.send();
}

function select_emp(val)
        {  
            
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
            
            document.getElementById("show_selected_emp").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/time_manual_attendance/select_emp/"+val,false);
        xmlhttp2.send();

        }





    function myFunction() {
            alert("NOTE: If there's a downloaded file open/check it to correct the template!");
      }

    $(document).ready(function(){
      if($(".has-warning").value()){
        $("#submit").removeAttr("disabled");
      };
    });


    function template_withBreak()
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_manual_attendance/template_withBreak/",true);
        xmlhttp.send();
    }

    function template_withoutBreak()
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_manual_attendance/template_withoutBreak/",true);
        xmlhttp.send();
    }
    function template_dtr_summary()
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_manual_attendance/template_dtr_summary/",true);
        xmlhttp.send();
    } 
     function update_dtr_summary()
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_manual_attendance/update_dtr_summary/",true);
        xmlhttp.send();
    }
</script>
<!-- SCRIPT -->



<!-- TIME MANUAL ATTENDANCE ================================================================================================= -->
        <div class="col-md-8" id="col_2"></div>
        </div>
      </div><!-- /.box-body -->
       
      <!-- Loading (remove the following to stop the loading)-->   
      <div class="overlay" hidden="hidden" id="loading">
      <i class="fa fa-spinner fa-spin"></i>
      </div>
      <!-- ./ end loading -->

             


  <?php require_once(APPPATH.'views/include/footer.php');?></div>
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

