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
    
<style type="text/css">
  .time_class{
    height:2.1em;width:44%;
  }
</style>
    
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
       <small>Shift Table</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/time_shift_table">Time</a></li>
      <li class="active">Shift Table </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
  <div class="row">
    <div class="col-md-3">
              <div class="btn-group-vertical btn-block">

              <?php 
              //$cl->classification_id.
                  foreach($companyList as $loc){
                      echo "<a onclick='view(".$loc->company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_code."</strong></p></a>";
                  }
              ?>
              <?php 
              // //$cl->classification_id.
              //     foreach($classificationList as $cl){
              //         echo "<a onclick='view(".$cl->classification_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$cl->classification."</strong></p></a>";
              //     }
              ?>
              </div>

    </div>
    <div class="col-md-9" id="col_2">
                        
    </div>
<script>
//controlled flexi
    function add_ws_cf(val)
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
            //col_3
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/add_ws_cf/"+val,true);
        xmlhttp.send();

        }

//full flexi        
    function add_ws_ff(val)
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
            //col_3
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/add_ws_ff/"+val,true);
        xmlhttp.send();

        }

// "scrollY":        "100px",
// "scrollCollapse": true,
// "paging":         true
//VIEW  SHIFT ========================================================================
    function view(val)
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
              $("#example11").DataTable({  });
              $("#example12").DataTable({  });
              $('#example13').DataTable({  });
              $("#example21").DataTable({  });
              $("#example22").DataTable({  });
              $('#example23').DataTable({  });
              $("#example31").DataTable({  });
              $("#example32").DataTable({  });
              $('#example33').DataTable({  });
              $("#example41").DataTable({  });
              $("#example42").DataTable({  });
              $('#example43').DataTable({  });
              $("#example51").DataTable({  });
              $("#example52").DataTable({  });
              $('#example53').DataTable({  });
              $("#example61").DataTable({  });
              $("#example62").DataTable({  });
              $('#example63').DataTable({  });
              $("#example71").DataTable({  });
              $("#example72").DataTable({  });
              $('#example73').DataTable({  });
              $("#example81").DataTable({  });
              $("#example82").DataTable({  });
              $('#example83').DataTable({  });
              $("#example91").DataTable({  });
              $("#example92").DataTable({  });
              $('#example93').DataTable({  });
              $('.datatable').DataTable();

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/view_working_schedule/"+val,true);
        xmlhttp.send();

        }
        //add_wsc : add working schedule complete
    function add_cf(val)
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
            //col_3
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/add_cf/"+val,true);
        xmlhttp.send();

        } 

    function edit_controlled_flexi(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/edit_controlled_flexi/"+val,true);
        xmlhttp.send();
 $("html, body").animate({ scrollTop: 0 }, "slow");
return false;      
        } 


        function add_wsc(val)
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
            //col_3
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/add_wsc/"+val,true);
        xmlhttp.send();

        }
        //add_wsc : add working schedule rest day holiday
    function add_ws_rd_hol(val)
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
            //col_3
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/add_ws_rd_hol/"+val,true);
        xmlhttp.send();

        }
        //add_wsc : add working schedule half day
    function add_wshd(val)
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
            //col_3
            document.getElementById("col_3").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/add_wshd/"+val,true);
        xmlhttp.send();

        }
    // edit_ws_cf: edit working schedule controlled flexi
    function edit_ws_cf(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/edit_ws_cf/"+val,true);
        xmlhttp.send();

 $("html, body").animate({ scrollTop: 0 }, "slow");
return false;       

        }  
    // edit_ws_ff: edit working schedule full flexi
    function edit_ws_ff(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/edit_ws_ff/"+val,true);
        xmlhttp.send();

 $("html, body").animate({ scrollTop: 0 }, "slow");
return false;       

        }  
    // edit_wsc: edit working schedule complete/regular
    function edit_wsc(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/edit_wsc/"+val,true);
        xmlhttp.send();

 $("html, body").animate({ scrollTop: 0 }, "slow");
return false;       

        }  
    // edit_wsc: edit working schedule restday holiday
    function edit_ws_rd_hol(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/edit_ws_rd_hol/"+val,true);
        xmlhttp.send();
 $("html, body").animate({ scrollTop: 0 }, "slow");
return false;      
        }   
        // edit_wshd: edit working schedule half day
    function edit_wshd(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_shift_table/edit_wshd/"+val,true);
        xmlhttp.send();
 $("html, body").animate({ scrollTop: 0 }, "slow");
return false;      
        } 

</script>
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