<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
     <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
<style type="text/css">
  .sss_logo{
    width: 6%;
  }
  .pi_logo{
    width: 6%;
  }
</style>

  </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar.php');?>
<body>

<!-- Start Content Wrapper. Contains page content -->
<div class="content-wrapper2">
<!-- Start Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Reports
       <small>Payroll</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="">Payroll</a></li>
      <li class="active">Payroll Summary</li>
    </ol>
  </section>
  <br>

  <!--  Start Company dropdown   -->
   <div class="col-sm-4">
      <div class="box box-solid box-success">
        <div class="box-header">
        <h5 class="box-title"><i class='fa fa-calendar'></i> <span>Regular Payroll Reports</span></h5>
       </div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
<?php 
$oa="Other Additions";
$od="Other Deductions";
$late="Late";
$ut_rep="Undertime";
$overbreak_rep="Overbreak";
$abs_rep="Absent";
$nd_rep="Regular Night Differential";
$ot_rep="Overtime";
$pagibig_rep="Pagibig";
$sss_rep="SSS";
$phi_rep="Philhealth";
$pagibig_g_rep="Pagibig Monthly";
$sss_g_rep="SSS Monthly";
$pagibig_cert="Pagibig Certificate";
$sss_cert="SSS Certificate";
$sss_dat_file="SSS Dat File";
$sss_trans_rep="SSS Transmittal Report";
$sss_r3="R-3 ( Contribution collection list )";
$sss_r1="R-1A";
$pagibig_mcrf="Member's Contribution Remittance Form ( MCRF )";
$pagibig_mrrf="Membership Registration/Remittance Form ( MRRF )";
$ph_g_rep="Philhealth Monthly";
$ph_cert="Philhealth Certificate";
$pay_reg_rep="Payroll Register";
$bank_file_rep="Bank File";
$loan_report="Loan Report";

$payslip_viewed="Payslip View/Acknowledge Report";
$salary_information="Salary Information";
?>
<!-- 
=======================================================================================
OTHER ADDITIONS
=======================================================================================
 -->
<ul class="nav nav-pills nav-stacked">  
<li class="bg-success"><?php echo $oa;?></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('other_addition');"><i class='fa fa-calendar'></i> <span><?php echo $oa;?> Crystal Report</span></a></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('other_addition');"><i class='fa fa-calendar'></i> <span>Generate <?php echo $oa;?> Report</span></a></li>


<!-- 
=======================================================================================
OTHER DEDUCTIONS
=======================================================================================
 -->
<li class="bg-success"><?php echo $od;?></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('other_deduction');"><i class='fa fa-clock-o'></i> <span><?php echo $od;?> Crystal Report</span></a></li>

  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('other_deduction');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $od;?> Report</span></a></li>

<!-- 
=======================================================================================
late
=======================================================================================
 -->
<li class="bg-success"><?php echo $late;?></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('late');"><i class='fa fa-folder-open'></i> <span><?php echo $late;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('late');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $late;?> Report</span></a></li>

<!-- 
=======================================================================================
undertime
=======================================================================================
 -->
<li class="bg-success"><?php echo $ut_rep;?></li>
  <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('undertime');"><i class='fa fa-folder-open'></i> <span><?php echo $ut_rep;?>Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('undertime');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $ut_rep;?> Report</span></a></li>

<!-- 
=======================================================================================
overbreak
=======================================================================================
 -->

<li class="bg-success"><?php echo $overbreak_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('overbreak');"><i class='fa fa-folder-open'></i> <span><?php echo $overbreak_rep;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('overbreak');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $overbreak_rep;?> Report</span></a></li>

<!-- 
=======================================================================================
Absent
=======================================================================================
 -->
<li class="bg-success"><?php echo $abs_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('absent');"><i class='fa fa-folder-open'></i> <span><?php echo $abs_rep;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('absent');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $abs_rep;?> Report</span></a></li>

<!-- 
=======================================================================================
Working Schedule ND
=======================================================================================
 -->
<li class="bg-success"><?php echo $nd_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('regular_nd');"><i class='fa fa-folder-open'></i> <span><?php echo $nd_rep;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('regular_nd');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $nd_rep;?> Report</span></a></li>
<!-- 
=======================================================================================
Overtime
=======================================================================================
 -->
<li class="bg-success"><?php echo $ot_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('overtime');"><i class='fa fa-folder-open'></i> <span><?php echo $ot_rep;?> Crystal Report</span></a></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('overtime');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $ot_rep;?> Report</span></a></li>
<!-- 
=======================================================================================
Pagibig
=======================================================================================
 -->
<li class="bg-success"><?php echo $pagibig_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('pagibig');"><i class='fa fa-folder-open'></i> <span><?php echo $pagibig_rep;?> Crystal Report</span></a></li>

<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('pagibig');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $pagibig_rep;?> List Report</span></a></li>

<!-- 
=======================================================================================
SSS
=======================================================================================
 -->
<li class="bg-success"><?php echo $sss_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('sss');"><i class='fa fa-folder-open'></i> <span><?php echo $sss_rep;?> Crystal Report</span></a></li>

<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('sss');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $sss_rep;?> List Report</span></a></li>


<!-- 
=======================================================================================
PHILHEALTH
=======================================================================================
 -->
<li class="bg-success"><?php echo $phi_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('philhealth');"><i class='fa fa-folder-open'></i> <span><?php echo $phi_rep;?> Crystal Report</span></a></li>

<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('philhealth');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $phi_rep;?> List Report</span></a></li>


