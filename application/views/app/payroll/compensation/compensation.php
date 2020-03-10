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
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />

    
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
    <small>Compensation</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Payroll</li>
    <li class="active">Compensation</li>
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
            <div class="panel-heading"><strong>COMPENSATION</strong></div>
            <div class="btn-group-vertical btn-block">

                <a onclick="salary_reason_management()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Salary Reason Management</strong></p></a>
                <a onclick="salary_management()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Salary Management</strong></p></a>
                <a onclick="salary_management_manual_upload()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Salary Information Manual Upload</strong></p></a>
                <a onclick="salary_management_gov_default()" type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Goverment Subject To Default Value</strong></p></a>
            </div>  
           </div>             
          </div> <!-- box box-primary -->  
        </div> <!-- col-md-4 -->     
     <!-- </div>  row -->


<style>

    .scrollbar_all {

      height: 400px;
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

    //======================================= SALARY REASON MANAGEMENT ============================================

      function salary_reason_management()
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
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/salary_reason_management_view/",true);
          xmlhttp.send();
      }

      function get_company_reason(val)
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

              document.getElementById("company_reason").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/company_reason_view/"+val,true);
          xmlhttp.send();
      }

    

      function salary_reason_add(val)
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

              document.getElementById("company_reason").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/salary_reason_add_view/"+val,true);
          xmlhttp.send();
      }

      function salary_reason_edit(val)
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

              document.getElementById("company_reason").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/salary_reason_edit_view/"+val,true);
          xmlhttp.send();
      }


      //==================================== END OF SALARY REASON MANAGEMENT ======================================
      
      //=========================================== SALARY MANAGEMENT  ============================================

      function salary_management()
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
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/salary_management_view/",true);
          xmlhttp.send();
      }

//NEMZ addional code in COMPENSATION=================================
        function trim(el) {
          el.value = el.value.
          replace(/(^\s*)|(\s*$)/gi, ""). // removes leading and trailing spaces
          replace(/[ ]{2,}/gi, " "). // replaces multiple spaces with one space 
          replace(/\n +/, "\n"); // Removes spaces after newlines
          return;
      }

       function salary_management_gov_default()
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
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/salary_management_gov_default_value/",true);
          xmlhttp.send();
      }

       function get_company_loc_default_value(val)
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
              document.getElementById("loc_default_value").innerHTML=xmlhttp.responseText;
              $("#example1").DataTable({       
              });
              $('.datatable').DataTable();
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/company_location_view/"+val,true);
          xmlhttp.send();
      }


       function checked_all_loc_gov(val)
      { 
        window.location.reload();
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
              document.getElementById("loc_default_value").innerHTML=xmlhttp.responseText;
              $("#example1").DataTable({       
              });
              $('.datatable').DataTable();
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/checked_all_loc_gov/"+val,true);
          xmlhttp.send();
      }

      function confirm_apply_emp_gov_contri() {
        return confirm('Are you sure?');

      }

      function gov_default_add(company,location)
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

            document.getElementById("add_edit").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/gov_default_add/"+company+"/"+location,true);
        xmlhttp.send();
    }

    function gov_default_edit(val)
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

            document.getElementById("add_edit").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/gov_default_edit/"+val,true);
        xmlhttp.send();
    }

