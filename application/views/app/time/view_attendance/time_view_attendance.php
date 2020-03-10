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
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Time
    <small>View Attendance</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Time</li>
    <li class="active">View Attendance</li>
  </ol>
</section>

      <section class="content">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>


  <div class="row">
    <div class="col-md-3">
              <div class="btn-group-vertical btn-block">
              <?php 
                  foreach($companyList as $loc){
                      echo "<a onclick='fetch_employees(".$loc->company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_name."</strong></p></a>";
                  }
              ?>
              </div>

    </div>
    <div class="col-md-9" id="search_here">


    </div>
  </div>


      <!-- ===================================================================================== -->
      <div id="view_attendance">

  

      </div>

      <script>

        var tempday             = 0;
        var tempmonth           = 0;
        var tempemployee_id     = 0;
    var templocation        = 0;
    var tempdepartment      = 0;
    var tempdivision        = 0;
    var tempsection         = 0;
    var tempsubsection      = 0;
    var tempclassification  = 0;

  	    function view_attendance(val)
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
  	        
  	        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
  	        }
  	      }
  	    xmlhttp.open("GET","<?php echo base_url();?>app/time_view_attendance/view_employee_attendance/"+val,true);
  	    xmlhttp.send();
  	    }

        function applyFilter(val)
        {  
          var year              = document.getElementById("year").value;
          var month             = val;
          var day               = tempday;
          var employee_id       = tempemployee_id;
          tempday               = day;
          tempmonth             = month;
          tempemployee_id       = employee_id;
            
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
            
            document.getElementById("search_attendance").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_view_attendance/search_attendance/"+year+"/"+month+"/"+day+"/"+employee_id,true);

        xmlhttp.send();
        }

        function applyFilterDay(val)
        {  
          var year              = document.getElementById("year").value;
          var month             = tempmonth;
          var day               = val;
          var employee_id       = tempemployee_id;
          tempday               = day;
          tempmonth             = month;
          tempemployee_id       = employee_id;
            
        if (window.XMLHttpRequest)
          {
          xmlhttpDay=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpDay=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpDay.onreadystatechange=function()
          {
          if (xmlhttpDay.readyState==4 && xmlhttpDay.status==200)
            {
            
            document.getElementById("search_attendance").innerHTML=xmlhttpDay.responseText;
            }
          }
        xmlhttpDay.open("GET","<?php echo base_url();?>app/time_view_attendance/search_attendance/"+year+"/"+month+"/"+day+"/"+employee_id,true);

        xmlhttpDay.send();
        }

        function applyFilterMonth(val)
        {  
          var year              = document.getElementById("year").value;
          var month             = val;
          var day               = tempday;
          var employee_id       = tempemployee_id;
          tempday               = day;
          tempmonth             = month;
          tempemployee_id       = employee_id;
            
        if (window.XMLHttpRequest)
          {
          xmlhttpDay=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpDay=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpDay.onreadystatechange=function()
          {
          if (xmlhttpDay.readyState==4 && xmlhttpDay.status==200)
            {
            
            document.getElementById("search_attendance").innerHTML=xmlhttpDay.responseText;
            }
          }
        xmlhttpDay.open("GET","<?php echo base_url();?>app/time_view_attendance/search_attendance/"+year+"/"+month+"/"+day+"/"+employee_id,true);

        xmlhttpDay.send();
        }

        function get_dayList(val)
        {  
          var year        = document.getElementById("year").value;
          var month       = val;
          tempmonth       = month;
            
        if (window.XMLHttpRequest)
          {
          xmlhttpDay=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpDay=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpDay.onreadystatechange=function()
          {
          if (xmlhttpDay.readyState==4 && xmlhttpDay.status==200)
            {
            
            document.getElementById("get_day").innerHTML=xmlhttpDay.responseText;
            }
          }
        xmlhttpDay.open("GET","<?php echo base_url();?>app/time_view_attendance/get_day_list/"+year+"/"+month,true);

        xmlhttpDay.send();
        }

        function get_monthList(val)
        {  
          var year        = document.getElementById("year").value;
          tempemployee_id = val;
            
        if (window.XMLHttpRequest)
          {
          xmlhttpDay=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttpDay=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttpDay.onreadystatechange=function()
          {
          if (xmlhttpDay.readyState==4 && xmlhttpDay.status==200)
            {
            
            document.getElementById("get_month").innerHTML=xmlhttpDay.responseText;
            }
          }
        xmlhttpDay.open("GET","<?php echo base_url();?>app/time_view_attendance/get_month_list/"+year,true);

        xmlhttpDay.send();
        }


  function fetch_employees(val)
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
          document.getElementById("search_here").innerHTML=xmlhttp.responseText;
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
    xmlhttp.open("GET","<?php echo base_url();?>app/time_view_attendance/fetch_comp_emp/"+val,true);
    xmlhttp.send();
  }


    function applyFilterlocation(val)
    {  

    var company             = document.getElementById("company_id").value;
    var location             = document.getElementById("location").value;


        
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
        
        document.getElementById("search_here").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","<?php echo base_url();?>app/time_view_attendance/fetch_comp_emp/"+company+"/"+location,false);
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


         
    	</script>
      <!-- ===================================================================================== -->
      </section>
             
<!-- Loading (remove the following to stop the loading) -->   
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
        $('#inactive-employee').on('show.bs.modal', function(e) {
            
            var $modal = $(this),
                employee_id = e.relatedTarget.id;
                    //$modal.find('.edit-content').html(employee_id);
                     $(".modal-body #employeeID").val( employee_id );
        })

    </script>

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