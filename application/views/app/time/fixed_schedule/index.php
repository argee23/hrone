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
    <small>Fixed Schedule</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Time</li>
    <li class="active">Fixed Schedule</li>
  </ol>
</section>

      <div class="container-fluid">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">
      
<!-- TIME FLEXI SCHEDILE ================================================================================================= -->
    
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>Select a Company</strong></div>
            <div class="btn-group-vertical btn-block">

                <?php foreach($companyList as $company){?>
                  <a onclick="view_company_group('<?php echo $company->company_id; ?>')" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong><?php echo $company->company_code; ?></strong></p></a>
                <?php } ?>

            </div>  
           </div>             
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     

<style>

      .scrollbar_all {

        height: 450px;
        overflow-x: hidden;
        overflow-y: scroll;
      }


      .force-overflow {
          min-height: 250px;
      }

      #style-1::-webkit-scrollbar {
          width: 5px;
          background-color: #d9edf7;
      } 

      #style-1::-webkit-scrollbar-thumb {
          background-color: #3c8dbc;
      }

      #style-1::-webkit-scrollbar-track {
          -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.3);
          background-color: #d9edf7;
      }
      
</style>


<!-- SCRIPT -->
<script>

    var tempcompany = 0;

    function view_company_group(val)
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
              $("#example12").DataTable({  });
              $('#example13').DataTable({  });
              $("#example21").DataTable({  });
              $('.datatable').DataTable();
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/view_company_group/"+val,true);
        xmlhttp.send();
    }

    function add_group(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/add_group/"+val,true);
        xmlhttp.send();
    }

function trim(el) {
    el.value = el.value.
    replace(/(^\s*)|(\s*$)/gi, ""). // removes leading and trailing spaces
    replace(/[ ]{2,}/gi, " "). // replaces multiple spaces with one space 
    replace(/\n +/, "\n"); // Removes spaces after newlines
    return;
}

    function getDivisionDepartment(val)
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

            document.getElementById("department").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/get_DivisionDepartment/"+val,true);
        xmlhttp.send();
    }

    function getDepartmentSection(val)
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

            document.getElementById("section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/get_DepartmentSection/"+val,true);
        xmlhttp.send();
    }
    
    function getSectionSubsection(val)
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

            document.getElementById("subsection").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/get_SectionSubsection/"+val,true);
        xmlhttp.send();
    }  

    function edit_group(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/edit_group/"+val,true);
        xmlhttp.send();
    }

    function view_group_employee(val)
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
              $("#example1").DataTable({       
              });
              $('.datatable').DataTable();

          }
          }
         xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/view_group_employee/"+val,true);
        xmlhttp.send();
    }

  //CODE NI NEMZ=========================================================================
   function fetch_division_dept()
        {          
             var company_id = document.getElementById("company_id").value;
              
             var division_id = document.getElementById("division_id").value;
             
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
            
            document.getElementById("show_div_dept").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/show_div_dept/"+company_id+"/"+division_id,true);
        xmlhttp.send();

        }