//END OF NEMZ CODE============================================================

      function get_company_employee(val)
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
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/company_employee_view/"+val,true);
          xmlhttp.send();
      }

      function view_employee_salary(val)
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
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/employee_salary_view/"+val,true);
          xmlhttp.send();
      }

      function add_employee_salary(val)
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
              document.getElementById("add_employee_salary").innerHTML=xmlhttp.responseText;
              $('#date_effective').Zebra_DatePicker();
            }
          }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/employee_salary_add/"+val,true);
          xmlhttp.send();
      }

      function edit_government_deduction(val){

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
              document.getElementById("edit_government").innerHTML=xmlhttp.responseText;
              
            }
          }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/employee_government_deduction_edit/"+val,true);
          xmlhttp.send();

      }

      function view_salary_history(val)
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
              document.getElementById("add_employee_salary").innerHTML=xmlhttp.responseText;
            }
          }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/employee_salary_history/"+val,true);
          xmlhttp.send();
      }

      function check_decimal(val)
      { 
        var decimal = document.getElementById("decimal_places").value;
        alert(decimal);

        var val = val - decimal;
        document.getElementById("salary_amount").value = val;



      }



  
      function removeDes(me)
    {
       var decimals = document.getElementById("decimal_places").value;
       
      var txt = me.value;
        if(txt.indexOf(".")>-1 && txt.split(".")[1].length>decimals)
        {
          var substr = txt.split(".")[1].substring(0,decimals);
           me.value = txt.split(".")[0]+"."+substr;
        }
    }

      function def_value(val){
      document.getElementById("is_checked").value = val;

      }
       function change_value(){
    
          $("#checkss").click(function () {

            if (!$(this).is(':checked')) {
                $("#is_checked").val("0");
            }else{
              $("#is_checked").val("1");
            }
        });

      }

      function labas_monthly()
      { 

        var val = document.getElementById("is_checked").value;
       
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
              document.getElementById("labas_monthly").innerHTML=xmlhttp.responseText;
            }
          }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/labas_monthly/"+val,true);
          xmlhttp.send();
      }



      
      function view_salary_computation(val)
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
              document.getElementById("salary_compuation").innerHTML=xmlhttp.responseText;
            }
          }
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/employee_salary_computation/"+val,true);
          xmlhttp.send();
      }

      //salary information mass upload
       function salary_management_manual_upload()
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
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/salary_information_manualupload/",true);
          xmlhttp.send();
      }

       function myFunction() {
        if(document.getElementById("action").value =='Save')
        {
            alert("NOTE: If there's a downloaded file open/check it to correct the template!");
           
         }
         else{}
      }
  
    $(document).ready(function(){
        if($(".has-warning").value()){
          $("#submit").removeAttr("disabled");
                };
                });


     function with_approvers_option(val)
    {
      document.getElementById('with_approvers_value').value=val;

      if(val=='yes')
      {
        $('#view_approver_type').show();
        var data = document.getElementById('setup_approver_option').value;
       
        if(data==0)
        {
           $('#approver_error_msg').show();
           $('#submitt').hide();
        }
        else
        {
           $('#approver_error_msg').hide();
           $('#submitt').show();
        }
      }
      else
      {
        $('#view_approver_type').hide();
         $('#submitt').show();
      }
    }

    function approvers_value(val,option)
    {

      var data = document.getElementById('approver_type_value').value=val;
      var datas = document.getElementById(option).value;
     
      if(datas==0)
      {
         $('#approver_error_msg').show();
         $('#submitt').hide();

      }
      else
      {
         $('#approver_error_msg').hide();
         $('#submitt').show();
      }
    }

     function update_employee_salary(salary_id,employee_id){

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
          xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/update_employee_salary/"+salary_id+"/"+employee_id,true);
          xmlhttp.send();

      }


      function save_update_salary_information(salary_id,company,employee)
      {
          var date = document.getElementById('effective_date').value;
          var salary_rate = document.getElementById('salary_rate').value;
          var amount = document.getElementById('sal_amount').value;
          var hours = document.getElementById('no_hours').value;
          var month = document.getElementById('no_month').value;
          var years = document.getElementById('no_yrs').value;
          var reason = document.getElementById('reason').value;

          if(document.getElementById('fixed_yes').checked==true)
            { var fixed = 1; } else{ var fixed = 0; }

          if(document.getElementById('withholding_tax').checked==true)
            { var withholding_tax = 1; } else{ var withholding_tax = 0; }

          if(document.getElementById('pagibig').checked==true)
            { var pagibig = 1; } else{ var pagibig = 0; }

          if(document.getElementById('sss').checked==true)
            { var sss = 1; } else{ var sss = 0; }

          if(document.getElementById('philhealth').checked==true)
            { var philhealth = 1; } else{ var philhealth = 0; }
          
          if(date=='' || salary_rate=='' || amount=='' || hours=='' || month=='' || years=='' || reason==''){ alert('Fill up all required fields to continue'); }
          else{
          
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
              xmlhttp.open("GET","<?php echo base_url();?>app/payroll_compensation/save_update_salary_information/"+salary_id+"/"+company+"/"+employee+"/"+date+"/"+salary_rate+"/"+amount+"/"+hours+"/"+month+"/"+years+"/"+reason+"/"+fixed+"/"+withholding_tax+"/"+pagibig+"/"+sss+"/"+philhealth,true);
              xmlhttp.send();
          }

      }
      //======================================= END OF SALARY MANAGEMENT ==========================================

    </script>
    <!-- END OF SCRIPT -->

<!-- PAYROLL INCENTIVE LEAVE =============================================================================== -->
        <div class="col-md-9" id="col_2"></div>
        </div>
      </div><!-- /.box-body -->
       
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
    <script src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>
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
