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

        <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

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
    <small>Compress Work Schedule</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Time</li>
    <li class="active">Compress Work Schedule</li>
  </ol>
</section>

      <div class="container-fluid">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">
      
<!-- TIME FLEXI SCHEDILE ================================================================================================= -->
    
        <div class="col-md-3">
          <div class="box box-danger">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>Select a Company</strong></div>
            <div class="btn-group-vertical btn-block">

                <?php foreach($companyList as $company){?>
                  <a onclick="view_compress_group('<?php echo $company->company_id; ?>')" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong><?php echo $company->company_code; ?></strong></p></a>
                <?php } ?>

            </div>  
           </div>             
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     




<!-- SCRIPT -->
<script>
    var tempcompany = 0;
    function view_compress_group(val)
    {            
        tempcompany = val; 
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
              $("#example11").DataTable({  });
              $('.datatable').DataTable();
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_compress_schedule/view_compress_group/"+val,true);
        xmlhttp.send();
    }  

    function add_time_compress_group(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_compress_schedule/add_time_compress_group/"+val,true);
        xmlhttp.send();
    }  

    function edit_time_compress_group(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_compress_schedule/edit_time_compress_group/"+val,true);
        xmlhttp.send();
    }

 function enroll_emp_time_compress(val)
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
      
      document.getElementById("col_3").innerHTML=xmlhttp.responseText;
      }
    }
  xmlhttp.open("GET","<?php echo base_url();?>app/time_compress_schedule/enroll_emp_grouped_contact/"+company_id+"/"+val,true);
  xmlhttp.send();

  }

 function viewEnrolled(val)
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
      
      document.getElementById("col_3").innerHTML=xmlhttp.responseText;
      }
    }
  xmlhttp.open("GET","<?php echo base_url();?>app/time_compress_schedule/viewEnrolled/"+company_id+"/"+val,true);
  xmlhttp.send();

  }


// ========start filter
function fetch_div_dep(val)
        {          
       var company_id= document.getElementById("company_id").value;        
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
            
            document.getElementById("fetch_div_dep").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/fetch_div_dep/"+val+"/"+company_id,true);
        xmlhttp.send();

        }
function fetch_dep_sect(val)
        {          
       var company_id= document.getElementById("company_id").value;        
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
            
            document.getElementById("fetch_dep_sect").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/fetch_dep_sect/"+val+"/"+company_id,true);
        xmlhttp.send();

        }
function fetch_subsection(val)
        {          
       var company_id= document.getElementById("company_id").value;        
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
            
            document.getElementById("fetch_subsection").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/sms/fetch_subsection/"+val+"/"+company_id,true);
        xmlhttp.send();

        }


// ========end filter




</script>



<!-- TIME FIXED SCHEDULE ================================================================================================= -->
  

      <div class="col-md-4" id="col_2">
      </div> 
      <div class="col-md-5" id="col_3">
      </div>

     <!--    </div> -->
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

