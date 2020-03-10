<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$view_il_table=$this->session->userdata('view_il_table');
$view_il_emp=$this->session->userdata('view_il_emp');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/
?>

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
      

        <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 


    <script src="<?php echo base_url()?>public/jquery-1.7.2.min.js"></script>

    
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
    <?php require_once(APPPATH.'views/include/sidebar.php');?>

<body>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Payroll
    <small>Incentive Leave</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Payroll</li>
    <li class="active">Incentive Leave</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">
<!-- PAYROLL INCENTIVE LEAVE ======================================================================================== -->
      <div class="col-md-3">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>INCENTIVE LEAVE</strong></div>
            <div class="btn-group-vertical btn-block">

                <a onclick="incentive_leave_table()" type='button' class='<?php echo $view_il_table;?> btn btn-default btn-flat'><p class='text-left'><strong>Incentive Leave Table</strong></p></a>
                <a onclick="incentive_leave_enrollment()" type='button' class='<?php echo $view_il_emp;?> btn btn-default btn-flat'><p class='text-left'><strong>Incentive Leave Enrollment</strong></p></a>
            </div>  
           </div>             
          </div> <!-- box box-primary -->  
       </div> <!-- col-md-4 -->     
     <!-- </div>  row -->

     <!-- SCRIPT -->
  <script>

    //======================================= INCENTIVE TABLE ============================================

      function incentive_leave_table()
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
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/incentive_leave_table_view/",true);
          xmlhttp.send();
      }

      function get_company_table(val)
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

              document.getElementById("company_table").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/company_table_view/"+val,true);
          xmlhttp.send();
      }

      function incentive_table_add(val)
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

              document.getElementById("company_table").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/incentive_table_add_view/"+val,true);
          xmlhttp.send();
      }

      function incentive_table_edit(val)
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

              document.getElementById("company_table").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/incentive_table_edit_view/"+val,true);
          xmlhttp.send();
      }

      //======================================= END OF INCENTIVE TABLE ============================================

      //==================================== EMPLOYEE INCENTIVE LEAVE ENROLLMENT =====================================
      var tempcompany         = 0;
      var templocation        = 0;
      var tempdivision        = 0;
      var tempdepartment      = 0;
      var tempsection         = 0;
      var tempsubsection      = 0;
      var tempclassification  = 0;


      function applyFilterlocation(val)
      {  

          var company           = tempcompany;
          var location          = val;
          var division          = tempdivision;
          var department        = tempdepartment;
          var section           = tempsection;
          var subsection        = tempsubsection;
          var classification    = tempclassification;
          
          templocation          = location;
          tempdivision          = division;
          tempdepartment        = department;
          tempsection           = section;
          tempsubsection        = subsection;
          tempclassification    = classification;
          tempcompany           = company;

          
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
          $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
            $('.datatable').DataTable();
            $("#selectall").click(function () {
                $('.case').attr('checked', this.checked);
            });
            $(".case").click(function(){

              if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
              } else {
                $("#selectall").removeAttr("checked");
              }

            });
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp.send();

      }

      function applyFilterclassification(val)
      {  

          var company           = tempcompany;
          var location          = templocation;
          var division          = tempdivision;
          var department        = tempdepartment;
          var section           = tempsection;
          var subsection        = tempsubsection;
          var classification    = val;
          
          templocation          = location;
          tempdivision          = division;
          tempdepartment        = department;
          tempsection           = section;
          tempsubsection        = subsection;
          tempclassification    = classification;
          tempcompany           = company;

          
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
            $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
            $('.datatable').DataTable();

            $("#selectall").click(function () {
                $('.case').attr('checked', this.checked);
            });
            $(".case").click(function(){

              if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
              } else {
                $("#selectall").removeAttr("checked");
              }

            });
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp.send();
      
      }

      function applyFilterdivision(val)
      {  

          var company           = tempcompany;
          var location          = templocation;
          var division          = val;
          var department        = 0;
          var section           = 0;
          var subsection        = 0;
          var classification    = tempclassification;
          
          templocation          = location;
          tempdivision          = division;
          tempdepartment        = department;
          tempsection           = section;
          tempsubsection        = subsection;
          tempclassification    = classification;
          tempcompany           = company;

          
      if (window.XMLHttpRequest)
        {
        xmlhttp1=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttp1.onreadystatechange=function()
        {
        if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
          {
            document.getElementById("search_here").innerHTML=xmlhttp1.responseText;
            $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
            $('.datatable').DataTable();

            $("#selectall").click(function () {
                $('.case').attr('checked', this.checked);
            });
            $(".case").click(function(){

              if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
              } else {
                $("#selectall").removeAttr("checked");
              }

            });
          }
        }
      xmlhttp1.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp1.send();
      
      }

      function applyFilterdepartment(val)
      {  

          var company           = tempcompany;
          var location          = templocation;
          var division          = tempdivision;
          var department        = val;
          var section           = 0;
          var subsection        = 0;
          var classification    = tempclassification;
          
          templocation          = location;
          tempdivision          = division;
          tempdepartment        = department;
          tempsection           = section;
          tempsubsection        = subsection;
          tempclassification    = classification;
          tempcompany           = company;

          
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
            $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
            $('.datatable').DataTable();

            $("#selectall").click(function () {
                $('.case').attr('checked', this.checked);
            });
            $(".case").click(function(){

              if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
              } else {
                $("#selectall").removeAttr("checked");
              }

            });
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp.send();
      
      }

      function applyFiltersection(val)
      {  

          var company           = tempcompany;
          var location          = templocation;
          var division          = tempdivision;
          var department        = tempdepartment;
          var section           = val;
          var subsection        = 0;
          var classification    = tempclassification;
          
          templocation          = location;
          tempdivision          = division;
          tempdepartment        = department;
          tempsection           = section;
          tempsubsection        = subsection;
          tempclassification    = classification;
          tempcompany           = company;

          
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
          $('#example1').DataTable( {
              "scrollY":        "400px",
              "scrollCollapse": true,
              "paging":         false
          } );
          $('.datatable').DataTable();
          $("#selectall").click(function () {
              $('.case').attr('checked', this.checked);
          });
          $(".case").click(function(){

            if($(".case").length == $(".case:checked").length) {
              $("#selectall").attr("checked", "checked");
            } else {
              $("#selectall").removeAttr("checked");
            }

          });
        }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp.send();
      
      }

      function applyFiltersubsection(val)
      {  

          var company           = tempcompany;
          var location          = templocation;
          var division          = tempdivision;
          var department        = tempdepartment;
          var section           = tempsection;
          var subsection        = val;
          var classification    = tempclassification;
          
          templocation          = location;
          tempdivision          = division;
          tempdepartment        = department;
          tempsection           = section;
          tempsubsection        = subsection;
          tempclassification    = classification;
          tempcompany           = company;

          
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
          $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
          $('.datatable').DataTable();
          $("#selectall").click(function () {
              $('.case').attr('checked', this.checked);
          });
          $(".case").click(function(){

            if($(".case").length == $(".case:checked").length) {
              $("#selectall").attr("checked", "checked");
            } else {
              $("#selectall").removeAttr("checked");
            }

          });

          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/search/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification,false);
      xmlhttp.send();

      }


      function incentive_leave_enrollment()
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
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/incentive_leave_enrollment_view/",true);
          xmlhttp.send();
      }

      function get_company_employee(val)
      { 
          tempcompany           = val;
          templocation          = 0;
          tempdivision          = 0;
          tempdepartment        = 0;
          tempsection           = 0;
          tempsubsection        = 0;
          tempclassification    = 0;     

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
              document.getElementById("company_employee").innerHTML=xmlhttp.responseText;
              $("#example1").DataTable({       
              });
              $('.datatable').DataTable();
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/company_employee_view/"+val,true);
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

      function getDepartment(val)
      {  
          
      if (window.XMLHttpRequest)
        {
        xmlhttpDep=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttpDep=new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttpDep.onreadystatechange=function()
        {
        if (xmlhttpDep.readyState==4 && xmlhttpDep.status==200)
          {
          
          document.getElementById("department").innerHTML=xmlhttpDep.responseText;
          }
        }
      xmlhttpDep.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/get_division_department/"+val,true);
      xmlhttpDep.send();
      } 

    function getSection(val)
    {  
        
    if (window.XMLHttpRequest)
      {
      xmlhttp1=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp1.onreadystatechange=function()
      {
      if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
        {
        
        document.getElementById("section").innerHTML=xmlhttp1.responseText;
        }
      }
    xmlhttp1.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/get_department_section/"+val,true);
    xmlhttp1.send();

    } 

    function getSubsection(val)
    {  
        
    if (window.XMLHttpRequest)
      {
      xmlhttp1=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp1.onreadystatechange=function()
      {
      if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
        {
        
        document.getElementById("subsection").innerHTML=xmlhttp1.responseText;
        }
      }
    xmlhttp1.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/get_section_subsection/"+val,true);
    xmlhttp1.send();

    }

    function incentive_employee_add(val)
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
            document.getElementById("company_employee").innerHTML=xmlhttp.responseText;
            $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
            } );
            $('.datatable').DataTable();
            $("#selectall").click(function () {
                $('.case').attr('checked', this.checked);
            });
            $(".case").click(function(){

              if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
              } else {
                $("#selectall").removeAttr("checked");
              }

            });
          }
        }
      xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/incentive_employee_add_view/"+val,true);
      xmlhttp.send();

    } 

    
      function incentive_leave_equivalent(val)
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

              document.getElementById("select_all").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/incentive_leave_equivalent_view/"+val,true);
          xmlhttp.send();
      }

      
      function incentive_employee_edit(val)
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
              document.getElementById("company_employee").innerHTML=xmlhttp.responseText;
              $("#example1").DataTable({       
              });
              $('.datatable').DataTable();
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/incentive_employee_edit_view/"+val,true);
        xmlhttp.send();
      }

      /*function select_all_employee(val)
      {          
          var company           = tempcompany;
          var location          = templocation;
          var division          = tempdivision;
          var department        = tempdepartment;
          var section           = tempsection;
          var subsection        = tempsubsection;
          var classification    = tempclassification;
          
          templocation          = location;
          tempdivision          = division;
          tempdepartment        = department;
          tempsection           = section;
          tempsubsection        = subsection;
          tempclassification    = classification;
          tempcompany           = company;


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
                $('#example1').DataTable( {
                  "scrollY":        "400px",
                  "scrollCollapse": true,
                  "paging":         false
                } );
                $('.datatable').DataTable();
              }
            }
          
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/select_all_employee_view/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+val,false);
          xmlhttp.send();
      } */

      /*function unselect_all_employee(val)
      {            

          var company           = tempcompany;
          var location          = templocation;
          var division          = tempdivision;
          var department        = tempdepartment;
          var section           = tempsection;
          var subsection        = tempsubsection;
          var classification    = tempclassification;
          
          templocation          = location;
          tempdivision          = division;
          tempdepartment        = department;
          tempsection           = section;
          tempsubsection        = subsection;
          tempclassification    = classification;
          tempcompany           = company;

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
              $('#example1').DataTable( {
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false
              } );
              $('.datatable').DataTable();
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_incentive_leave/unselect_all_employee_view/"+company+"/"+location+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+classification+"/"+val,false);
          xmlhttp.send();
      }  */


      //=============================== END OF EMPLOYEE INCENTIVE LEAVE ENROLLMENT ===================================

    </script>
    <!-- END OF SCRIPT -->

<!-- PAYROLL INCENTIVE LEAVE =============================================================================== -->
                  <div class="col-md-8" id="col_2"></div>
                </div>
            </div><!-- /.box-body -->
             
                        <!-- Loading (remove the following to stop the loading)-->   
            <div class="overlay" hidden="hidden" id="loading">
            <i class="fa fa-spinner fa-spin"></i>
            </div>
            <!-- ./ end loading -->

             


  <?php require_once(APPPATH.'views/include/footer.php');?></div>

        <!-- DataTables -->
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

  </body>
</html>
