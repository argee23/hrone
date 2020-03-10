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
    Administrator
    <small>Leave Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Administrator</li>
    <li class="active">Leave Management</li>
  </ol>
</section>

      <div class="container-fluid">
         
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">
          <!-- Stacked Buttons -->
          <div class="col-md-6">
              
    <div class="box box-warning">
      <!-- Default panel contents -->

      <div class="panel-heading"><strong>
               
             <label>Leave Management</label>
                <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="fetch_comp_leave(this.value)">
                <option selected="selected" disabled="disabled" value="0">- Select Company -</option>
                  <?php 
                    foreach($companyList as $company){
                    if($_POST['company'] == $company->company_id){
                        $selected = "selected='selected'";
                    }
                    else{
                        $selected = "";
                    }
                  ?>
                <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                  <?php }?>
                </select>
                <br>
        


      </strong>
      </div>
<div  id="companyleavelist">

<br>
        </div>   
    </div>

          </div>

<!-- 
  <div class='col-md-6'><div class='panel panel-info'><div class='panel-heading'><strong>title</strong>  </div>
<div class='panel-body'>body</div></div></div>      -->
      
<script>

<!--//======================   Leave Management //-->
 function disable_effectivity_datepicker()
        {          
           $("#effectivity_datepicker").attr('disabled','disabled');        
      }
function disable_effectivity_dropdown()
  {          
     $("#effectivity_dropdown").attr('disabled','disabled');        
}
function confirm_remove_settings()
  { 
  return confirm("Are you sure you want to remove settings?");  
  } 
function confirm_remove_years_settings()
  { 
  return confirm("Are you sure you want to remove settings?");  
  } 
function enable_select_date(status)
{
status==status; 
  document.f1.start_month.disabled = status;
  document.f1.start_day.disabled = status;
  document.f1.end_month.disabled = status;
  document.f1.end_day.disabled = status;
}
function addYear() {
    var lastRow = document.getElementById('counter').value; 
    var table = document.getElementById("myTable");
    var row = table.insertRow(0);
    var cell1 = row.insertCell(0);
    var extension;
     if(lastRow==1){extension="st";}
  else if(lastRow==2){extension="nd";}
  else if(lastRow==3){extension="rd";}
  else{extension="th";}

    cell1.innerHTML = "<div class='col-md-12'><div class='panel panel-info'><div class='panel-heading'><strong>"+lastRow+ extension +"&nbsp;Year Auto Increment</strong></div><div class='panel-body'>          <div class='form-group'><label class='col-sm-2 control-label'>Increment</label><div class='col-sm-10'><select name='increment"+lastRow+"' class='form-control' required><option value='' selected disabled>SET</option><?php $increment=0; while($increment<12){?><option value='<?php echo $increment+=1;?>'>every <?php echo $increment;?> month</option><?php } $increment=0;?></select></div></div>          <div class='form-group'><label class='col-sm-2 control-label'>Credit</label><div class='col-sm-10'><input type='number' step='any' class='form-control' name='leave_balance" + lastRow + "' required></div></div>        <div class='form-group'><label class='col-sm-2 control-label'>Max</label><div class='col-sm-10'><input  type='number' step='any' class='form-control' name='max" + lastRow + "' required placeholder='enter maximum credit that is allowed to reach.'></div></div>                  </div></div></div>";

      document.getElementById('counter').value = Number(document.getElementById('counter').value) + 1;
}

// remodified sa funct addYear
//<div class='form-group'><label class='col-sm-2 control-label'>Carry Over</label><div class='col-sm-10'><select name='replenish"+lastRow+"' class='form-control'><option value=''>SELECT</option><option value='1'>YES</option><option value='0'>NO</option></select></div></div>

function delYear() {
  var lastRow = document.getElementById('counter').value; 
   document.getElementById("myTable").deleteRow(0);
   if(lastRow>0){
document.getElementById('counter').value = Number(document.getElementById('counter').value) - 1;
}
}

function editLeave(val,company_id)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_management/edit_leave_type/"+val+"/"+company_id,true);
        xmlhttp.send();

        }
 // function leave_manage_manual_credit(val,company_id)
 //        {          
            
 //       //var company_id = document.getElementById("company_id").value;
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
 //        xmlhttp.open("GET","<?php //echo base_url();?>app/leave_management/leave_manage_manual_credit/"+val+"/"+company_id,true);
 //        xmlhttp.send();

 //        }
 function leave_manage_condition(val,company_id)
        {          
            
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_management/leave_manage_condition/"+val+"/"+company_id,true);
        xmlhttp.send();

        }

 function dl_upl_leavecredit(val,company_id)
        {          
            
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
            
            document.getElementById("col_2").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_management/dl_upl_leavecredit/"+val+"/"+company_id,true);
        xmlhttp.send();

        }



        
function editYearCondition(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_management/edit_year_condition/"+val,true);
        xmlhttp.send();

        }
 function applied_condition(val)
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
            
            document.getElementById("col_4").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_management/applied_condition/"+val,true);
        xmlhttp.send();

        }
 function fetch_comp_leave(val)
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
            
            document.getElementById("companyleavelist").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/leave_management/leave_type_list2/"+val,true);
        xmlhttp.send();

        }

  function disable_anniv_checkbox()
        {          
         // $('#yearly_fixed_credit_on_anniv_eff').uncheck();      
          $("#yearly_fixed_credit_on_anniv_eff").prop("checked", false);
      }
  function disable_inc_what_day()
        {          
          $('#remove_all_inc_setup').hide();     
          $('#yearly_inc_what_day').hide();     
          $('#for_yearly_fixed_credit').show();    
          $('#fc_value').show();               
          $('#addyear_button').hide();      
          $('#delyear_button').hide();     
          $('#myTable_content').hide();  
      }
  function enable_inc_what_day()
        {          
          $('#remove_all_inc_setup').show();   
          $('#yearly_inc_what_day').show();   
          $('#for_yearly_fixed_credit').hide();  
          $('#fc_value').hide();           
          $('#addyear_button').show();      
          $('#delyear_button').show();   
           $('#myTable_content').show();   
      }

<!--//======================   End Leave Management //-->     
</script>
                        <div class="col-md-6" id="col_2">  
                    </div>
                </div>
            </div><!-- /.box-body -->
             
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
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo base_url()?>public/plugins/iCheck/icheck.min.js"></script>

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }

      $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

            //Datemask dd/mm/yyyy
            $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            //Datemask2 mm/dd/yyyy
            $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
            //Money Euro
            $("[data-mask]").inputmask();

            //Date range picker
            $('#reservation').daterangepicker();
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                  },
                  startDate: moment().subtract(29, 'days'),
                  endDate: moment()
                },
            function (start, end) {
              $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            );

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass: 'iradio_minimal-blue'
            });
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
              checkboxClass: 'icheckbox_minimal-red',
              radioClass: 'iradio_minimal-red'
            });
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
              checkboxClass: 'icheckbox_flat-green',
              radioClass: 'iradio_flat-green'
            });

            //Colorpicker
            $(".my-colorpicker1").colorpicker();
            //color picker with addon
            $(".my-colorpicker2").colorpicker();

            //Timepicker
            $(".timepicker").timepicker({
              showInputs: false
            });
          });
    </script>


  </body>
</html>