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

    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    
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
       <small>Payroll Period</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/time_payroll_period">Time</a></li>
      <li class="active">Payroll Period</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

  <div class="row">
                 <?php echo $message;?>
                  <?php echo validation_errors(); ?>
    <div class="col-md-3">
              <div class="btn-group-vertical btn-block">

              <?php 
                  foreach($companyList as $loc){
                      echo "<a onclick='fetch_payroll_period(".$loc->company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_code."</strong></p></a>";
                  }
              ?>
              </div>

    </div>
    <div class="col-md-9" id="compay_payroll_period">
                        
    </div>



<script >

  function fetch_payroll_period(val)
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
          document.getElementById("compay_payroll_period").innerHTML=xmlhttp.responseText;
              $("#example1").DataTable({       
              });
              $('#example2').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
               } );
              $('.datatable').DataTable();
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/comp_payroll_period/"+val,true);
    xmlhttp.send();

  }
  function fetch_payroll_period_year(val)
  {          

       var current_company = document.getElementById("current_company").value;
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
          document.getElementById("compay_payroll_period").innerHTML=xmlhttp.responseText;
              $("#example1").DataTable({       
              });
              $('#example2').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
               } );
              $('.datatable').DataTable();
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/comp_payroll_period/"+current_company+"/"+val,true);
    xmlhttp.send();

  }
  function fetch_payroll_period_group(val)
  {          

       var current_company = document.getElementById("current_company").value;
       var year_cover = document.getElementById("year_cover").value;
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
          document.getElementById("compay_payroll_period").innerHTML=xmlhttp.responseText;
              $("#example1").DataTable({       
              });
              $('#example2').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
               } );
              $('.datatable').DataTable();
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/comp_payroll_period/"+current_company+"/"+year_cover+"/"+val,true);
    xmlhttp.send();

  }

 function check_cutoff()
        {          
            
       var pay_type = document.getElementById("pay_type").value;
       var month_cover = document.getElementById("month_cover").value;
       var cover_year = document.getElementById("cover_year").value;
       var company_id = document.getElementById("company_id").value;
       var pay_type_group = document.getElementById("pay_type_group").value;
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
            
            document.getElementById("pay_type_cutoff").innerHTML=xmlhttp.responseText;

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/pay_type_cutoff/"+pay_type+"/"+company_id+"/"+cover_year+"/"+month_cover+"/"+pay_type_group,true);
        xmlhttp.send();

        }

 function comp_pay_type_group()
        {          
            
       var pay_type = document.getElementById("pay_type").value;
       var month_cover = document.getElementById("month_cover").value;
       var cover_year = document.getElementById("cover_year").value;
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
            
            document.getElementById("comp_pay_type_group").innerHTML=xmlhttp.responseText;

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/comp_pay_type_group/"+pay_type+"/"+company_id+"/"+cover_year+"/"+month_cover,true);
        xmlhttp.send();

        }


   function add(val)
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
            
            document.getElementById("compay_payroll_period").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/add/"+val,true);
        xmlhttp.send();

        }
   function edit_payroll_period(val)
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
            
            document.getElementById("compay_payroll_period").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/edit_payroll_period/"+val,true);
        xmlhttp.send();

        }   

    function add_pay_per_group(val)
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
            
            document.getElementById("add_pay_per_group").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/add_pay_per_group/"+val,true);
        xmlhttp.send();

        }    


   function edit_payroll_period_group(val)
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
            
            document.getElementById("add_pay_per_group").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/edit_payroll_period_group/"+val,true);
        xmlhttp.send();

        }

     //=======================================manage_payroll_period_employee_group================================

    function view_employee_period_group(val)
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
              document.getElementById("compay_payroll_period").innerHTML=xmlhttp.responseText;
              $("#example1").DataTable({       
              });
              $('#example2').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
               } );
              $('.datatable').DataTable();
          }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/view_employee_period_group/"+val,true);
        xmlhttp.send();
    }

 $(".chk_boxes").click(function()   //SCRIPT for Checkall
         {
          alert("OK");
       /*  var checked_status = this.checked;
         $(".chk_boxes1").each(function()
           {
            this.checked = checked_status;
           });*/
        });


    function view_employee(val)
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
            document.getElementById("compay_payroll_period").innerHTML=xmlhttp.responseText;
              $("#example1").DataTable({       
              });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_payroll_period/view_employee/"+val,true);
        xmlhttp.send();
    }



  //====================================END OF manage_payroll_period_employee_group============================  
</script>




<!--     <div class="col-md-4"></div> -->
  </div>


  
    
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

        $("#example1").DataTable();
      });
    </script>

  </body>
</html>