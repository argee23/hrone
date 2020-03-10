<?php

    /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $view_emp_tax_type=$this->session->userdata('view_emp_tax_type');
    $view_yearly_tax_exemp=$this->session->userdata('view_yearly_tax_exemp');
    $view_yearly_tax_rates=$this->session->userdata('view_yearly_tax_rates');

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
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">

    
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
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Payroll
    <small>File Maintenance</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Payroll</li>
    <li class="active">File Maintenance</li>
  </ol>
</section>

      <div class="container-fluid">
      <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>

      <div class="row">
<!-- FILE MAINTENACE LIST ================================================================================================= -->

        <div class="col-md-3">
          <div class="box box-primary">
            <div class="panel panel-info">
            <div class="panel-heading"><strong>FILE MAINTENANCE</strong></div>
            <div class="btn-group-vertical btn-block">

                <a onclick="sss_company()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>SSS Contribution</strong></p></a>
                <a onclick="philhealth_company()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>PHILHEALTH Premium Contribution</strong></p></a>


                <a onclick="employee_pagibig_setting_company()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Pagibig General Setting</strong></p></a>

                <a onclick="pagibig_company()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Pagibig Employee Contributions</strong></p></a>

                 <a onclick="pagibig_percentage_table()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Pagibig Percentage Table</strong></p></a>
                <a onclick="other_additions()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Other Additions</strong></p></a>
                <a onclick="other_deductions()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Other Deductions</strong></p></a>
                <a onclick="loan_types()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Loan Types</strong></p></a>
                
                <a href="<?php echo base_url()?>app/payroll_wtax" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Revised Withholding Tax Tables</strong></p></a> <!-- by: blusquall -->

                <a onclick="employee_tax_type()" type='button' class='<?php echo $view_emp_tax_type;?> btn btn-default btn-flat'><p class='text-left'><strong>Employee Tax Type</strong></p></a> 

                <a href="<?php echo base_url()?>app/timecard_table" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Overtime Tables</strong></p></a> <!-- by: blusquall -->

<a onclick="annual_tax_rates()" type='button' class='<?php echo $view_yearly_tax_rates;?> btn btn-default btn-flat'><p class='text-left'><strong>Yearly Annual Tax Rates</strong></p></a>

<a onclick="annual_tax_exemption()" type='button' class='<?php echo $view_yearly_tax_exemp;?> btn btn-default btn-flat'><p class='text-left'><strong>Yearly Annual Tax Exemption</strong></p></a>

                <a onclick="govt_remittance_mngt()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Government Remittances Management</strong></p></a>

                <a onclick="sss_form_management()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>SSS R1-A Form Employee Management</strong></p></a>

               
            </div>  
           </div>             
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
     <!-- </div>  row -->

<script>
//Employee tax type===================================================================================================
 

function annual_tax_rates()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/annual_tax_rates_view/",true);
        xmlhttp.send();
    }
function gotoTaxRates(val)
        {  
        //var company   = $('#company').val();

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
            
            document.getElementById("col_3").innerHTML=xmlhttp2.responseText;
               $("#example1").DataTable({    
                "ordering": false
                  });
               $('.datatable').DataTable();
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/show_annual_tax_rates/"+val,false);
        xmlhttp2.send();
        }


 function editTaxRates(val)
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
            
            document.getElementById("editMe").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/editTaxRates/"+company_id+"/"+val,true);
        xmlhttp.send();

        }
 function addTaxRates(val)
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
            
            document.getElementById("editMe").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/addTaxRates/"+val,true);
        xmlhttp.send();

        }


function editExemption(val)
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
            
            document.getElementById("editMe").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_exemption/editExemption/"+company_id+"/"+val,true);
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
 function taxtypeFilter2(val)
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

            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/taxtypeFilter2/"+company_id+"/"+val,true);
        xmlhttp.send();
    }   
 function taxtypeFilter(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/taxType_filter/"+val,true);
        xmlhttp.send();
    }   


    function employee_tax_type()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/employee_tax_type/",true);
        xmlhttp.send();
    }

//ALJOHN===================================================================================================
    function govt_remittance_mngt()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/company_view/",true);
        xmlhttp.send();
    }

   function sss_form_management()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/sss_form_mngt_company_view/",true);
        xmlhttp.send();
    }
