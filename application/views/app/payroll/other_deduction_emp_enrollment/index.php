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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">

   <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Payroll
       <small>Payroll Other Deduction Employee Enrollment</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/payroll_other_deduction_emp_enrollment">Payroll</a></li>
      <li class="active">Other Deduction Employee Enrollment</li>
    </ol>
  </section>

  <!-- Main content -->
 
      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

<!-- COMPANY LIST ================================================================================================= -->

   <div class="col-md-3">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>Select a Company</strong></div>
            <div class="btn-group-vertical btn-block">

              <?php 
              //$cl->classification_id.
                  foreach($companyList as $comp){
                      echo "<a onclick='other_deduction_emp_enrollment_option(".$comp->company_id.")' type='button' onchange='getLocation(this.value); getDivision(this.value); getClassification(this.value); applyFiltercompany();' class='btn btn-default btn-flat'><p class='text-left'><strong>".$comp->company_code."</strong></p></a>";
                  }
              ?>


            </div>  
           </div>             
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     

  <div class="col-md-9" id="col_2">  </div>


<!-- SCRIPT -->

 <script>
    function myFunctionee() {
          alert("NOTE: If there's a downloaded file open/check it to correct the template!");
           
           if(document.getElementById("file").value =='' || document.getElementById("file").value ==null)
           {
            alert("Select File to continue");
           } 
          
           if(document.getElementById("action").value =="")
           {
              alert("Select Action to continue");
           }
      }


     function myFunction() {
        var option = document.getElementById('option').value;
        
        if(option=='reset'){}
        else
        {
         if(document.getElementById("file").value =='' || document.getElementById("file").value ==null)
           {
            alert("Select File to continue");
           } 
          alert("NOTE: If there's a downloaded file open/check it to correct the template!");
        }
      }

      $(document).ready(function(){
      if($(".has-warning").value()){
      $("#submit").removeAttr("disabled");
       };
       });
  </script>                           
                          
<script>
//MANUAL EXCEL UPLOAD FOR AUTOMATIC=================================================================================
 function lin_auto(){
    if(document.getElementById("template").value== "Download Template Now"){
    location.href= '<?php echo base_url()?>public/downloadable_templates/set_auto_deduction_template.xls';
    }
  }   
function manual_excel_upload_auto(company_id,od_id,date_effective,pay_type,cutoff)
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

            document.getElementById("same_page").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/manual_excel_upload_auto/"+company_id+"/"+od_id+"/"+date_effective+"/"+pay_type+"/"+cutoff,true);
        xmlhttp.send();
    }
 function enroll_emp_deduct(company_id,pay_type_id,cutoff,od_id,date_effective)
 {
    
    document.getElementById('cutoff').value = cutoff;

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
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/by_group/"+date_effective+"/"+od_id+"/"+cutoff+"/"+pay_type_id+"/"+company_id,true);
        xmlhttp.send();

 }

function checkbox_checkere(val)
    {
      var ckbox = $('#c_6');
       if (ckbox.is(':checked')) {
            document.getElementById("c_1").disabled = true;
            document.getElementById("c_2").disabled = true;
            document.getElementById("c_3").disabled = true;
            document.getElementById("c_4").disabled = true;
            document.getElementById("c_5").disabled = true;

            document.getElementById("c_1").checked = false;
            document.getElementById("c_2").checked = false;
            document.getElementById("c_3").checked = false;
            document.getElementById("c_4").checked = false;
            document.getElementById("c_5").checked = false;
        } else {
            document.getElementById("c_1").disabled = false;
            document.getElementById("c_2").disabled = false;
            document.getElementById("c_3").disabled = false;
            document.getElementById("c_4").disabled = false;
            document.getElementById("c_5").disabled = false;

        }  
    }

function saving_set_automatic_edit_e()
 {
     var cutoff = document.getElementById("cutoff").value; 
     var company_id = document.getElementById("company_id").value;  
     var id = document.getElementById("id").value;
     var od_id = document.getElementById("deduction_id").value;
     var effectivity_date = document.getElementById("effectivity_date").value;
     var pay_type = document.getElementById("pay_type").value;
     var is_automatic = document.getElementById("is_automatic").value;
    
 
 if(cutoff == '' || company_id == '' || id == '' || od_id == '' || effectivity_date == '' || pay_type =='' || is_automatic == '')
        {
          alert("Check all fields required");
        }
        else
            { 
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

                      document.getElementById("same_page").innerHTML=xmlhttp.responseText;

                       setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 2000);
                       $("#example1").DataTable();
                        $('.datatable').DataTable();
                      }
                    }
                 xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/save_edit_e_automatic_deductions/"+cutoff+"/"+company_id+"/"+id+"/"+od_id+"/"+effectivity_date+"/"+pay_type+"/"+is_automatic,true);
                  
                  xmlhttp.send();
             }
          }   

 }

