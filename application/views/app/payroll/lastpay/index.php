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
    <!-- Vex -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    
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
      Payroll
       <small>Generate Last Pay</small>
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Payroll</li>
    <li class="active">Generate Last Pay</li>
  </ol>

  <?php echo $message ?>
</section>
  <!-- Main content -->
  <section class="content">

  <div class="box box-primary">
    <div class="box-header with-title bg-warning">
      <h3 class="box-title">Choose Company</h3>

      <div class="box-tools pull-right">
      </div>
    </div>

    <div class="panel-body">
                <div class="col-md-3">
                          <div class="btn-group-vertical btn-block">

                          <?php 
                              foreach($companyList as $loc){
                                  echo "<a onclick='view(".$loc->company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_code."</strong></p></a>";
                              }
                          ?>
                          </div>

                </div>
                <div class="col-md-9" id="col_2">
                </div>      
    </div>


  </div>
 <!--//======================================Employee List Modal Container ==============================//-->
<div class="modal modal-primary fade" id="showEmployeeList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                </div>
          <div class="modal-body">
                                           
  <input onKeyUp="getEmployeeList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                        <span id="showSearchResult">                        </span>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>                          
                  </div>
                </div>
            </div><!-- /.box-body -->
<!--//====================================== End Employee List Modal Container ==============================//-->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->





<footer class="footer ">
<div class="container-fluid">

<strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.


<div class="text-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</div>
</div>
</footer>
    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <!-- Bootstrap Select -->
    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Vex -->
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script> 
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>

    <script>
//     $( function() {
//       $(".selectpicker").selectpicker();

//       $("#search_company").keyup(function(){
//         var val = $("#search_company").val();

//         $("#show_here").load("<?php echo base_url()?>app/payroll_formula/search_company_onkeyup/"+val);
//       })

//       $('#btnAddVar').click(function(e){
//         e.preventDefault();
//         if(!$("#variable_abbrv").val()){
//           vex.dialog.alert("Variable Abbreviation Field Is Empty!")
//           return false
//         }else if(!$("#variable_name").val()){
//           vex.dialog.buttons.NO.text = 'Back';
//           vex.dialog.alert("Variable Name Field Is Empty!")
//           return false
//         }else{
//           var abbrv = $("#variable_abbrv").val();
//           var name = $("#variable_name").val();
//           vex.dialog.buttons.YES.text = 'Yes, Go Ahead';
//           vex.dialog.buttons.NO.text = 'No';
//           vex.dialog.confirm({
//                   message: 'Are you sure you want to add '+abbrv+' - '+name+' to payroll formula variables?',
//                   callback: function(value) {
//                   if(value === true) {
//                     $(".overlay").removeClass("hidden");
//                     $('#add_var').submit() 
//                   } else {
//                     // cancel;
//                     return false;
//                   }
//                   }
//               });
//           }
//       });

//       $(".edit_var").click(function(){
//         var id = $(this).attr("id");

//         $("#edit_var_here").load("<?php echo base_url()?>app/payroll_formula/get_var_edit/"+id);
//       });

//       $('#btnEditVar').click(function(e){
//         e.preventDefault();
//         if(!$("#variable_abbrv_edit").val()){
//           vex.dialog.alert("Variable Abbreviation Field Is Empty!")
//           return false
//         }else if(!$("#variable_name_edit").val()){
//           vex.dialog.buttons.NO.text = 'Back';
//           vex.dialog.alert("Variable Name Field Is Empty!")
//           return false
//         }else{
//           var abbrv = $("#variable_abbrv_edit").val();
//           var name = $("#variable_name_edit").val();
//           vex.dialog.buttons.YES.text = 'Yes, Go Ahead';
//           vex.dialog.buttons.NO.text = 'No';
//           vex.dialog.confirm({
//                   message: 'Are you sure you want to modify as '+abbrv+' - '+name+' to payroll formula variables?',
//                   callback: function(value) {
//                   if(value === true) {
//                     $(".overlay").removeClass("hidden");
//                     $('#edit_var_form').submit() 
//                   } else {
//                     // cancel;
//                     return false;
//                   }
//                   }
//               });
//           }
//       });