//PAGIBIG PERCENTAGE TABLE===================================================================================================
function applyFilterpagibigyear()
    {  
    
      var date      = document.getElementById("date").value;
      var company_id    = document.getElementById("company_id").value;
      
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
          
          document.getElementById("filter_date").innerHTML=xmlhttp.responseText;
               /*$("#example1").DataTable({    
                  });
               $('.datatable').DataTable();*/
          }
        }
       xmlhttp.open("GET","<?php echo base_url();?>app/payroll_pagibig_percentage_table/pagibig_percentage_table_result/"+company_id+"/"+date,false);
      xmlhttp.send();

    
    }
   
function pagibig_percentage_edit(company_id,pi_percentage_id,amount_from,amount_to,employee_share,employer_share,covered_year)
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

            document.getElementById("add_edit_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_pagibig_percentage_table/pagibig_percentage_edit/"+company_id+"/"+pi_percentage_id+"/"+amount_from+"/"+amount_to+"/"+employee_share+"/"+employer_share+"/"+covered_year,true);
        xmlhttp.send();
    }


 function add_new_pagibig_per_list(val)
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

            document.getElementById("add_edit_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_pagibig_percentage_table/add_new_pagibig_per_list/"+val,true);
        xmlhttp.send();
    }


 function pagibig_percentage_table_list(val)
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
              /*   $("#example1").DataTable({    
                  });
                $('.datatable').DataTable();*/
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_pagibig_percentage_table/pagibig_percentage_table_list/"+val,true);
        xmlhttp.send();
    }

function pagibig_percentage_table()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_pagibig_percentage_table/company_view/",true);
        xmlhttp.send();
    }


//TAX RATES FILTERING BY DATE================================================================================
 // function applyFilterdate(val)
 //    {  
 //      var company_id        = document.getElementById("company_id").value;
 //      var date              = document.getElementById("date").value;
 //      var location          = document.getElementById("location").value;
          
 //      if (window.XMLHttpRequest)
 //        {
 //        xmlhttp=new XMLHttpRequest();
 //        }
 //      else
 //        {// code for IE6, IE5
 //        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 //        }
 //      xmlhttp.onreadystatechange=function()
 //        {
 //        if (xmlhttp.readyState==4 && xmlhttp.status==200)
 //          {
          
 //          document.getElementById("search_here").innerHTML=xmlhttp.responseText;
 //          }
 //        }
 //       xmlhttp.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_rates/taxrates_table_result/"+date+"/"+location+"/"+val,false);
 //      xmlhttp.send();

    
 //    }

//START OF ANNUAL TAX EXCEMPTION=====================================================================


   function tax_exemption_table_edit(val)
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

            document.getElementById("add_edit_exem").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_exemption/tax_exemption_table_edit/"+val,true);
        xmlhttp.send();
    }


function add_new_tax_exemption()
    {   
     var location  = document.getElementById("location_id").value;
     var company_id  = document.getElementById("company_id").value;
   
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

            document.getElementById("add_edit_exem").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_exemption/add_new_tax_exemption/"+location+"/"+company_id,true);
        xmlhttp.send();
    }


function check(){
  checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      }

      else{
        return true;
      }
}


function loadLocationexem(val
)        {  

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
            
             document.getElementById("location").innerHTML=xmlhttp2.responseText;
             $('#location').prop('disabled', false);
             $('#remove_all').prop('disabled', true);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_exemption/load_locations/"+val,false);
        xmlhttp2.send();
        }

   /*function applyFilterbydate()
    {  
    var company    = "<?php echo $company;?>";
    var date      = document.getElementById("date").value;
      alert(company);
      alert(date);  
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
        
        document.getElementById("philhealth_table").innerHTML=xmlhttp.responseText;
        }
      }
     xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/philhealth_table_result/"+company+"/"+date,false);
    xmlhttp.send();
    }
*/


  function applyFilterdates()
    {  
    
      var date      = document.getElementById("date").value;
      var company_id    = document.getElementById("company_id").value;
      var location    = document.getElementById("location_id").value;
          
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
          
          document.getElementById("filter_date").innerHTML=xmlhttp.responseText;
               $("#example1").DataTable({    
                  });
               $('.datatable').DataTable();
          }
        }
       xmlhttp.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_exemption/taxexemption_table_result/"+company_id+"/"+location+"/"+date,false);
      xmlhttp.send();

    
    }
   