function saving_set_automatic_edit_ne()
 {

 var checks = document.getElementsByClassName("option");
       var cutoff='';

        for (i=0;i<6; i++)
        {
          if (checks[i].checked === true)
          {
            cutoff +=checks[i].value + "-";
            
          }
        }
      

     var company_id = document.getElementById("company_id").value;  
     var id = document.getElementById("id").value;
     var od_id = document.getElementById("deduction_id").value;
     var effectivity_date = document.getElementById("effectivity_date").value;
     var pay_type = document.getElementById("pay_type").value;
     var is_automatic = document.getElementById("is_automatic").value;   
   
 
 if(cutoff == '' || company_id == '' || id == '' || od_id == '' || effectivity_date == '' || pay_type =='' || is_automatic == '')
        {
          alert("Check all fields required");
        }
        else
            { 
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

                      document.getElementById("same_page").innerHTML=xmlhttp.responseText;

                       setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 2000);
                       $("#example1").DataTable();
                        $('.datatable').DataTable();
                      }
                    }
                 xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/save_edit_ne_automatic_deductions/"+cutoff+"/"+company_id+"/"+id+"/"+od_id+"/"+effectivity_date+"/"+pay_type+"/"+is_automatic,true);
                  
                  xmlhttp.send();
             }
          }   

 }


function set_auto_edit(id,company_id,od_id,date_effective,pay_type,cutoff)
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

            document.getElementById("same_page").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/edit_set_automatic_deduction/"+cutoff+"/"+pay_type+"/"+date_effective+"/"+od_id+"/"+company_id+"/"+id,true);
        xmlhttp.send();
    }

function is_automatic_to_zero_deduct(od_id,id,company_id){
     
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
            
               setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 2000);
                      $("#example1").DataTable();
                      $('.datatable').DataTable();

            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/is_automatic_to_zero_deduct/"+company_id+"/"+id+"/"+od_id,true);
        xmlhttp.send();


}

 function viewOptionss()
    {
      document.getElementById("c_1").checked = false;
      document.getElementById("c_2").checked = false;
      document.getElementById("c_3").checked = false;
      document.getElementById("c_4").checked = false;
      document.getElementById("c_5").checked = false;
      document.getElementById("c_6").checked = false;
      $("#pay_type_option_main").show();

      if(document.getElementById("pay_type_id").value==1)
      {

         $("#c1").show();
         $("#c2").show();
         $("#c3").show();
         $("#c4").show();
         $("#c5").show();
         $("#c6").show();
      }
      else if(document.getElementById("pay_type_id").value==2 || document.getElementById("pay_type_id").value==3)
      {
         $("#c1").show();
         $("#c2").show();
         $("#c3").hide();
         $("#c4").hide();
         $("#c5").hide();
         $("#c6").show();
       
      }
     
      else{
          document.getElementById("c_6").checked = true;
         $("#c6").show();
         $("#c1").hide();
         $("#c2").hide();
         $("#c3").hide();
         $("#c4").hide();
         $("#c5").hide();
      }
        
    }


//pay tpe option result
    function viewOption(val)
    {

      document.getElementById("per_payday").checked = false;
      $("#pay_type_option_main").show();
      if(val==1)
      {

         $("#c1").show();
         $("#c2").show();
         $("#c3").show();
         $("#c4").show();
         $("#c5").show();
         $("#payday").show();
      }
      else if(val==2 || val==3)
      {
         $("#c1").show();
         $("#c2").show();
         $("#c3").hide();
         $("#c4").hide();
         $("#c5").hide();
         $("#payday").show();
       
      }
     
      else{
         $("#c1").hide();
         $("#payday").show();
         $("#c2").hide();
         $("#c3").hide();
         $("#c4").hide();
         $("#c5").hide();
      }
       document.getElementById("pay_type_option").value ='1Cutoff'; 
    }

  function checkbox_checker_deduct(val)
    {
      var ckbox = $('#c_6');
       if (ckbox.is(':checked')) {
            document.getElementById("c_1").disabled = true;
            document.getElementById("c_2").disabled = true;
            document.getElementById("c_3").disabled = true;
            document.getElementById("c_4").disabled = true;
            document.getElementById("c_5").disabled = true;

            document.getElementById("c_1").checked = false;
            document.getElementById("c_2").checked = false;
            document.getElementById("c_3").checked = false;
            document.getElementById("c_4").checked = false;
            document.getElementById("c_5").checked = false;
        } else {
            document.getElementById("c_1").disabled = false;
            document.getElementById("c_2").disabled = false;
            document.getElementById("c_3").disabled = false;
            document.getElementById("c_4").disabled = false;
            document.getElementById("c_5").disabled = false;

        }  
    }


 function checkbox_checker(val)
    {
      var ckbox = $('#per_payday');
      if (ckbox.is(':checked')) {
      document.getElementById("checkbox1").disabled = true;
      document.getElementById("checkbox2").disabled = true;
      document.getElementById("checkbox3").disabled = true;
      document.getElementById("checkbox4").disabled = true;
      document.getElementById("checkbox5").disabled = true;

      document.getElementById("checkbox1").checked = false;
      document.getElementById("checkbox2").checked = false;
      document.getElementById("checkbox3").checked = false;
      document.getElementById("checkbox4").checked = false;
      document.getElementById("checkbox5").checked = false;

    }else{
      document.getElementById("checkbox1").disabled = false;
      document.getElementById("checkbox2").disabled = false;
      document.getElementById("checkbox3").disabled = false;
      document.getElementById("checkbox4").disabled = false;
      document.getElementById("checkbox5").disabled = false;
    }

    }

  function cutoff(val) {

     document.getElementById("cutoff").value = val;
  }


