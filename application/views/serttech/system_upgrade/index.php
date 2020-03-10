<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My HRIS- Serttech<?php //echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header_serttech.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar_serttech.php');?>

<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    System Management
    <small>Migrator Of HRWeb Version 1 Data to Version 2 Database </small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">System Management</li>
  </ol>
</section>

<section class="content">
  <div class="row">
     <!-- ==================================================================== -->
                 <div class="col-md-12">
                    <?php echo $message;?>
              <?php echo validation_errors(); ?>

              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <li class="active"><a href="#file_maintenance" data-toggle="tab">
                  	<i class="fa fa-file text-success"></i> File Maintenance</a>
                </li>
                <li><a href="#201_masterlist" data-toggle="tab">
                  	<i class="fa fa-file text-success"></i> 201 Masterlist</a>
                </li>
                <li><a href="#leaves" data-toggle="tab">
                    <i class="fa fa-file text-success"></i> Leaves</a>
                </li>
                <li><a href="#dtr_summary" data-toggle="tab">
                    <i class="fa fa-file text-success"></i> DTR</a>
                </li>
                <li><a href="#transaction_forms" data-toggle="tab">
                    <i class="fa fa-file text-success"></i> Forms/Transaction</a>
                </li>
                <li><a href="#201_masterlist" data-toggle="tab">
                    <i class="fa fa-file text-danger"></i> Loans</a>
                </li>
                <li><a href="#201_masterlist" data-toggle="tab">
                    <i class="fa fa-file text-danger"></i> Compensation/Salary</a>
                </li>
                <li><a href="#201_masterlist" data-toggle="tab">
                    <i class="fa fa-file text-danger"></i> SSS/Philhealth Deduction Schedule</a>
                </li>
                <li><a href="#201_masterlist" data-toggle="tab">
                    <i class="fa fa-file text-danger"></i> Pagibig COntribution</a>
                </li>
                <li><a href="#201_masterlist" data-toggle="tab">
                    <i class="fa fa-file text-danger"></i> Payroll Formula</a>
                </li>
               

                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="file_maintenance">
                  <ul class="products-list product-list-in-box">
                  <li class="item">

                    <div class="col-md-12 ">

                      <div id="action_result_fm">                        
                      </div>

                    <table class="table table" id="example11">
                      <thead>
                        <tr>
                          <th>Enter THe Company ID Here<input type="text" id="company_id_fm" value="1" class="form-control" placeholder="Enter the company id here"> </th>
                          <th>&nbsp;</th>
                        </tr>
                        <tr>
                          <th>Area </th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <tr>
                          <td>Location</td>
                          <td><a title="Click To Migrate Location Details" onclick="transfer_fm_details('location');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>

                          <td>Company</td>
                          <td><a title="Click To Migrate Company Details" onclick="transfer_fm_details('company');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Department</td>
                          <td><a title="Click To Migrate Department Details" onclick="transfer_fm_details('department');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Section</td>
                          <td><a title="Click To Migrate Section Details" onclick="transfer_fm_details('section');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Classification</td>
                          <td><a title="Click To Migrate Classification Details" onclick="transfer_fm_details('classification');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Employment</td>
                          <td><a title="Click To Migrate Employment Details" onclick="transfer_fm_details('employment');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Position</td>
                          <td><a title="Click To Migrate Position Details" onclick="transfer_fm_details('position');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Bank</td>
                          <td><a title="Click To Migrate Bank Details" onclick="transfer_fm_details('bank');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Holiday List</td>
                          <td><a title="Click To Migrate Holiday Details" onclick="transfer_fm_details('holiday');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>

                        <?php
                        if(!empty($active_forms)){
                          foreach($active_forms as $a){
                        ?>
                        <tr>
                          <td class="bg-info"><?php echo $a->form_name;?> Approvers</td>
                          <td><a title="Click To Migrate Approvers Details" onclick="transfer_form_approvers('<?php echo $a->doc_id;?>');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <?php
                          }
                        }else{

                        }

                        ?>
                        <tr>
                          <td>Section Manager</td>
                          <td><a title="Click To Migrate Section Manager Details" onclick="transfer_sect_mngr('section_manager');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>


                      </tbody>
                      
                    </table>
                    </div>

                  </li>
                  </ul>
                  </div>

                  <div class="tab-pane" id="201_masterlist">
                  <ul class="products-list product-list-in-box">
                  <li class="item">

                    <div class="col-md-12">

                      <div id="action_result_201">                        
                      </div>

                    <table class="table table" id="example11">
                      <thead>
                        <tr>
                          <th>Enter THe Company ID Here<input type="text" id="company_id_201" value="1" class="form-control" placeholder="Enter the company id here"> </th>
                          <th>&nbsp;</th>
                        </tr>
                        <tr>
                          <th>Area </th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Active Employees</td>
                          <td><a title="Click To Migrate Department Details" onclick="transfer_201_details('active_emp');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>InActive Employees</td>
                          <td><a title="Click To Migrate Department Details" onclick="transfer_201_details('inactive_emp');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>User Define Fields(come back)</td>
                          <td><a title="Click To Migrate User Define Fields Data" onclick="transfer_201_details('userdefine_data');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
 
                      </tbody>
                      
                    </table>                    
                    </div>

                  </li>
                  </ul>
                  </div>
                  <div class="tab-pane" id="leaves">
                  <ul class="products-list product-list-in-box">
                  <li class="item">

                    <div class="col-md-12">

                      <div id="action_result_leaves">                        
                      </div>

                    <table class="table table" id="example11">
                      <thead>
                        <tr>
                          <th>Enter THe Company ID Here<input type="text" id="company_id_leaves" value="1" class="form-control" placeholder="Enter the company id here"> </th>
                          <th>&nbsp;</th>
                        </tr>
                        <tr>
                          <th>Area </th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Leave Type</td>
                          <td><a title="Click To Migrate Leave Type Details" onclick="transfer_leave('leave_type');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Remaining Leave Credit</td>
                          <td><a title="Click To Migrate Leave Type Credits Details" onclick="transfer_leave('leave_type_remaining_credit');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                      </tbody>                      
                    </table>                    
                    </div>
                  </li>
                  </ul>
                  </div>
                  <div class="tab-pane" id="dtr_summary">
                  <ul class="products-list product-list-in-box">
                  <li class="item">

                    <div class="col-md-12">

                      <div id="action_result_dtr_summary">                        
                      </div>

                    <table class="table table" id="example11">
                      <thead>
                        <tr>
                          <th>Enter THe Company ID Here<input type="text" id="company_dtr_summary" value="1" class="form-control" placeholder="Enter the company id here"> </th>
                          <th>&nbsp;</th>
                        </tr>
                        <tr>
                          <th>Area </th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Payroll Period Group</td>
                          <td><a title="Click To Create Payroll Period Group Details" onclick="transfer_dtr_summary('payroll_period_group');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Payroll Period Group Members</td>
                          <td><a title="Click To Create Payroll Period Group Members Details" onclick="transfer_dtr_summary('payroll_period_group_members');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Payroll Period</td>
                          <td><a title="Click To Migrate Payroll Period Details" onclick="transfer_dtr_summary('payroll_period');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Fixed Schedule</td>
                          <td width="90%"><a class="col-md-12 btn btn-info" title="Click To Migrate Fixed Schedule Group/Members/Schedule" onclick="transfer_dtr_summary('fixed_schedule');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                        <tr>
                          <td>Shift Table References</td>
                          <td><a class="col-md-12 btn btn-info" title="Click To Migrate Shift Table References" onclick="transfer_dtr_summary('shift_table');" ><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