//       $("#formula_for").change(function(){        

//         var formula_for = $("#formula_for option:selected").text();
//         $("#var_for").val(formula_for);
//       });

//       $(".variable").click(function(e){
//         e.preventDefault();

//         var id = $(this).attr("id");
//         var formula_desc = $("#formula_description").val();
//         var val = $(this).val();
//         var formula = $("#formula").val();

//         var formula_description = formula_desc+" "+id;
//         var formula_full = formula+" "+val;

//         $("#formula_description").val(formula_description);
//         $("#formula").val(formula_full);
//       });

//       $("#reset_formula").click(function(e){
//         e.preventDefault();
//         $("#formula_description").val('');
//         $("#formula").val('');
//       })

//       $('#btnAddFormula').click(function(e){
//         e.preventDefault();
//         if(!$("#formula_tier").val()){
//           vex.dialog.alert("Please Select Formula Tier!")
//           return false
//         }else if(!$("#formula_for").val()){
//           vex.dialog.buttons.NO.text = 'Back';
//           vex.dialog.alert("Please Select Formula For!")
//           return false
//         }else if(!$("#formula").val()){
//           vex.dialog.buttons.NO.text = 'Back';
//           vex.dialog.alert("No formula created!")
//           return false
//         }else{
//           vex.dialog.buttons.YES.text = 'Yes, Go Ahead';
//           vex.dialog.buttons.NO.text = 'No';
//           vex.dialog.confirm({
//                   message: 'Are you sure you want to add payroll formula?',
//                   callback: function(value) {
//                   if(value === true) {
//                     $(".overlay").removeClass("hidden");
//                     $('#add_formula').submit() 
//                   } else {
//                     // cancel;
//                     return false;
//                   }
//                   }
//               });
//           }
//       });
//     });

//       $('.delete_formula').click(function(e){
//         e.preventDefault();
//         var id = $(this).attr("id");
//           vex.dialog.buttons.YES.text = 'Yes, Go Ahead';
//           vex.dialog.buttons.NO.text = 'No';
//           vex.dialog.confirm({
//                   message: 'Are you sure you want to delete formula?',
//                   callback: function(value) {
//                   if(value === true) {
//                     $(".overlay").removeClass("hidden");
//                     window.location = "<?php echo base_url()?>app/payroll_formula/delete_formula/"+id;
//                   } else {
//                     // cancel;
//                     return false;
//                   }
//                   }
//               });
//       });

//      function getFormulaSetup(){
        
//         if(!$("#location_id").val()){
//           vex.dialog.alert("No Location Selected!")
//           return false
//         }else if(!$("#classification_id").val()){
//           vex.dialog.buttons.NO.text = 'Back';
//           vex.dialog.alert("No Classification Selected!")
//           return false
//         }else if(!$("#employment_id").val()){
//           vex.dialog.buttons.NO.text = 'Back';
//           vex.dialog.alert("No Employment Type Selected!")
//           return false
//         }else if(!$("#pay_type_id").val()){
//           vex.dialog.buttons.NO.text = 'Back';
//           vex.dialog.alert("No Pay Type Selected!")
//           return false
//         }else{

//           var company = $("#company_id").val();
//           var location = $("#location_id").val();
//           var classification = $("#classification_id").val();
//           var employment = $("#employment_id").val();
//           var pay_type = $("#pay_type_id").val();
//           var salary_rate = $("#salary_rate_id").val();

//           window.location = "<?php echo base_url()?>app/payroll_formula/view_formula_setup/"+company+"/"+location+"/"+classification+"/"+employment+"/"+pay_type+"/"+salary_rate;
//           }
//       };


// // ===============================================

