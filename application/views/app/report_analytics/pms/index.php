<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- Vex -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">  
    
  </head>

<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php 

if($this->session->userdata('is_logged_in')){
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

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Employee 201 Analytics
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}

if($this->session->userdata('recruitment_employer_is_logged_in')){
    $employer_type = 'public';
  }else{
  $employer_type = 'hris';
  }

?>
  
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Reports</li>
    <li>Analytics</li>
    <li class="active">Employee 201</li>
  </ol>
</section>
  <!-- Main content -->
  <section class="content">

  <div class="box box-default">
    <div class="box-body">
      <div class="col-md-12 row">
        <div class="col-md-3">
        


      <ul class="list-group">

        <?php require_once(APPPATH.'views/app/report_analytics/pms/analytics_sidebar.php'); ?>
      </ul>

<!-- box -->
</div>
<!-- box -->
        <div class="col-md-9" >
          <div class="box box-danger">
            <div class="box-header">
              
            </div>
            <div  class="box-body" id="result_here">
                
									
  
            </div>
          </div>
          <!-- box -->
        </div>
        </div>
        <!-- col-md-4 -->

  
        <!-- col-md-8 -->
      </div>
      <!-- row -->
    </div>
    <!-- box-body -->
  </div>
  <!-- box -->
 
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<footer class="footer ">
<div class="container-fluid">
<br>
<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
</div>
</footer>
    <!-- REQUIRED JS SCRIPTS -->
    
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <!-- Bootstrap Select -->
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Vex -->
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
  
   
  </body>
</html>

<script type="text/javascript">
  
    function get_filtering_employee(code)
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
              document.getElementById("result_here").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/get_employee_analytics/"+code,false);
        xmlhttp2.send();
    }
    
    function checker_company(code,val)
    {
      if(val=='Multiple')
      {
        $('#companymultiple'+code).show();
        document.getElementById('final_result').value='';
      }
      else
      {
        $('#companymultiple'+code).hide();
        document.getElementById('final_result').value=val;

      }
    }

   function get_multiple(code)
   {
      var checks = document.getElementsByClassName("multiple");
      var count = document.getElementById('count'+code).value;
      var fields='';

      for (i=0;i < count; i++)
      {
          if (checks[i].checked === true)
          {
            fields +=checks[i].value + "-";
          }
      }        
      
     document.getElementById('final_result').value=fields;

   }

   function get_division(code,company)
   {  
      var xmlhttp;
      if(code=='E6')
      {
        get_location(company,code);
      }

      else if(code=='E7' || code=='E8' || code=='E9' || code=='E13' || code=='E14' || code=='E15' || code=='E17' || code=='E18')
      {
          get_location(company,code);
          get_classification(company,code);
      }
      

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
              document.getElementById("division"+code).innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/get_division/"+company+"/"+code,false);
        xmlhttp2.send();
   }

   function multipledivision(code,division)
   {    

      var company = document.getElementById('company'+code).value;
      if(division=='Multiple')
      {
        $('#multipledivision_view').show();

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
                document.getElementById("multipledivision").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/multipledivision/"+division+"/"+code+"/"+company,false);
          xmlhttp2.send();
      }
      else
      {
         $('#multipledivision_view').hide();
      
      }
   }

   function get_department(code,division)
   {  
    var company = document.getElementById('company'+code).value;
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
                document.getElementById("department"+code).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/get_department/"+division+"/"+code+"/"+company,false);
          xmlhttp2.send();
   }

   function multipledepartment(code,department)
   {    

      var company = document.getElementById('company'+code).value;
      var division = document.getElementById('division'+code).value;


      if(department=='Multiple')
      {
        
        $('#multipledepartment_view').show();

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
                document.getElementById("multipledepartment").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/multipledepartment/"+department+"/"+code+"/"+company+"/"+division,false);
          xmlhttp2.send();
      }
      else
      {
        document.getElementById('final_result').value=department;
         $('#multipledepartment_view').hide();
      
      }
   }


   function multiplesubsection(code,subsection)
   {

      var company = document.getElementById('company'+code).value;
      var section = document.getElementById('section'+code).value;


      if(subsection=='Multiple')
      {
        
        $('#multiplesubsection_view').show();

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
                document.getElementById("multiplesubsection").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/multiplesubsection/"+section+"/"+code+"/"+company+"/"+subsection,false);
          xmlhttp2.send();
      }
      else
      {
        document.getElementById('final_result').value=subsection;
         $('#multiplesubsection_view').hide();
      
      }

   }

   function get_section(code,val)
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
                document.getElementById("section"+code).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/get_section/"+code+"/"+val,false);
          xmlhttp2.send();
   }

   function multiplesection(code,section)
   {    

      var department = document.getElementById('department'+code).value;
      var company = document.getElementById('company'+code).value;
      if(section=='Multiple')
      {
        
        $('#multiplesection_view').show();

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
                document.getElementById("multiplesection").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/multiplesection/"+department+"/"+section+"/"+company+"/"+code,false);
          xmlhttp2.send();
      }
      else
      {
        document.getElementById('final_result').value=section;
         $('#multiplesection_view').hide();
      
      }
   }


   function get_subsection(code,section)
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
                document.getElementById("subsection"+code).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/get_subsection/"+section+"/"+code,false);
          xmlhttp2.send();
   }

   function get_location(company,code)
   {  

       var xmlhttp;
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
                document.getElementById("location"+code).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/get_location/"+company+"/"+code,false);
          xmlhttp2.send();
   }

   function multiplelocation(code,location)
   {
    if(location=='Multiple')
    {
      $('#multiplelocation_view').show();

      var company = document.getElementById('company'+code).value;
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
                document.getElementById("multiplelocation").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/multiplelocation/"+company+"/"+code+"/"+location,false);
          xmlhttp2.send();

    }
    else
    {
        document.getElementById('final_result').value=location;
        $('#multiplelocation_view').hide();
    }
   }

   function multipleclassification(code,classification)
   {

      var company = document.getElementById('company'+code).value;
      if(classification=='Multiple')
      {
        $('#multipleclassification_view').show();

            var company = document.getElementById('company'+code).value;
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
                  document.getElementById("multipleclassification").innerHTML=xmlhttp2.responseText;
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/multipleclassification/"+company+"/"+code+"/"+classification,false);
            xmlhttp2.send();
      }
      else
      {
          document.getElementById('final_result').value=classification;
          $('#multipleclassification_view').hide();
      }
   }

   function get_classification(company,code)
   {
          var xmlhttp;

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
                document.getElementById("classification"+code).innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/report_analytics_employees/get_classification/"+company+"/"+code,false);
          xmlhttp2.send();
   }


   function multipleemployment(code,employment)
   {
    if(employment=='Multiple')
    {
         $('#multipleemployment_view').show();
    }
    else
    { 
         $('#multipleemployment_view').hide();
         document.getElementById('final_result').value=employment;
    }
   }
  

  function multipleothers(code,other)
  {
    if(other=='Multiple')
    {
         $('#multipleothers_view').show();
    }
    else
    { 
         $('#multipleothers_view').hide();
         document.getElementById('final_result').value=employment;
    }
  }

</script>