<!-- 
=======================================================================================
PAYROLL REGISTER
=======================================================================================
 -->
<li class="bg-success"><?php echo $pay_reg_rep;?></li>
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="report_list('payroll_register');"><i class='fa fa-folder-open'></i> <span><?php echo $pay_reg_rep;?> Crystal Report</span></a></li>

<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('payroll_register');"><i class='fa fa-clock-o'></i> <span>Generate <?php echo $pay_reg_rep;?> List Report</span></a></li>




<!-- 
=======================================================================================
System Default Reports
=======================================================================================
 -->
<li class="bg-success">System Default Reports</li>

<button data-toggle="collapse" data-target="#pagibig_collapse" class="btn btn-danger" style="width: 100%;">PAGIBIG</button>
  <div id="pagibig_collapse" class="collapse">
    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('pagibig_group_rep');"><img class="pi_logo" src="<?php echo base_url()?>public/gov_reports_templates/pagibig.jpg"> <span>Generate <?php echo $pagibig_g_rep;?> Report</span></a></li>
    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('pagibig_certificate');"><img class="pi_logo" src="<?php echo base_url()?>public/gov_reports_templates/pagibig.jpg"><span>Generate <?php echo $pagibig_cert;?></span></a></li>

    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('pagibig_mcrf');"><img class="pi_logo" src="<?php echo base_url()?>public/gov_reports_templates/pagibig.jpg"><span>Generate <?php echo $pagibig_mcrf;?></span></a></li>

    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('pagibig_mrrf');"><img class="pi_logo" src="<?php echo base_url()?>public/gov_reports_templates/pagibig.jpg"> <span>Generate <?php echo $pagibig_mrrf;?></span></a></li>
  </div>

<button data-toggle="collapse" data-target="#sss_collapse" class="btn btn-primary" style="width: 100%;">SSS</button>
  <div id="sss_collapse" class="collapse">
    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('sss_group_rep');"><img class="sss_logo" src="<?php echo base_url()?>public/gov_reports_templates/sss.jpg"> <span>Generate <?php echo $sss_g_rep;?> Report</span></a></li>

    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('sss_certificate');"><img class="sss_logo" src="<?php echo base_url()?>public/gov_reports_templates/sss.jpg"> <span>Generate <?php echo $sss_cert;?></span></a></li>
    
    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('sss_dat_file');"><img class="sss_logo" src="<?php echo base_url()?>public/gov_reports_templates/sss.jpg"> <span>Generate <?php echo $sss_dat_file;?></span></a></li>

    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('sss_transmittal');">
    <img class="sss_logo" src="<?php echo base_url()?>public/gov_reports_templates/sss.jpg"> <span>Generate <?php echo $sss_trans_rep;?></span></a></li>

    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('sss_r3');">
    <img class="sss_logo" src="<?php echo base_url()?>public/gov_reports_templates/sss.jpg"> <span>Generate <?php echo $sss_r3;?></span></a></li>

    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('sss_r1');">
    <img class="sss_logo" src="<?php echo base_url()?>public/gov_reports_templates/sss.jpg"> <span>Generate <?php echo $sss_r1;?></span></a></li>
  </div>

<button data-toggle="collapse" data-target="#philhealth_collapse" class="btn btn-warning" style="width: 100%;">PHILHEALTH</button>
  <div id="philhealth_collapse" class="collapse">
    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('ph_group_rep');"><img class="sss_logo" src="<?php echo base_url()?>public/gov_reports_templates/philhealth.jpg"> <span>Generate <?php echo $ph_g_rep;?> Report</span></a></li>

    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('ph_certificate');"><img class="pi_logo" src="<?php echo base_url()?>public/gov_reports_templates/philhealth.jpg"><span>Generate <?php echo $ph_cert;?></span></a></li>    
  </div>

<button data-toggle="collapse" data-target="#tax_collapse" class="btn btn-success"  style="width: 100%;">TAX</button>
  <div id="tax_collapse" class="collapse">




<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('tax_deduction');"><i class='fa fa-clock-o'></i><span>Generate Tax Monthly Report</span></a></li>

<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="newtab_rep('reports_payroll/c_1601');"><i class='fa fa-clock-o'></i><span>Generate 1601-C Report</span></a></li>

<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="newtab_rep('reports_payroll/cf_1604');"><i class='fa fa-clock-o'></i><span>Generate 1604-CF Report</span></a></li>

<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="alphalist();"><i class='fa fa-clock-o'></i><span>Generate Alphalist Report</span></a></li>








  </div>


<button data-toggle="collapse" data-target="#loan_collapse" class="btn btn-info" style="width: 100%;">LOAN</button>
  <div id="loan_collapse" class="collapse">
    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('loan_report');"><i class='fa fa-clock-o'></i><span>Generate <?php echo $loan_report;?></span></a></li>
  </div>

<button data-toggle="collapse" data-target="#payslip_collapse" class="btn btn-success"  style="width: 100%;">PAYSLIP</button>
  <div id="payslip_collapse" class="collapse">
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('payslip_viewed');"><i class='fa fa-money'></i><span>Generate <?php echo $payslip_viewed;?></span></a></li>

  </div>  <!--end of collapse payslip-->

<button data-toggle="collapse" data-target="#salary_collapse" class="btn btn-primary"  style="width: 100%;">SALARY INFORMATION</button>
  <div id="salary_collapse" class="collapse">
<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('salary_information');"><i class='fa fa-money'></i><span>Generate <?php echo $salary_information;?></span></a></li>

  </div>  <!--end of collapse payslip-->