function fetch_section_automatic_deduct()
        {          
             var department_id = document.getElementById("department_id").value;     
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
            
            document.getElementById("show_section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/show_section_deduct/"+department_id,true);
        xmlhttp.send();

        } 
function fetch_sub_section_automatic_deduct()
        {          
             var section = document.getElementById("section").value;     
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
            
            document.getElementById("show_sub_section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/show_sub_section_deduct/"+section,true);
        xmlhttp.send();

        }
 function clear_fetched_sub_sec_automatic()
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
            
            document.getElementById("show_sub_section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/clear_fetched_sub_sec_deduct/",false);
        xmlhttp.send();

        }

  function fetch_division_dept_automatic_deduct()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/show_div_dept_deduct/"+company_id+"/"+division_id,true);
        xmlhttp.send();

        }

function fetch_payroll_period_automatic_deduct()
        {          
             var pay_type_group = document.getElementById("pay_type_group").value;    
             var company_id = document.getElementById("company_id").value;  
             var pay_type = document.getElementById("pay_type").value; 
            
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
            
            document.getElementById("for_employee_filtering").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/by_employee_filtering_deduct/"+company_id+"/"+pay_type+"/"+pay_type_group,true);
        xmlhttp.send();

        }



function saving_set_automatic_deduct()
 {
        
    var checks = document.getElementsByClassName("checks");
        var cutoff='';

        for (i=0;i<6; i++)
        {
          if (checks[i].checked === true)
          {
            cutoff +=checks[i].value + "-";
            
          }
        }
   
     var company_id = document.getElementById("company_id").value;  
  
     var id = document.getElementById("deduction_id").value;
  
     var effectivity_date = document.getElementById("effectivity_date").value;
  
     var pay_type = document.getElementById("pay_type_id").value;
  
     var is_automatic = document.getElementById("is_automatic").value;
     
  
 if(cutoff == '' || company_id == '' || id == '' || effectivity_date == '' || pay_type =='' || is_automatic == '')
        {
          alert("Check all fields required");
        }
        else
            { 
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

                      document.getElementById("same_page").innerHTML=xmlhttp.responseText;

                       setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 2000);
                       $("#example1").DataTable();
                       $('.datatable').DataTable();
                      }
                    }
                 xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/save_new_automatic_deductions/"+cutoff+"/"+company_id+"/"+id+"/"+effectivity_date+"/"+pay_type+"/"+is_automatic,true);
                  
                  xmlhttp.send();
             }
          }   

 }

function fetch_per_deduct(val)       
        {          

                if(val==1)
                {
                   document.getElementById("auto_will_deduct_on").value ='5cutoff'; 
                }
                else if(val==2)
                {
                  document.getElementById("auto_will_deduct_on").value ='2cutoff';
                }
                else if(val==3)
                {
                  document.getElementById("auto_will_deduct_on").value ='2cutoff';
                }
                else{
                   document.getElementById("auto_will_deduct_on").value ='1cutoff'; 
                }

        }

function add_new_automatic_deduction(val)
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

            document.getElementById("same_page").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/add_new_automatic_deduction/"+val,true);
        xmlhttp.send();
    }

function automatic_deduction(val)
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
              $("#example1").DataTable();
               $('.datatable').DataTable();
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_automatic/automatic_deduction/"+val,true);
        xmlhttp.send();
    }

//END OF AUTOMATIC DEDUCTION========================================================================================


//START OF MANUAL EXCEL UPLOAD=============================================================================================

function lin_single(){
    if(document.getElementById("template").value== "Download Template Now"){
    location.href= '<?php echo base_url()?>public/downloadable_templates/deduction_single_upload_template.xlsx';
    }
  }   

  function lin_mass(){
    alert("mila");
    if(document.getElementById("template").value== "Download Template Now"){
    location.href= '<?php echo base_url()?>public/downloadable_templates/deduction_mass_upload_template.xlsx';
    }
  }   