<?php
$x = 1;
while($x <= 12) {
?>
              <tr>
                <td>Attendances Of <?php echo date('F', mktime(0, 0, 0, $x, 10)); ?></td>
                <td><a title="Click To Migrate Attendances of <?php echo date('F', mktime(0, 0, 0, $x, 10)); ?>" onclick="transfer_attendances('<?php echo $x;?>');" ><i class="fa fa-arrow-right"></i></a></td>
              </tr>
<?php
    $x++;
}


if(!empty($pay_period)){
  foreach($pay_period as $p){
?>
      <tr>
        <td><?php echo $p->pay_code." ".$p->month_cover;?> DTR Summary ONLY Of <?php echo $p->y1."-".$p->m1."-".$p->d1." TO ".$p->y2."-".$p->m2."-".$p->d2;?></td>
        <td><a title="Click To Migrate DTR Summary of <?php echo $p->y1."-".$p->m1."-".$p->d1." TO ".$p->y2."-".$p->m2."-".$p->d2;?>" onclick="transfer_dtr_summary_2('<?php echo $p->pay_code?>');" ><i class="fa fa-arrow-right"></i></a></td>
      </tr>

<?php
  }
}else{
/*
empty payroll period .
*/
}
?>



                      </tbody>                      
                    </table>                    
                    </div>
                  </li>
                  </ul>
                  </div>

       


                  <div class="tab-pane" id="transaction_forms">
                  <ul class="products-list product-list-in-box">
                  <li class="item">

                    <div class="col-md-12">

                      <div id="action_result_transaction_forms">                        
                      </div>

                    <table class="table table" id="example11">
                      <thead>
                        <tr>
                          <th>Enter THe Company ID Here<input type="text" id="company_tf_id" value="1" class="form-control" placeholder="Enter the company id here"> </th>
                          <th>&nbsp;</th>
                        </tr>
                        <tr>
                          <th>Area </th>
                          <th>Action</th>
                        </tr>
                      </thead>
                     <tbody>
                    <tr>
                    <td>Approved Leave Forms</td>
                    <td width="90%"><a class="col-md-12 btn btn-info" title="Click To Migrate Approved Leave Forms" onclick="transfer_dtr_forms('leave_form');" ><i class="fa fa-arrow-right"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>Approved OT Forms</td>
                    <td width="90%"><a class="col-md-12 btn btn-info" title="Click To Migrate Approved OT Forms" onclick="transfer_dtr_forms('ot_form');" ><i class="fa fa-arrow-right"></i></a>
                    </td>                    
                  </tr>
                  <tr>
                    <td>Approved Official Business Forms</td>
                    <td width="90%"><a class="col-md-12 btn btn-info" title="Click To Migrate Approved Official Business Forms" onclick="transfer_dtr_forms('ob_form');" ><i class="fa fa-arrow-right"></i></a>
                    </td>                    
                  </tr>
                  <tr>
                    <td>Approved Timekeeping Complaint Forms</td>
                    <td width="90%"><a class="col-md-12 btn btn-info" title="Click To Migrate Approved Timekeeping Forms" onclick="transfer_dtr_forms('tk_form');" ><i class="fa fa-arrow-right"></i></a>
                    </td>                    
                  </tr>
              </tbody>
              </table>
            </div>
          </div>
   <!--      </div>
      </div>
 -->










                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->

          <!-- ============================================================= --> 
  </div>
