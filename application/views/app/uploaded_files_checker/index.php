<!DOCTYPE html>
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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
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
<!-- Start Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Start Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Reports
       <small>Uploaded Templates</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Reports</a></li>
      <li class="active">Uploaded Templates</li>
    </ol>
  </section>
    
 
    <div class="col-md-3" style="padding-bottom: 50px;margin-top: 10px;"> 
      <div class="box box-primary box-solid">
            <div class="box-header">
              <h4 class="box-title"><a href="#quickview" data-toggle="collapse">Uploaded Templates</a></h4>
            </div>
            <div class="box-body" id="quickview">              
              <ul class="list-group">
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report('Salary');">Salary Information</a></li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report('Schedule');">Working Schedules</a></li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report('Attendance');">Attendance</a></li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report('Leave');">Filed Leave</a></li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report('Overtime');">Filed Overtime</a></li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report('Deduction');">Other Deduction</a></li>
                <li class="list-group-item"><a style="cursor: pointer;" onclick="generate_report('Addition');">Other Addition</a></li>
              </ul>
            </div>
      </div>
    </div> 

    <div class="col-md-9" style="padding-bottom: 50px;margin-top: 10px;"> 
      <div class="box box-default">
        <div class="col-md-12" id="main_result">
           
        </div>
      <div class="panel panel-info">
        <div class="btn-group-vertical btn-block"> </div> 
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
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
    <!--//==========End Js/bootstrap==============================//-->
    
    <script type="text/javascript">
      
    function generate_report(val)
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
            document.getElementById("main_result").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/uploaded_files/generate_report/"+val,true);
        xmlhttp.send();
    }

    function manual_ws_get_group(paytype)
    { 

         var company = document.getElementById('company').value;
         
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
              document.getElementById("group").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/uploaded_files/get_group/"+paytype+"/"+company,true);
          xmlhttp.send();
    }


    function get_payroll_period(group)
    {
          var company = document.getElementById('company').value;
          var paytype = document.getElementById('paytype').value;
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
              document.getElementById("payroll_period").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/uploaded_files/get_payroll_period/"+paytype+"/"+company+"/"+group,true);
          xmlhttp.send();
    }

    function generate_report_results(val)
    {
      var company = document.getElementById('company').value;
      var paytype = document.getElementById('paytype').value;
      var group = document.getElementById('group').value;
      var payroll_period = document.getElementById('payroll_period').value;
      var option = document.getElementById('option').value;

      if(company=='' || paytype=='' || group=='' || payroll_period=='' || option=='')
      {
        alert('Fill up all fields to continue');
      }
      else
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
              document.getElementById("results").innerHTML=xmlhttp.responseText;
               $("#result").DataTable({
                                "dom": '<"top">Bfrt<"bottom"li><"clear">',
                                "pageLength":-1,
                                lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                                buttons:
                                [
                                  {
                                    extend: 'excel',
                                    title: 'Report'
                                  },
                                  {
                                    extend: 'print',
                                    title: 'Report'
                                  }
                                ]              
                              });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/uploaded_files/generate_report_results/"+val+"/"+company+"/"+group+"/"+paytype+"/"+payroll_period+"/"+option,true);
          xmlhttp.send();
      }
    }

    function generate_report_salary(val)
    {
      var company = document.getElementById('company').value;
      var option = document.getElementById('option').value;
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
              document.getElementById("results").innerHTML=xmlhttp.responseText;
               $("#result").DataTable({
                                "dom": '<"top">Bfrt<"bottom"li><"clear">',
                                "pageLength":-1,
                                lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
                                buttons:
                                [
                                  {
                                    extend: 'excel',
                                    title: 'Report'
                                  },
                                  {
                                    extend: 'print',
                                    title: 'Report'
                                  }
                                ]              
                              });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/uploaded_files/generate_report_salary/"+val+"/"+company+"/"+option,true);
          xmlhttp.send();
    }
    </script>