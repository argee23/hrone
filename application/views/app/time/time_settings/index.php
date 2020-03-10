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
        <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Time
       <small>Time Settings</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/time_settings">Time</a></li>
      <li class="active">Time Settings</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

  <div class="row">
     
              <?php echo $message;?>
              <?php echo validation_errors(); ?>

<div class="col-md-12" >
      <div class="box box-success">
        <div class="box-header"><strong></strong>
        </div>
        <div class="box-body">
          
  <select class="form-control select2" name="location" id="company_id" style="width: 100%;" onchange="get_time_settings(this.value)" >
  <option selected="selected" value="0" disabled="">~ Select Company ~</option>
  <?php 
  foreach($companyList as $company){
  echo "<option value='".$company->company_id."' >".$company->company_name."</option>";
  }
  ?>
  </select>  

    </div>
        </div>
</div>

  <div style="float: right;" class="col-md-5" id="col_2" >


    </div>
<div id="show_time_settings">
  


</div>

<script>
    function edit(val)
        {          
       var company_id = document.getElementById("company_id").value;
               
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_settings/edit/"+val+"/"+company_id,true);
        xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
        }

  function add_late_deduction_reference()
        {          
        var company_id = document.getElementById("company_id").value;     
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_settings/add_late_deduction_reference/"+company_id,true);
        xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
        }
        // ====== time settings
function get_time_settings(val)
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
            
            document.getElementById("show_time_settings").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/time_settings/show_time_settings/"+val,false);
        xmlhttp2.send();

        }

        // ====== time settings

function edit_late_deduction_reference(val)
        {          
      var company_id = document.getElementById("company_id").value;          
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_settings/edit_late_deduction_reference/"+val+"/"+company_id,true);
        xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
        }
function individual_flexi_edit(val)
        {          
              
        var company_id = document.getElementById("company_id").value;         
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_settings/individual_flexi_edit/"+val+"/"+company_id,true);
        xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
        }

function individual_flexi_add()
        {          
        var company_id = document.getElementById("company_id").value;         
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_settings/individual_flexi_add/"+company_id,true);
        xmlhttp.send();
        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
        }
//
function get_employees()
        {  
            
        var company_id = document.getElementById("company_id").value;
        var cSearch = document.getElementById("cSearch").value;
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
            
            document.getElementById("showSearchResult").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/time_settings/showSearchEmployee/"+cSearch+"/"+company_id,false);
        xmlhttp2.send();

        }
//

function autoload()
{
  getEmployeeList(''); 
}
function getEmployeeList(val)
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
    document.getElementById("showSearchResult").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo base_url();?>app/time_settings/showSearchEmployee/"+val,true);
xmlhttp.send();
}

function select_emp(val)
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
            
            document.getElementById("show_selected_emp").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/time_settings/select_emp/"+val+"/"+company_id,false);
        xmlhttp2.send();

        }
  // function all_c(){
  //     //var num = document.getElementById("num").value;
  //   for(i=1; i<=100; i++){
  //     document.getElementById(i).value = document.getElementById("min").value;
  //   }
  // }


  // function all_c(){
  //     var num = document.getElementById("num").value;
  //   for(i=1; i<=num; i++){
  //       document.getElementById("ctr"+i).value = "";
  //     document.getElementById("ctr"+i).value = document.getElementById("min").value;
  //   }
  // }
   function add_minimum_hour_mins_perhour_leave(table)
    {
      var company_id = document.getElementById("company_id").value; 
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_settings/add_minimum_hour_mins_perhour_leave/"+company_id+"/"+table,true);
        xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
    }

    function checker_minutes_hours(table)
        {
          var hours = document.getElementById('from_hour').value;
          var minutes = document.getElementById('from_min').value;
          if(table=='time_settings_minimum_hours_mins')
          {
            var final_minutes = minutes;
            var final_hours = hours * 60;
          }
          else
          { 
            var final_minutes = minutes/60;
            var final_hours = hours;
          }
          
          
          var final =  (+final_hours) + (+final_minutes);
          if(final=='0')
          {
            document.getElementById('computed_hours_mins').value="";
          }
          else
          {
            document.getElementById('computed_hours_mins').value=final;
          }
          
        }

</script>
      
  </div><!-- main -->

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

        $("#late_").DataTable();
        $("#under_time_").DataTable();
        $("#night_diff_").DataTable();
        $("#min_over_time_").DataTable();
        $("#adv_over_time").DataTable();
        $("#flexi_time_").DataTable();
        $("#reg_night_diff_").DataTable();
        $("#auto_ded_ot_hrs_on_atro_").DataTable();
        $("#auto_1st_8hrs_atro_for_rd_and_hol_").DataTable();

      });
    </script>


 <!-- text validation -->
    <script src="<?php echo base_url()?>public/validation/validation.js"></script>
  </body>
</html>