</section>
</div>
<script type="text/javascript">
      function transfer_fm_details(val)
        {          
            var company_id = document.getElementById("company_id_201").value;
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
            
            document.getElementById("action_result_fm").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/system_upgrade/get_v1_fm_details/"+val+"/"+company_id,true);
        xmlhttp.send();
        }  

      function transfer_form_approvers(val)
        {          
            var company_id = document.getElementById("company_id_201").value;
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
            
            document.getElementById("action_result_fm").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/system_upgrade/transfer_form_approvers/"+val+"/"+company_id,true);
        xmlhttp.send();
        }  
      function transfer_sect_mngr(val)
        {          
            var company_id = document.getElementById("company_id_201").value;
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
            
            document.getElementById("action_result_fm").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/system_upgrade/transfer_sect_mngr/"+val+"/"+company_id,true);
        xmlhttp.send();
        }  


      function transfer_201_details(val)
        {          
            var company_id = document.getElementById("company_id_fm").value;
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
            
            document.getElementById("action_result_201").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/system_upgrade/get_v1_201_details/"+val+"/"+company_id,true);
        xmlhttp.send();
        }    

      function transfer_leave(val)
        {          
            var company_id = document.getElementById("company_id_leaves").value;
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
            
            document.getElementById("action_result_leaves").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/system_upgrade/get_v1_leave_type/"+val+"/"+company_id,true);
        xmlhttp.send();
        }    


      function transfer_dtr_forms(val)
        {          
            var company_id = document.getElementById("company_tf_id").value;
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
            
            document.getElementById("action_result_transaction_forms").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/system_upgrade/get_v1_dtr_forms/"+val+"/"+company_id,true);
        xmlhttp.send();
        }  

      function transfer_dtr_summary(val)
        {          
            var company_id = document.getElementById("company_dtr_summary").value;
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
            
            document.getElementById("action_result_dtr_summary").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/system_upgrade/get_v1_dtr_summary/"+val+"/"+company_id,true);
        xmlhttp.send();
        }  



      function transfer_dtr_summary_2(val)
        {          
            var company_id = document.getElementById("company_dtr_summary").value;
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
            
            document.getElementById("action_result_dtr_summary").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/system_upgrade/get_v1_dtr_summary_2/"+val+"/"+company_id,true);
        xmlhttp.send();
        }    
 
      function transfer_attendances(val)
        {          
            var company_id = document.getElementById("company_dtr_summary").value;
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
            
            document.getElementById("action_result_dtr_summary").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>serttech/system_upgrade/transfer_attendances/"+val+"/"+company_id,true);
        xmlhttp.send();
        }    

   
</script>
       <script src="<?php echo base_url()?>public/validation.js"></script>
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

      $(function () {

        $("#example1").DataTable();



      });
    </script>

  </body>
</html>