function mas_ded(){
    if(document.getElementById("upload_option").value==1){
      document.getElementById("tmplt").innerHTML = "for single uploading"
     $('#other_deduction_id').removeAttr('disabled');
     
      }else{
     document.getElementById("tmplt").innerHTML = "for mass uploading"
      $('#other_deduction_id').attr('disabled','disabled');
     }
  }
    
 function lin(){
    if(document.getElementById("upload_option").value==1){
    location.href= '<?php echo base_url()?>public/downloadable_templates/deduction_single_upload_template.xls';
    }else{
    location.href= '<?php echo base_url()?>public/downloadable_templates/deduction_mass_upload_template.xls';
    }
  }   

function back_option(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_excel_upload/other_deduction_excel_upload/"+val,true);
        xmlhttp.send();
    }


function fetch_excel_payroll_period_mass()
        {          
             var pay_type_group = document.getElementById("pay_type_group").value;    
             var pay_type = document.getElementById("pay_type").value;     
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
            
            document.getElementById("by_payroll_period").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_excel_upload/by_payroll_period_mass/"+company_id+"/"+pay_type+"/"+pay_type_group,true);
        xmlhttp.send();

        }

function fetch_excel_payroll_period()
        {          
             var pay_type_group = document.getElementById("pay_type_group").value;    
             var pay_type = document.getElementById("pay_type").value;     
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
            
            document.getElementById("by_payroll_period").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_excel_upload/by_payroll_period/"+company_id+"/"+pay_type+"/"+pay_type_group,true);
        xmlhttp.send();

        }

//SINGLE UPLOAD====================================================
function mass_upload(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_excel_upload/mass_upload/"+val,true);
        xmlhttp.send();
    }

function single_upload(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_excel_upload/single_upload/"+val,true);
        xmlhttp.send();
    }


function fetch_excel_pay_period_group_mass()
        {          
             var pay_type = document.getElementById("pay_type").value;     
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
            
            document.getElementById("by_group").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_excel_upload/by_group_mass/"+company_id+"/"+pay_type,true);
        xmlhttp.send();

        }


function fetch_excel_pay_period_group()
        {          
             var pay_type = document.getElementById("pay_type").value;     
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
            
            document.getElementById("by_group").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_excel_upload/by_group/"+company_id+"/"+pay_type,true);
        xmlhttp.send();

        }
function manual_excel_upload(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_excel_upload/other_deduction_excel_upload/"+val,true);
        xmlhttp.send();
    }

//END OF MANUAL EXCEL UPLOAD===============================================================================================
//START OF OTHER DEDUCTION MANUAL ENCODING==================================================================================
function other_deduction_manual_encoding(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_emp_enrollment/other_deduction_manual_encoding/"+val,true);
        xmlhttp.send();
    }

//END OF OTHER DEDUCTION MANUAL ENCODING====================================================================================
    function other_deduction_emp_enrollment_option(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_emp_enrollment/other_deduction_emp_enrollment_option/"+val,true);
        xmlhttp.send();
    }
 function fetch_pay_period_group()
        {          
             var pay_type = document.getElementById("pay_type").value;     
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
            
            document.getElementById("by_group").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_emp_enrollment/by_group/"+company_id+"/"+pay_type,true);
        xmlhttp.send();

        }
 
function fetch_payroll_period()
        {          
             var pay_type_group = document.getElementById("pay_type_group").value;    
             var pay_type = document.getElementById("pay_type").value;     
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
            
            document.getElementById("by_payroll_period").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_emp_enrollment/by_payroll_period/"+company_id+"/"+pay_type+"/"+pay_type_group,true);
        xmlhttp.send();

        }

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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_emp_enrollment/show_div_dept/"+company_id+"/"+division_id,true);
        xmlhttp.send();

        }

 function fetch_section()
        {          
             var department_id = document.getElementById("department_id").value;     
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
            
            document.getElementById("show_section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_emp_enrollment/show_section/"+department_id,true);
        xmlhttp.send();

        } 
function fetch_sub_section()
        {          
             var section = document.getElementById("section").value;     
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
            
            document.getElementById("show_sub_section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_emp_enrollment/show_sub_section/"+section,true);
        xmlhttp.send();

        }
 function clear_fetched_sub_sec()
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
            
            document.getElementById("show_sub_section").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_other_deduction_emp_enrollment/clear_fetched_sub_sec/",false);
        xmlhttp.send();

        }


</script>

<!-- END SCRIPT -->
    

     
          </div>

        </div>
      </div><!-- /.box-body -->
       
      <!-- Loading (remove the following to stop the loading)-->   
      <div class="overlay" hidden="hidden" id="loading">
      <i class="fa fa-spinner fa-spin"></i>
      </div>
      <!-- ./ end loading -->

            </div>
   

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