function gotoPages(val)
        {  
        //var company   = $('#company').val();

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
            
            document.getElementById("col_3").innerHTML=xmlhttp2.responseText;
               $("#example1").DataTable({    
                  });
               $('.datatable').DataTable();
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_exemption/show_annual_tax_exemption/"+val,false);
        xmlhttp2.send();
        }


function annual_tax_exemption()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_exemption/annual_tax_exemption_view/",true);
        xmlhttp.send();
    }



//START OF ANNUAL TAX RATES===========================================================================
  
    // function tax_rates_table_edit(val)
    // {            
    //     if (window.XMLHttpRequest)
    //       {
    //       xmlhttp=new XMLHttpRequest();
    //       }
    //     else
    //       {// code for IE6, IE5
    //       xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    //       }
    //     xmlhttp.onreadystatechange=function()
    //       {
    //       if (xmlhttp.readyState==4 && xmlhttp.status==200)
    //         {

    //         document.getElementById("add_edit_tax").innerHTML=xmlhttp.responseText;
    //         }
    //       }
    //     xmlhttp.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_rates/tax_rates_table_edit/"+val,true);
    //     xmlhttp.send();
    // }

 // function add_new_tax_rates(val)
 //    {   
 //     var location  = document.getElementById("location").value;         
 //        if (window.XMLHttpRequest)
 //          {
 //          xmlhttp=new XMLHttpRequest();
 //          }
 //        else
 //          {// code for IE6, IE5
 //          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 //          }
 //        xmlhttp.onreadystatechange=function()
 //          {
 //          if (xmlhttp.readyState==4 && xmlhttp.status==200)
 //            {

 //            document.getElementById("add_edit_tax").innerHTML=xmlhttp.responseText;
 //            }
 //          }
 //        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_rates/add_new_tax_rates/"+location+"/"+val,true);
 //        xmlhttp.send();
 //    }

 // function gotoPage(val)
 //        {  
 //        var location  = document.getElementById("location").value;
 //        var company   = $('#company').val();

 //        if (window.XMLHttpRequest)
 //          {
 //          xmlhttp2=new XMLHttpRequest();
 //          }
 //        else
 //          {// code for IE6, IE5
 //          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
 //          }
 //        xmlhttp2.onreadystatechange=function()
 //          {
 //          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
 //            {
            
 //            document.getElementById("col_2").innerHTML=xmlhttp2.responseText;
 //              $("#example1").DataTable({    
 //              });
 //              $('.datatable').DataTable();
 //            }
 //          }
 //        xmlhttp2.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_rates/show_annual_tax_rates/"+val+"/"+location+"/"+company,false);
 //        xmlhttp2.send();
 //        }

 // function loadLocation(val)
 //        {  

 //        if (window.XMLHttpRequest)
 //          {
 //          xmlhttp2=new XMLHttpRequest();
 //          }
 //        else
 //          {// code for IE6, IE5
 //          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
 //          }
 //        xmlhttp2.onreadystatechange=function()
 //          {
 //          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
 //            {
            
 //             document.getElementById("location").innerHTML=xmlhttp2.responseText;
 //             $('#location').prop('disabled', false);
 //             $('#remove_all').prop('disabled', true);
 //            }
 //          }
 //        xmlhttp2.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_rates/load_locations/"+val,false);
 //        xmlhttp2.send();
 //        }


 // function tax_rates_select_option(val)
 //    {            
 //        if (window.XMLHttpRequest)
 //          {
 //          xmlhttp=new XMLHttpRequest();
 //          }
 //        else
 //          {// code for IE6, IE5
 //          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 //          }
 //        xmlhttp.onreadystatechange=function()
 //          {
 //          if (xmlhttp.readyState==4 && xmlhttp.status==200)
 //            {

 //            document.getElementById("col_2").innerHTML=xmlhttp.responseText;

 //            }
 //          }
 //        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_yearly_annual_tax_rates/tax_rates_select_option/"+val,true);
 //        xmlhttp.send();
 //    }