<!-- 
=======================================================================================
BANK FILE
=======================================================================================
 -->
<!-- 
<li class="bg-success"><?php //echo $bank_file_rep;?></li> -->

<button data-toggle="collapse" data-target="#bankdat_collapse" class="btn btn-danger"  style="width: 100%;">BANK DAT FILE</button>
  <div id="bankdat_collapse" class="collapse">
<?php
if(!empty($bankFileList)){
  foreach($bankFileList as $b){
?>
<li><a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('<?php echo $b->default_value?>');"><i class='fa fa-clock-o'></i> <span>
 <?php echo $b->bank_name." ". $b->bank_file_version?> </span></a>
</li>
    <?php
  }

}

?>
</div>
<!-- <li><a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('bank_file_metrobank1');"><i class='fa fa-clock-o'></i> <span>
  Metrobank Template 1(with total at the bottom)</span></a>
</li>

<li><a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('bank_file_metrobank2');"><i class='fa fa-clock-o'></i> <span>
  Metrobank Template 2(withOUT total at the bottom)</span></a>
</li>

<li><a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="generate_report_ws('bank_file_metrobank3');"><i class='fa fa-clock-o'></i> <span>
  Metrobank Template 3(multiple Company Code base on first 4 digit of account numbers)</span></a>
</li>
 -->



</ul>





            <!--Start result of chooseCompany-->
            <div id="fetch_company_result" style="height: 260px;overflow-y: auto;" >
            </div>
            <!--Start result of chooseCompany-->
        </div>
        <div class="btn-group-vertical btn-block"></div>  
      </div>             
    </div>
  <!--  End Company dropdown   -->
  <!--  START LIST  -->

  <div class="col-md-8" style="padding-bottom: 50px;">
    <div class="box box-success">
      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result" style="height:auto;overflow:scroll;"><br>
              <div style="height:400px;">
              </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div>             
    </div> 
  </div> 
  <!---END LIST-->






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




















 
    <!--Start footer-->
    <footer class="footer">
    <div class="container-fluid">
    <br>
    <strong>Copyright &copy; 2016 <a href="#">Serttech</a>.</strong> All rights reserved.
    <span class="pull-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 1.0</span>
    </div>
    </footer>
    <!--END footer-->
    <!--//==========Start Js/bootstrap==============================//-->
   <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/angular.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
    <!--//==========End Js/bootstrap==============================//-->

  <!--Start AJAX FUNCTIONS-->   
 <script>

function newtab_rep(url) {
  var win = window.open(url, '_blank');
  win.focus();
} 


function autoload()
{
  getEmployeeList(''); 
}
function getEmployeeList(val)
{ 
  //var info = $('#topic_location').val();
  var topic_location = document.getElementById("topic_location").value;    
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
  xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/showSearchEmployee/"+val+"/"+topic_location,true); //
  xmlhttp.send();
}

function select_emp(val)
        {  

          var topic_location = document.getElementById("topic_location").value;     
        var type = $('#type').val();
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/reports_payroll/select_emp/"+val+"/"+type+"/"+topic_location,false);
        xmlhttp2.send();

        }