function autoload()
{
  getEmployeeList(''); 
}
function getEmployeeList(val)
{ 
  var info = $('#company_id').val();
          //var cSearch = document.getElementById("cSearch").value;
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
    document.getElementById("showSearchResult").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_lastpay/showSearchEmployee/"+val+"/"+info,true);
  xmlhttp.send();
}

function select_emp(val)
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
            
            document.getElementById("show_selected_emp").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/payroll_generate_lastpay/select_emp/"+val,false);
        xmlhttp2.send();

        }

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
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_lastpay/view_option/"+val,true);
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_lastpay/show_section/"+department_id,true);
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_lastpay/show_sub_section/"+section,true);
        xmlhttp.send();

        }



//     function manage_formula(val)
//         {            
//         if (window.XMLHttpRequest)
//           {
//           xmlhttp=new XMLHttpRequest();
//           }
//         else
//           {// code for IE6, IE5
//           xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//           }
//         xmlhttp.onreadystatechange=function()
//           {
//           if (xmlhttp.readyState==4 && xmlhttp.status==200)
//             {

//             document.getElementById("col_2").innerHTML=xmlhttp.responseText;
//             }
//           }
//         xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_13th_month/manage_formula/"+val,true);
//         xmlhttp.send();

//         }

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
            
            document.getElementById("show_pay_period_group").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_lastpay/comp_payroll_period_group/"+company_id+"/"+pay_type,true);
        xmlhttp.send();

        }
 function fetch_payroll_period()
        {          
             var pay_type_group = document.getElementById("pay_type_group").value;    
             var pay_type = document.getElementById("pay_type").value;     
             var company_id = document.getElementById("company_id").value;    
             var payroll_option = document.getElementById("payroll_option").value;  
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
            
            document.getElementById("show_pay_period").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_lastpay/comp_payroll_period/"+company_id+"/"+pay_type+"/"+pay_type_group+"/"+payroll_option,true);
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
        xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_lastpay/show_div_dept/"+company_id+"/"+division_id,true);
        xmlhttp.send();

        }


//  function fetch_payroll_period_individual(company_id,pay_type,pay_type_group)
//         {          
//              // var pay_type_group = document.getElementById("pay_type_group").value;    
//              // var pay_type = document.getElementById("pay_type").value;     
//              // var company_id = document.getElementById("company_id").value;     
//              var payroll_option = document.getElementById("payroll_option").value;  
//         if (window.XMLHttpRequest)
//           {
//           xmlhttp=new XMLHttpRequest();
//           }
//         else
//           {// code for IE6, IE5
//           xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//           }
//         xmlhttp.onreadystatechange=function()
//           {
//           if (xmlhttp.readyState==4 && xmlhttp.status==200)
//             {
            
//             document.getElementById("show_pay_period").innerHTML=xmlhttp.responseText;
//             }
//           }
//         xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_13th_month/comp_payroll_period_individual/"+company_id+"/"+pay_type+"/"+pay_type_group+"/"+payroll_option,true);
//         xmlhttp.send();

//         }


//  function clear_fetched_sub_sec()
//         {             
//         if (window.XMLHttpRequest)
//           {
//           xmlhttp=new XMLHttpRequest();
//           }
//         else
//           {// code for IE6, IE5
//           xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//           }
//         xmlhttp.onreadystatechange=function()
//           {
//           if (xmlhttp.readyState==4 && xmlhttp.status==200)
//             {
            
//             document.getElementById("show_sub_section").innerHTML=xmlhttp.responseText;
//             }
//           }
//         xmlhttp.open("GET","<?php echo base_url();?>app/payroll_generate_13th_month/clear_fetched_sub_sec/",false);
//         xmlhttp.send();

//         }



//   function disable_group_process()
//         {          
             
//           $("#pay_type").attr('disabled','disabled');  
//           $("#pay_type_group").attr('disabled','disabled');  
  
//           $('#pay_type_holder').hide();     
 
//           $('#employee_group_holder').hide();  
//           $('#loc_hide').hide();     
 
//       }




    </script>

  </body>
</html>