//END OF ANNUAL TAX RATES=============================================================================
  
//===================================START OF LOAN TYPE==============================================
   function loan_table_edit(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_type/loan_table_edit/"+val,true);
        xmlhttp.send();
    }
    function myFunction() {
    document.getElementById("myCheck1").disabled = true;
    document.getElementById("myCheck").disabled = false;
    document.getElementById("chkbox1").checked = false;
}
    function myFunctione() {
    document.getElementById("myCheck1").disabled = false;
    document.getElementById("myCheck").disabled = true;
    document.getElementById("chkbox2").checked = false;
}

  function enableDisable(bEnable, bDisable, myCheck, myCheck1)
    {
         document.getElementById(myCheck).disabled = !bEnable
         document.getElementById(myCheck1).enabled = !bDisable
    }


   function add_new_loan(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_type/add_new_loan/"+val,true);
        xmlhttp.send();
    }

 function loan_type_list(val)
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
        
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_type/loan_type_list/"+val,true);
        xmlhttp.send();
        

    }

  function category_table_edit(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_category/category_table_edit/"+val,true);
        xmlhttp.send();
    }

 function add_new_category(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_category/add_new_category/"+val,true);
        xmlhttp.send();
    }

function loan_type_category_view(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_category/loan_type_category_view/"+val,true);
        xmlhttp.send();
    }

 function loan_type_select_option(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_type/loan_type_select_option/"+val,true);
        xmlhttp.send();
    }


function loan_types()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_type/loan_type_view/",true);
        xmlhttp.send();
    }
//=========================================END of LOAN TYPE==================================================
//========================================START FOR OTHER DEDUCTIONS============================================
 


 function deduction_list_table_edit(val)
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

            document.getElementById("add_edit_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_deductions/deduction_list_table_edit/"+val,true);
        xmlhttp.send();
    }

  function add_new_deduction_list(val)
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

            document.getElementById("add_edit_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_deductions/add_new_deduction_list/"+val,true);
        xmlhttp.send();
    }

 function other_deduction_list(val)
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

        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_deductions/other_deduction_list/"+val,true);
        xmlhttp.send();

   
    }

    function deduction_category_table_edit(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_deductions/deduction_category_table_edit/"+val,true);
        xmlhttp.send();
    }

 function add_new_deduction_category(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_deductions/add_new_deduction_category/"+val,true);
        xmlhttp.send();
    }


  function other_deduction_category_view(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_deductions/other_deduction_category_view/"+val,true);
        xmlhttp.send();
    }

   function other_deduction_select_option(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_deductions/other_deduction_select_option/"+val,true);
        xmlhttp.send();
    }

 function other_deductions()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_deductions/other_deductions_view/",true);
        xmlhttp.send();
    }
//=========================================END OF OTHER DEDUCTIONS==============================================


//=========================================START FOR OTHER ADDITIONS============================================
//LIST OF OTHER ADDITIONS+++++++++++++++++++++++++++++++++++++++++++++++++++++
 function addition_list_table_edit(val)
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

            document.getElementById("add_edit_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_additions/addition_list_table_edit/"+val,true);
        xmlhttp.send();
    }

 function myFunctiontax() {
  if(document.getElementById('myCheck').checked) {
    document.getElementById("myText").value = "1";
  }
  else{
    document.getElementById("myText").value = "0";
  }
}
 function myFunctionnontax() {
  if(document.getElementById('myCheck1').checked) {
    document.getElementById("myText1").value = "1";
  }
  else{
    document.getElementById("myText1").value = "0";
  }
}
function myFunctionbonus() {
  if(document.getElementById('myCheck2').checked) {
    document.getElementById("myText2").value = "1";
  }
  else{
    document.getElementById("myText2").value = "0";
  }
}
 function myFunctionmonthpay() {
  if(document.getElementById('myCheck3').checked) {
    document.getElementById("myText3").value = "1";
  }
  else{
    document.getElementById("myText3").value = "0";
  }
}
function myFunctionbasic() {
  if(document.getElementById('myCheck4').checked) {
    document.getElementById("myText4").value = "1";
  }
  else{
    document.getElementById("myText4").value = "0";
  }
}
 function myFunctionot() {
  if(document.getElementById('myCheck5').checked) {
    document.getElementById("myText5").value = "1";
  }
  else{
    document.getElementById("myText5").value = "0";
  }
}function myFunctionleave() {
  if(document.getElementById('myCheck6').checked) {
    document.getElementById("myText6").value = "1";
  }
  else{
    document.getElementById("myText6").value = "0";
  }
}
 function myFunctionexclude() {
  if(document.getElementById('myCheck7').checked) {
    document.getElementById("myText7").value = "1";
  }
  else{
    document.getElementById("myText7").value = "0";
  }
}
   function add_new_addition_list(val)
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

            document.getElementById("add_edit_table").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_additions/add_new_addition_list/"+val,true);
        xmlhttp.send();
    }

   function other_addition_list(val)
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
                 fixedHeader: {
            header: true,
            footer: true
        } });
               $('.datatable').DataTable();
            }
          }
        
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_additions/other_addition_list/"+val,true);
        xmlhttp.send();
        

    }