function prev_employer_filter_employees()
        {  

        var company = document.getElementById("company").value;     
        var year = document.getElementById("year").value;     

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
            
            document.getElementById("filter_employee").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/reports_payroll/prev_employer_filter_employees/"+company+"/"+year,false);
        xmlhttp2.send();

        }

 function fetch_payroll_period_individual()
        {          
             var pay_type_group = document.getElementById("pay_type_group").value;    
             var pay_type = document.getElementById("pay_type").value;     
             var company_id = document.getElementById("company_id").value;    
             var type = document.getElementById("type").value;     

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
        xmlhttp.open("GET","<?php echo base_url();?>app/time_dtr/comp_payroll_period_individual/"+company_id+"/"+pay_type+"/"+pay_type_group+"/"+type,true);
        xmlhttp.send();

        }




      $("#table_home").DataTable({
                });
      //add reports
     function add_reports(val)
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
              //output results
            document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/add_reports/"+val,true);
        xmlhttp.send();
        } 
      }

    //reset
    function reset()
    {
     var checks = document.getElementsByClassName("option");
     var crystal_fields= document.getElementById("crystal_fields").value;
              for (i=0;i < crystal_fields; i++)
              {
                checks[i].checked =false;
              }
     
    }
    function checkAll()
    {
     var checks = document.getElementsByClassName("option");
     var crystal_fields= document.getElementById("crystal_fields").value;
              for (i=0;i < crystal_fields; i++)
              {
                checks[i].checked =true;
              }
    }

    //save new report
   function save_report()
   {
     var report_type= document.getElementById("report_type").value;
     var report_name= document.getElementById("report_name").value;
     var report_desc= document.getElementById("report_desc").value;
     var crystal_fields= document.getElementById("crystal_fields").value;
     var checks = document.getElementsByClassName("option");
     var fields='';

              for (i=0;i < crystal_fields; i++)
              {
                if (checks[i].checked === true)
                {
                  fields +=checks[i].value + "-";
                  
                }
              }

     if(report_name=='' || report_desc=='')
     { alert("Fill Up the Report Name and Report Desription to continue"); }
     else
     {
        if(fields=='' || fields==null)
        { alert("Check atleast one field to continue"); }
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                 $("#table_home").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]          
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/save_new_report/"+report_type+"/"+report_name+"/"+report_desc+"/"+fields,true);
            xmlhttp.send();
            } 
        }
     }
   } 

   //report list
    function report_list(val)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                $("#table_home").DataTable({
                          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/report_list/"+val,true);
            xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

            } 
   }

   //generate working schedule report
   function generate_report_ws(val)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/working_schedule_filter/"+val,true);
            xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

      } 
   } 
   function alphalist()
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/alphalist/",true);
            xmlhttp.send();

        $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;

      } 
   }

     function default_sss_monthly()
     {
        var company= document.getElementById("company").value;
        var yy= document.getElementById("yy").value;
        var mm= document.getElementById("mm").value;
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                
                    $("#print_table").DataTable({
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                        buttons: [
                            { 
                              extend: 'excelHtml5', footer: true ,
                              filename: 'SSS Contribution'
                            },
                            {
                              extend: 'print', footer: true ,
                              title: 'SSS Contribution'
                            }
                        ],
                        destroy: true,            //to reinitialize the datatable so that callack will work.
                        drawCallback: function(){
                           $('[data-toggle="popover"]').popover();
                        }
                      });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/default_sss_monthly/"+company+"/"+yy+"/"+mm,true);
      
            xmlhttp.send();
            }
     }
     function default_ph_monthly()
     {
        var company= document.getElementById("company").value;
        var yy= document.getElementById("yy").value;
        var mm= document.getElementById("mm").value;
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                  

                    $("#print_table").DataTable({
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                        buttons: [
                            { 
                              extend: 'excelHtml5', footer: true ,
                              filename: 'Philhealth Contribution'
                            },
                            {
                              extend: 'print', footer: true ,
                              title: 'Philhealth Contribution'
                            }
                        ],
                        destroy: true,            //to reinitialize the datatable so that callack will work.
                        drawCallback: function(){
                           $('[data-toggle="popover"]').popover();
                        }
                      });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/default_ph_monthly/"+company+"/"+yy+"/"+mm,true);
      
            xmlhttp.send();
            }
     }  
     function default_pi_monthly()
     {
        var company= document.getElementById("company").value;
        var yy= document.getElementById("yy").value;
        var mm= document.getElementById("mm").value;
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                  

                    $("#print_table").DataTable({
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                        buttons: [
                            { 
                              extend: 'excelHtml5', footer: true ,
                              filename: 'Pagibig Contribution'
                            },
                            {
                              extend: 'print', footer: true ,
                              title: 'Pagibig Contribution'
                            }
                        ],
                        destroy: true,            //to reinitialize the datatable so that callack will work.
                        drawCallback: function(){
                           $('[data-toggle="popover"]').popover();
                        }
                      });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/default_pi_monthly/"+company+"/"+yy+"/"+mm,true);
      
            xmlhttp.send();
            }
     }
    function default_tax_monthly()
     {
        var company= document.getElementById("company_id").value;
        var yy= document.getElementById("yy").value;
        var mm= document.getElementById("mm").value;
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
                document.getElementById("default_tax_monthly").innerHTML=xmlhttp.responseText;
                  

                    $("#print_table").DataTable({
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                        buttons: [
                            { 
                              extend: 'excelHtml5', footer: true ,
                              filename: 'Tax Deduction'
                            },
                            {
                              extend: 'print', footer: true ,
                              title: 'Tax Deduction'
                            }
                        ],
                        destroy: true,            //to reinitialize the datatable so that callack will work.
                        drawCallback: function(){
                           $('[data-toggle="popover"]').popover();
                        }
                      });

                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/default_tax_monthly/"+company+"/"+yy+"/"+mm,true);
      
            xmlhttp.send();
            }
     }



   function view_filter(report_area)
   {

    var report= document.getElementById("report").value;
    var type = document.getElementById("type").value;
    var selected_individual_employee_id= "0";
    var status = document.getElementById("status").value;

    if(report_area=='pagibig_group_rep'){
       var groupings_type=document.getElementById("groupings_type").value;
       var company="0";
       var division="0";
       var department="0";
       var section="0";
       var subsection="0";
       var payroll_unique="0";
       var l="0";
       var c="0";
       var quarter="0";
       var page_row="0";  

      var bank_company_code= "0";
      var bank_company_code_two= "0";
      var bank_company_depository_code= "0";
      var bank_effectivity_date= "0";
       var loan_status="0";

    }else if(report_area=='bank_file_metrobank1' || report_area=='bank_file_metrobank2'){
        var quarter="0";
        var page_row="0";      
        var groupings_type="0";

        var bank_company_code= document.getElementById("bank_company_code").value;
        var bank_company_code_two= "0";
        var bank_company_depository_code= document.getElementById("bank_company_depository_code").value;
        var bank_effectivity_date= document.getElementById("bank_effectivity_date").value;

        var company= document.getElementById("company").value;
        var division= document.getElementById("division").value;
        var department= document.getElementById("department").value;
        var section= document.getElementById("section").value;
        var subsection = document.getElementById("subsection").value;
        var payroll_unique = document.getElementById("payroll_unique").value;
        var l= document.getElementById("c_location").value;
        var c = document.getElementById("c_classification").value;    
         var loan_status="0";   

    }else if(report_area=='bank_file_metrobank3'){
        var quarter="0";
        var page_row="0";      
        var groupings_type="0";

        var bank_company_code= document.getElementById("bank_company_code").value;
        var bank_company_code_two= document.getElementById("bank_company_code_two").value;
        var bank_company_depository_code= document.getElementById("bank_company_depository_code").value;
        var bank_effectivity_date= document.getElementById("bank_effectivity_date").value;

        var company= document.getElementById("company").value;
        var division= document.getElementById("division").value;
        var department= document.getElementById("department").value;
        var section= document.getElementById("section").value;
        var subsection = document.getElementById("subsection").value;
        var payroll_unique = document.getElementById("payroll_unique").value;
        var l= document.getElementById("c_location").value;
        var c = document.getElementById("c_classification").value;  
         var loan_status="0";     

    }else if(report_area=='sss_group_rep'){
       var groupings_type=document.getElementById("groupings_type").value;
       var company="0";
       var division="0";
       var department="0";
       var section="0";
       var subsection="0";
       var payroll_unique="0";
       var l="0";
       var c="0";
       var quarter="0";
       var page_row="0";  

      var bank_company_code= "0";
      var bank_company_code_two= "0";
      var bank_company_depository_code= "0";
      var bank_effectivity_date= "0";
       var loan_status="0";

    }else if(report_area=='ph_group_rep'){
       var groupings_type=document.getElementById("groupings_type").value;
       var company="0";
       var division="0";
       var department="0";
       var section="0";
       var subsection="0";
       var payroll_unique="0";
       var l="0";
       var c="0";
         var quarter="0";
         var page_row="0";  
      var bank_company_code= "0";
      var bank_company_code_two= "0";
      var bank_company_depository_code= "0";
      var bank_effectivity_date= "0";
       var loan_status="0";

    }else if(report_area=='tax_deduction'){
       var groupings_type=document.getElementById("groupings_type").value;
       var company="0";
       var division="0";
       var department="0";
       var section="0";
       var subsection="0";
       var payroll_unique="0";
       var l="0";
       var c="0";
         var quarter="0";
         var page_row="0";  
      var bank_company_code= "0";
      var bank_company_code_two= "0";
      var bank_company_depository_code= "0";
      var bank_effectivity_date= "0";
       var loan_status="0";

    }else if(report_area=='sss_r3'){
          var groupings_type="0";
          var company= document.getElementById("company").value;
          var division= document.getElementById("division").value;
          var department= document.getElementById("department").value;
          var section= document.getElementById("section").value;
          var subsection = document.getElementById("subsection").value;
          var payroll_unique = document.getElementById("payroll_unique").value;
          var l= document.getElementById("c_location").value;
          var c = document.getElementById("c_classification").value;  

          var quarter = document.getElementById("quarter").value;     
          var page_row = document.getElementById("page_row").value;     
          var bank_company_code= "0";  
          var bank_company_code_two= "0";
          var bank_company_depository_code= "0";
          var bank_effectivity_date= "0";
          var loan_status="0";
    }else if(report_area=='payslip_viewed'){
      var quarter="0";
      var page_row="0";      
      var groupings_type="0";
      var company= document.getElementById("company").value;
      var division= document.getElementById("division").value;
      var department= document.getElementById("department").value;
      var section= document.getElementById("section").value;
      var subsection = document.getElementById("subsection").value;
      var payroll_unique = "0";
      var l= document.getElementById("c_location").value;
      var c = document.getElementById("c_classification").value;   
      var bank_company_code= "0";
      var bank_company_code_two="0";
      var bank_company_depository_code= "0";
      var bank_effectivity_date= "0";
      var loan_status="0";
    }else{
      var quarter="0";
      var page_row="0";      
      var groupings_type="0";
      var company= document.getElementById("company").value;
      var division= document.getElementById("division").value;
      var department= document.getElementById("department").value;
      var section= document.getElementById("section").value;
      var subsection = document.getElementById("subsection").value;
      var payroll_unique = document.getElementById("payroll_unique").value;
      var l= document.getElementById("c_location").value;
      var c = document.getElementById("c_classification").value;   
      var bank_company_code= "0";
      var bank_company_code_two="0";
      var bank_company_depository_code= "0";
      var bank_effectivity_date= "0";


      if(report_area=='loan_report'){
        var loan_status=document.getElementById("loan_status").value;
      }else{
        var loan_status="0";
      }


    }

  if(type=='single_pp')
    {
        var mm = "0";
        var yy = "0";
        var dd = "0";
        var date_from="0";
        var date_to="0";
        var covered_month_from="0";
        var covered_month_to="0";
        var covered_year="0";
        var payroll_period = document.getElementById("payroll_period").value;
    }
    else if(type=='by_month')
    {
        var mm = "0";
        var yy = "0";
        var dd = "0";
        var date_from="0";
        var date_to="0";
        var payroll_period = "0"; 
        var covered_year = document.getElementById("covered_year").value;
        var covered_month_from = document.getElementById("covered_month_from").value;
        var covered_month_to = document.getElementById("covered_month_to").value;
    }
    else if(type=='by_year')
    {
        var mm = "0";
        var yy = "0";
        var dd = "0";
        var date_from="0";
        var date_to="0";
        var payroll_period = "0"; 
        var covered_month_to = "0"; 
        var covered_month_from = "0";
        var covered_year = document.getElementById("covered_year").value;
    }
    else if(type=='group_by_month')
         {
            var mm = "0";
            var yy = "0";
            var dd = "0";
            var date_from="0";
            var date_to="0";
            var payroll_period = "0";           
            var covered_month_from = document.getElementById("covered_month_from").value;
            var covered_month_to = document.getElementById("covered_month_to").value;
            var covered_year = document.getElementById("covered_year").value;  
    }
    else if(type=='group_by_year')
         {
            var mm = "0";
            var yy = "0";
            var dd = "0";
            var date_from="0";
            var date_to="0";
            var payroll_period = "0";           
            var covered_month_from = "0";
            var covered_month_to = "0";
            var covered_year = document.getElementById("covered_year").value;  
    }

        if(report_area=='pagibig_group_rep'){
            var location="0";
            var classification="0";
            var employment="0";
        }else if(report_area=='sss_group_rep'){
            var location="0";
            var classification="0";
            var employment="0";
        }else if(report_area=='ph_group_rep'){
            var location="0";
            var classification="0";
            var employment="0";
        }else if(report_area=='tax_deduction'){
            var location="0";
            var classification="0";
            var employment="0";
        }else{

    var location_check = document.getElementsByClassName("location");
    var location='';

              for (i=0;i<l; i++)
              {
                if (location_check[i].checked === true)
                {
                  location +=location_check[i].value + "-OR-";                }
              }
    var classification_check = document.getElementsByClassName("classification");
    var classification='';

              for (i=0;i<c; i++)
              {
                if (classification_check[i].checked === true)
                {
                  classification +=classification_check[i].value + "-OR-";                }
              }

    var employment_check = document.getElementsByClassName("employment");
    var employment='';

              for (i=0;i<4; i++)//check no of employment of company
              {
                if (employment_check[i].checked === true)
                {
                  employment +=employment_check[i].value + "-OR-";                }
              }
            }

    if(covered_month_from>covered_month_to)

    { alert("Covered Month From is must not be ahead of Covered Month To"); }

    else if(report=='' || company =='' ||  department =='' || section =='' || location =='' || classification=='' || employment =='' || status=='')
     { alert("Fill up all fields"); }
     else{ 
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;

                  for (i=0;i<40; i++)
                  {

                      $("#print_table"+i+"").DataTable({
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                        buttons: [
                            {
                              extend: 'excel',
                              title: 'payroll report'
                            },
                            {
                              extend: 'print',
                              title: 'payroll Report'
                            }
                        ],
                        destroy: true,            //to reinitialize the datatable so that callack will work.
                        drawCallback: function(){
                           $('[data-toggle="popover"]').popover();
                        }
                      });
                  }



                $("#print_table").DataTable({
                  dom: 'Blfrtip',
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                  buttons: [
                      {
                        extend: 'excel',
                        title: 'payroll report'
                      },
                      {
                        extend: 'print',
                        title: 'payroll Report'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });



                }
              }

            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/working_schedule_view/"+report+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+status+"/"+yy+"/"+mm+"/"+dd+"/"+type+"/"+date_from+"/"+date_to+"/"+payroll_period+"/"+report_area+"/"+covered_month_from+"/"+covered_month_to+"/"+covered_year+"/"+groupings_type+"/"+payroll_unique+"/"+selected_individual_employee_id+"/"+quarter+"/"+page_row+"/"+bank_company_code+"/"+bank_company_depository_code+"/"+bank_effectivity_date+"/"+bank_company_code_two+"/"+loan_status,true); //  

            xmlhttp.send();
            } 
        }

   }

   function deleteReport(val)
   {
      var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                
                      $("#table_home").DataTable({
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]              
                      });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/deleteReport/"+val,true);
            xmlhttp.send();
            }
      }
      else{}
    }


     function updateReport(report_type,val)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/updateReport/"+report_type+"/"+val,true);
            xmlhttp.send();
            }
     }

     //update report
   function save_update_report(report_id)
   {
     var report_name= document.getElementById("report_name").value;
     var report_desc= document.getElementById("report_desc").value;

     var checks = document.getElementsByClassName("option");
     var fields='';

              for (i=0;i<25; i++)
              {
                if (checks[i].checked === true)
                {
                  fields +=checks[i].value + "-";
                  
                }
              }

     if(report_name=='' || report_desc=='')
     { alert("Fill Up the Report Name and Report Desription to continue"); }
     else
     {
        if(fields=='' || fields==null)
        { alert("Check atleast one field to continue"); }
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                 $("#table_home").DataTable({
                          // destroy: true,           
                              });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/save_update_report/"+fields+"/"+report_name+"/"+report_desc+"/"+report_id,true);
            xmlhttp.send();
            } 
        }
     }
   } 

    function viewReport(report_type,val)
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/viewReport/"+report_type+"/"+val,true);
            xmlhttp.send();
            }
     }

    function class_loc(val)
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
                document.getElementById("class_loc").innerHTML=xmlhttp.responseText;
                
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/show_class_loc/"+val,true);
            xmlhttp.send();
            }
     }

     function result_onchange(option,val)
     { 
       
        var company_id= document.getElementById("company").value;
        var type= document.getElementById("type").value;
        var topic_location= document.getElementById("topic_location").value;
       
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
                  if(option=='division'){ document.getElementById("divi_2").innerHTML=xmlhttp.responseText; }
                  else if(option=='department'){ document.getElementById("department").innerHTML=xmlhttp.responseText; } // department
                  else if(option=='section'){ document.getElementById("section").innerHTML=xmlhttp.responseText; }
                  else if(option=='subsection'){ document.getElementById("subsection").innerHTML=xmlhttp.responseText; }
                  // else if(option=='classification'){ document.getElementById("classification").innerHTML=xmlhttp.responseText; }
                  // else if(option=='location'){ document.getElementById("location").innerHTML=xmlhttp.responseText; }
                  

                } 
              }
              if(option=='department' || option=='classification' || option=='location')
              { xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/result_onchange/"+option+"/"+company_id+"/"+val+"/"+type+"/"+topic_location,true); }
            
            else{ xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/result_onchange/"+option+"/"+val+"/"+company_id+"/"+type+"/"+topic_location,true); }
            xmlhttp.send();
            }
       
     }

      function result_onchange_2(option,val)
     { 
       
        var company_id= document.getElementById("company").value;
        var pay_type= document.getElementById("pay_type").value;
       
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
                if(option=='group'){ document.getElementById("group").innerHTML=xmlhttp.responseText; }
                else if(option=='payroll_period'){ document.getElementById("payroll_period").innerHTML=xmlhttp.responseText; }
                } 
              }
              if(option=='group'){
              xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/result_onchange_2/"+option+"/"+val +"/"+company_id,true); }
              else if(option=='payroll_period') {  xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/result_onchange_2/"+pay_type+"/"+val +"/"+company_id,true); }
            xmlhttp.send();
            }

     }
     // ========================BANK FILE
      function comp_group(val)
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
                   document.getElementById("comp_group").innerHTML=xmlhttp.responseText;
                } 
              }
          xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/comp_group/"+val,true); 
            
            xmlhttp.send();
            }
     }
      function comp_group_pp(val)
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
                   document.getElementById("comp_group_pp").innerHTML=xmlhttp.responseText;
                } 
              }
          xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/comp_group_pp/"+val,true); 
            
            xmlhttp.send();
            }
     }     

      function bank_pp_group(val)
     {      

     // 
     var selected_company= document.getElementById("selected_company").value; 
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
                   document.getElementById("comp_group_pp").innerHTML=xmlhttp.responseText;
                } 
              }
          xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/comp_group_pp/"+val+"/"+selected_company,true); 
            
            xmlhttp.send();
            }
     }
     // =====================END BANKFILE

     function basis(option,value)
     {

      if(value=="single")
      {
       $("#date_filter").show();
       $("#filtered_double").hide();
       $("#payroll_filtering").hide();  
      }
      else if(value=="double")
      {
        $("#date_filter").hide();
        $("#filtered_double").show(); 
        $("#payroll_filtering").hide(); 
      }
      else if(value=="single_pp")
      {
        $("#payroll_filtering").show(); 
        $("#date_filter").hide();
        $("#filtered_double").hide(); 
      }

      else if(value=="group_by_month")
      {
       // $("#group_by_year_choices").hide(); 
        $("#group_by_month_choices").show(); 
        $("#group_by_year_choices").show(); 
      }
      else if(value=="group_by_year")
      {
       // $("#group_by_year_choices").show(); 
        $("#group_by_month_choices").hide(); 
        $("#group_by_year_choices").show(); 
      }
      else if(value=="group_by_pp")
      {
       // $("#group_by_year_choices").hide(); 
        $("#group_by_month_choices").hide(); 
        $("#group_by_year_choices").hide(); 
      }



     }
   
     //generate working schedule report
   function generate_report_ws_pp()
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/working_schedule_filter_pp",true);
            xmlhttp.send();
      } 
   }

    function view_filter_pp()
   {
    var report= document.getElementById("report").value;
    var company= document.getElementById("company").value;
    var division= document.getElementById("division").value;
    var department= document.getElementById("department").value;
    var section= document.getElementById("section").value;
    var subsection = document.getElementById("subsection").value;
    var status = document.getElementById("status").value;
    var l= document.getElementById("c_location").value;
    var c = document.getElementById("c_classification").value;
    var type = 'single_pp';
    
        var mm = "0";
        var yy = "0";
        var dd = "0";
        var date_from="0";
        var date_to="0";
        var payroll_period = document.getElementById("payroll_period").value;
   
    var location_check = document.getElementsByClassName("location");
    var location='';

              for (i=0;i<l; i++)
              {
                if (location_check[i].checked === true)
                {
                  location +=location_check[i].value + "-OR-";                }
              }
    var classification_check = document.getElementsByClassName("classification");
    var classification='';

              for (i=0;i<c; i++)
              {
                if (classification_check[i].checked === true)
                {
                  classification +=classification_check[i].value + "-OR-";                }
              }

    var employment_check = document.getElementsByClassName("employment");
    var employment='';

              for (i=0;i<4; i++)
              {
                if (employment_check[i].checked === true)
                {
                  employment +=employment_check[i].value + "-OR-";                }
              }
     if(report=='' || company =='' || division =='' || department =='' || section =='' || subsection =='' || location =='' || classification=='' || employment =='' || status=='')
     { alert("Fill up all fields"); }
     else{ 
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                $("#print_table").DataTable({
                  dom: 'Blfrtip',
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                  buttons: [
                      {
                        extend: 'excel',
                        title: 'Working Schedule Report'
                      },
                      {
                        extend: 'print',
                        title: 'Working Schedule Report'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/working_schedule_view_pp/"+report+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+status+"/"+payroll_period,true);
            xmlhttp.send();
            } 
        }
   }
   function refresh()
   {
    // $("#class_loc").load(location.href + " #class_loc");
    // $("#department").load(location.href + " #department");
    // $("#section").load(location.href + " #section");
    //$("#subsection").load(location.href + " #subsection");
    $("#payroll_period").load(location.href + " #payroll_period");
    // $("#classification").load(location.href + " #classification");
    // $("#location").load(location.href + " #location");   
    // $("#employment").load(location.href + " #employment");
  }

  function hide_sec_and_sub()
        {          
         // $('#hide_sub_on_dept_change').hide(); 
          //$('#aliby_sec').show(); 
        }


  function hide_sub()
        {          
          $('#hide_sub_on_dept_change').hide(); 
        }
  function show_sub()
        {          
          $('#hide_sub_on_dept_change').show();  
        }

  function disable_group_process()
        {          
             
          $("#comp_default").attr('disabled','disabled');  
          $("#division").attr('disabled','disabled');  
          $("#department").attr('disabled','disabled');  
          $("#section").attr('disabled','disabled');  
          $("#subsection").attr('disabled','disabled');  
          $("#classification").attr('disabled','disabled'); 
          $("#def_emp_status").attr('disabled','disabled');  
          $("#for_group_viewing").attr('disabled','disabled');  
   
          $('#divi_2').hide();     
   
          $('#def_emp_status').hide();  
          $('#comp_default').hide();     
          $('#classification').hide();  
          $('#def_employment').hide();     
          $('#for_group_viewing').hide();     
        }


   function generate_individual(report_area)
   {

      var report= document.getElementById("report").value;
      var selected_individual_employee_id= document.getElementById("selected_individual_employee_id").value;
      var type = document.getElementById("type").value;
      var company = document.getElementById("company").value;

      var division="0";
      var department="0";
      var section="0";
      var subsection="0";
      var location="0";
      var classification="0";
      var employment="0";
      var status="0";
      var yy="0";
      var mm="0";
      var dd="0";
      var date_from="0";
      var date_to="0";
      var quarter="0";
      var page_row="0";

      var bank_company_code= "0";
      var bank_company_code_two= "0";
      var bank_company_depository_code= "0";
      var bank_effectivity_date= "0";
      var groupings_type = "0";   

      var l="0";
      var c="0";

    if(report_area=='loan_report'){
      var payroll_unique=document.getElementById("payroll_unique").value;
      var loan_status=document.getElementById("loan_status").value;
    }else{
      var payroll_unique="All";
      var loan_status="0";
    }

      

    if(type=='by_month')
    {
        var payroll_period = "0";
        var covered_year = document.getElementById("covered_year").value;
        var covered_month_from = document.getElementById("covered_month_from").value;
        var covered_month_to = document.getElementById("covered_month_to").value;
    }
    else if(type=='by_year')
    {
        var payroll_period = "0";
        var covered_month_to = "0"; 
        var covered_month_from = "0";
        var covered_year = document.getElementById("covered_year").value;
    }
    else if(type=='single_pp')
    {
        var covered_year = "0";
        var covered_month_to = "0"; 
        var covered_month_from = "0";
        var payroll_period = document.getElementById("payroll_period").value;
    }
    

    if(covered_month_from>covered_month_to)

    { alert("Covered Month From is must not be ahead of Covered Month To"); }

    else if(payroll_unique=='')

    { alert("Loan Type is required"); }

    else if(report=='' || selected_individual_employee_id =='')
     { alert("Fill up all fields"); }
     else{ 
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                $("#print_table").DataTable({
                  dom: 'Blfrtip',
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                  buttons: [
                      {
                        extend: 'excel',
                        title: 'payroll report'
                      },
                      {
                        extend: 'print',
                        title: 'payroll Report'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/working_schedule_view/"+report+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+location+"/"+classification+"/"+employment+"/"+status+"/"+yy+"/"+mm+"/"+dd+"/"+type+"/"+date_from+"/"+date_to+"/"+payroll_period+"/"+report_area+"/"+covered_month_from+"/"+covered_month_to+"/"+covered_year+"/"+groupings_type+"/"+payroll_unique+"/"+selected_individual_employee_id+"/"+quarter+"/"+page_row+"/"+bank_company_code+"/"+bank_company_depository_code+"/"+bank_effectivity_date+"/"+bank_company_code_two+"/"+loan_status,true); //
            xmlhttp.send();
            } 
        }

   }


   function generate_sss_r1(report_area)
   {

      var report= document.getElementById("report").value;
      var company = document.getElementById("company").value;

    

    if(report=='' || company =='')
     { alert("Fill up all fields"); }
     else{ 
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
                document.getElementById("fetch_all_result").innerHTML=xmlhttp.responseText;
                $("#print_table").DataTable({
                  dom: 'Blfrtip',
                  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                  buttons: [
                      {
                        extend: 'excel',
                        title: 'payroll report'
                      },
                      {
                        extend: 'print',
                        title: 'payroll Report'
                      }
                  ],
                  destroy: true,            //to reinitialize the datatable so that callack will work.
                  drawCallback: function(){
                     $('[data-toggle="popover"]').popover();
                  }
                });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/reports_payroll/generate_sss_r1/"+report+"/"+company,true); //
            xmlhttp.send();
            } 
        }

   }




function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

function extract_salary_info()
        {  

          var company_id = document.getElementById("company_id").value;  
          var sal_type = document.getElementById("sal_type").value;     
          var effectivity_date = document.getElementById("effectivity_date").value;     
        
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
            
            document.getElementById("extract_salary_info").innerHTML=xmlhttp2.responseText;

                    $("#table_home").DataTable({
                        dom: 'Blfrtip',
                        lengthMenu: [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
                        buttons: [
                            { 
                              extend: 'excelHtml5', footer: true ,
                              filename: 'Salary Report'
                            },
                            {
                              extend: 'print', footer: true ,
                              title: 'Salary Report'
                            }
                        ],
                        destroy: true,            //to reinitialize the datatable so that callack will work.
                        drawCallback: function(){
                           $('[data-toggle="popover"]').popover();
                        }
                      });



            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/reports_payroll/extract_salary_info/"+company_id+"/"+sal_type+"/"+effectivity_date,false);
        xmlhttp2.send();

        }
// =============================================



  </script>
  <!--END ajaxX FUNCTIONS-->