//END NG CODES NI NEMZ==================================================================

    function view_edit_employee(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/view_edit_employee/"+val,true);
        xmlhttp.send();
    }

    function view_employee_schedule(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/view_employee_schedule/"+val,true);
        xmlhttp.send();

    }
    function employees_schedule(val)
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

            $("#example1").DataTable({       
            });
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/employees_schedule/"+val,true);
        xmlhttp.send();

    }
    function master_plot(val)
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

            $("#example1").DataTable({       
            });

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/master_plot/"+val+"/"+company_id,true);
        xmlhttp.send();

    }

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
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            $("#example1").DataTable({       
            });
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/view_employee/"+val,true);
        xmlhttp.send();

    }

    function get_search(val)
    {

        var company_id  = tempcompany; 

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
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/view_search/"+company_id+"/"+val,true);
        xmlhttp.send();
        
    }

    function add_employee(company_id,val)
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
         
            $('#example1').DataTable( {
                /*
                "scrollY":        "400px",
                "scrollCollapse": true,
                "paging":         false*/
            } );
            $('.datatable').DataTable();
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/add_employee/"+company_id+"/"+val,true);
        xmlhttp.send();
        
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
        
        document.getElementById("by_department").innerHTML=xmlhttpDep.responseText;
        }
      }
    xmlhttpDep.open("GET","<?php echo base_url();?>app/time_fixed_schedule/get_division_department/"+val,true);
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
        
        document.getElementById("by_section").innerHTML=xmlhttp1.responseText;
        }
      }
    xmlhttp1.open("GET","<?php echo base_url();?>app/time_fixed_schedule/get_department_sections/"+val,true);
    xmlhttp1.send();

    } 
 
 function getSubsection(val)
    {  
        
    if (window.XMLHttpRequest)
      {
      xmlhttpSub=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttpSub=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttpSub.onreadystatechange=function()
      {
      if (xmlhttpSub.readyState==4 && xmlhttpSub.status==200)
        {
        
        document.getElementById("by_subsection").innerHTML=xmlhttpSub.responseText;
        }
      }
    xmlhttpSub.open("GET","<?php echo base_url();?>app/time_fixed_schedule/get_section_subsection/"+val,true);
    xmlhttpSub.send();
    }   

 function filter_employee()
 {
      tempdepartment_id = 0;
      tempsection_id = 0;
    
     var group_id = document.getElementById("group_id").value; 
     var company_id = document.getElementById("company_id").value;  
     var division_id = document.getElementById("division").value;
     
    if(document.getElementById("department").value == '' || document.getElementById("department") == "NULL" || document.getElementById("department") == 0 ){
      department_id = tempdepartment_id;
    }else{

      var department_id = document.getElementById("department").value;
    }
   
    if(document.getElementById("section").value == '' || document.getElementById("section") == "NULL" || document.getElementById("section") == 0 ){
      section_id = tempsection_id;
    }else{
      var section_id = document.getElementById("section").value;
     
    }
  /* tempsubsection_id = 0;
    if(document.getElementById("subsection") == '' || document.getElementById("subsection") == "NULL" || document.getElementById("subsection") == 0 ){
      subsection_id = tempsubsection_id;
    }else{
   }  */

     var subsection_id =  document.getElementById("subsection").value;
     var location = document.getElementById("location").value;
     var classification = document.getElementById("classification").value; 
     var employment = document.getElementById("employment").value; 
     var taxcode = document.getElementById("taxcode").value; 
     var pay_type = document.getElementById("pay_type").value; 
     var civil_status = document.getElementById("civil_status").value; 
     var gender_sex = document.getElementById("gender_sex").value; 

    
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

                      document.getElementById("same_page").innerHTML=xmlhttp.responseText;

                  /*     setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 2000);*/
                       $("#example1").DataTable();
                       $('.datatable').DataTable();
                      }
                    }
                 xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/emp_table_result/"+group_id+"/"+company_id+"/"+division_id+"/"+department_id+"/"+section_id+"/"+subsection_id+"/"+location+"/"+classification+"/"+employment+"/"+taxcode+"/"+pay_type+"/"+civil_status+"/"+gender_sex,true);
                  
                  xmlhttp.send();
           
             

 }

   function checkbox_stat()
  {
     var count= document.getElementById("topic_count").value;
     var checks = document.getElementsByClassName("case");
       
      if(document.getElementById('check_uncheck').checked==true)
        {  
           for (i=0;i < count; i++)
                {
                  checks[i].checked =true;
                }  
        }
      else{      
            for (i=0;i < count; i++)
                {
                  checks[i].checked =false;
                }   
        }
  }


 
 function filter_employee_wo_div()
 {

     
      tempsection_id = 0;
     // tempsubsection_id = 0;
     var group_id = document.getElementById("group_id").value;  
     var company_id = document.getElementById("company_id").value;  
     
    if(document.getElementById("department").value == '' || document.getElementById("department") == "NULL" || document.getElementById("department") == 0 ){
      department_id = tempdepartment_id;
    }else{

      var department_id = document.getElementById("department").value;
    }
   
    if(document.getElementById("section").value == '' || document.getElementById("section") == "NULL" || document.getElementById("section") == 0 ){
      section_id = tempsection_id;
    }else{
      var section_id = document.getElementById("section").value;
     
    }
   
  /*  if(document.getElementById("subsection") == '' || document.getElementById("subsection") == "NULL" || document.getElementById("subsection") == 0 ){
      subsection_id = tempsubsection_id;
    }else{
      var subsection_id = document.getElementById("subsection").value;
      
    }    */

     var subsection_id =  document.getElementById("subsection").value;  
     var location = document.getElementById("location").value;  
     var classification = document.getElementById("classification").value; 
     var employment = document.getElementById("employment").value; 
     var taxcode = document.getElementById("taxcode").value; 
     var pay_type = document.getElementById("pay_type").value; 
     var civil_status = document.getElementById("civil_status").value; 
     var gender_sex = document.getElementById("gender_sex").value; 

  

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

                      document.getElementById("same_page").innerHTML=xmlhttp.responseText;

                  /*     setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 2000);*/
                       $("#example1").DataTable();
                       $('.datatable').DataTable();
                      }
                    }
                 xmlhttp.open("GET","<?php echo base_url();?>app/time_fixed_schedule/emp_table_result_wo_div/"+group_id+"/"+company_id+"/"+department_id+"/"+section_id+"/"+subsection_id+"/"+location+"/"+classification+"/"+employment+"/"+taxcode+"/"+pay_type+"/"+civil_status+"/"+gender_sex,true);
                  
                  xmlhttp.send();
           

 }
</script>
<!-- SCRIPT -->



<!-- TIME FIXED SCHEDULE ================================================================================================= -->
        <div class="col-md-9" id="col_2">
          
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