//OTHER ADDITION CATEGORY++++++++++++++++++++++++++++++++++++++++++++++++++++

   function addition_category_table_edit(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_additions/addition_category_table_edit/"+val,true);
        xmlhttp.send();
    }

    function trim(el) {
    el.value = el.value.
    replace(/(^\s*)|(\s*$)/gi, ""). // removes leading and trailing spaces
    replace(/[ ]{2,}/gi, " "). // replaces multiple spaces with one space 
    replace(/\n +/, "\n"); // Removes spaces after newlines
    return;
}
 function add_new_addition_category(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_additions/add_new_addition_category/"+val,true);
        xmlhttp.send();
    }

    function other_addition_select_option(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_additions/other_addition_select_option/"+val,true);
        xmlhttp.send();
    }

function other_addition_category_view(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_additions/other_addition_category_view/"+val,true);
        xmlhttp.send();
    }

 function other_additions()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance_additions/other_additions_view/",true);
        xmlhttp.send();
         
    }

//============================================END FOR OTHER ADDITIONS====================================================
    function sss_company()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/sss_company_view/",true);
        xmlhttp.send();
    }

    function philhealth_company()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/philhealth_company_view/",true);
        xmlhttp.send();
    }

    function pagibig_company()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/pagibig_company_view/",true);
        xmlhttp.send();
    }

    function employee_pagibig_setting_company()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/employee_pagibig_setting_company_view/",true);
        xmlhttp.send();
    }
//hanggang dito=============================================================================================================

    function sss_company()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/sss_company_view/",true);
        xmlhttp.send();
    }

    function philhealth_company()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/philhealth_company_view/",true);
        xmlhttp.send();
    }

    function pagibig_company()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/pagibig_company_view/",true);
        xmlhttp.send();
    }

    function employee_pagibig_setting_company()
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/employee_pagibig_setting_company_view/",true);
        xmlhttp.send();
    }

    //========================================PAYROLL EMPLOYEE SETTING=================================================

    function getCompany_employeeSetting(val)
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

            document.getElementById("company_employee_setting").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/getCompany_employeeSetting_view/"+val,true);
        xmlhttp.send();
    }

 function fetch_cutoff_types()
        {          
             var pay_type = document.getElementById("pay_type").value;   
             //var company_id = document.getElementById("company_id").value;        
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
            
            document.getElementById("cutoff").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_file_maintenance/show_cutoff_option/"+pay_type,true);
        xmlhttp.send();

        }
    //=====================================END of PAYROLL EMPLOYEE SETTING=============================================
    
</script>

<!-- END SCRIPT -->



<!-- FILE MAINTENANCE LIST ================================================================================================= -->
        <div class="col-md-9" id="col_2"></div>
        </div>
      </div><!-- /.box-body -->
       
      <!-- Loading (remove the following to stop the loading)-->   
      <div class="overlay" hidden="hidden" id="loading">
      <i class="fa fa-spinner fa-spin"></i>
      </div>
      <!-- ./ end loading -->

             


  <?php require_once(APPPATH.'views/include/footer.php');?></div>
    <!-- REQUIRED JS SCRIPTS -->



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


