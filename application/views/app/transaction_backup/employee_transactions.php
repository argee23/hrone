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
      Transaction
       <small>Employee Transactions</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/transaction_employees">Transaction</a></li>
      <li class="active">Employee Transactions</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

  <div class="row">

    <div class="col-md-12">
              <?php echo $message;?>
              <?php echo validation_errors(); ?>
    <div class="box box-info">
<div class="box-header">
  <select class="form-control select2" name="" id="page" onchange="gotoPage()">
  <option selected="selected" disabled>-Select Action-</option>
  <option value="page_ass_emp_tran_enc">Assign Employee for Transaction Filing</option>
  <option value="page_attach_file_on_tran_filing">Attach File on Transaction Filing</option>
  <option value="page_app_leave_pay_opt">Apply Leave with or without pay option</option>
  <option value="page_cancel_tran_emp_acc" >Cancel Transaction on Employee Account Setting</option>
  <option value="page_dl_ul_tran_record">Download/Upload Transaction Records</option>
  <option value="page_late_fil_tran_opt">Late Filing Transaction Options</option>
  <option value="page_mass_tran_enc">Mass Transaction Encoding</option>
  <option value="page_send_email_tran">Send Email Transaction</option>
  <option value="blocked_leave_dates">Block dates for leave application</option>
  <option value="atro_members">Enrol Employee ATRO Policy</option>
  <option value="trip_ticket">Manage Trip Ticket</option>
  <!--  <option value="page_approve_tran" >Approve Transaction</option> -->
  <!--  <option value="page_cancel_tran" >Cancel Transaction</option> -->
   <!--  <option value="page_del_tran" >Delete Transaction</option> -->
  <!-- <option value="page_err_tran" >Error Transaction</option> -->
  <!--  <option value="page_trans_tran_app">Transfer Transaction Approval</option> -->
  <!--  <option value="page_list_pend_tran">List of Pending Transaction</option> -->
  </select>       
  </div>
    <div class="box-body">
    <div class="col-md-12" id="showdate"></div> <!-- //important -->

    <div class="form-group">
    <div class="col-sm-10">

    </div>  
    </div> 

  <div class="table-responsive">   <!--  for table responsiveness -->  
<!--   <form name="f1" method="post" action="<?php //echo base_url()?>app/transaction_employees/save_cancel_opt_on_emp_acc" >
 -->
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <td>Doc.No</td>
        <td>Transaction(s)</td>
        <td>Approve Transaction</td>
        <td>Cancel Transaction</td>
<!--         <td align="center">Cancellation Option on Employee Account Setting
<button type="submit" class="btn btn-primary btn-xs" ><i class="fa fa-save"></i> Save</>
        </td> -->
        <td>Delete Transaction</td>
        <td>Transfer Approval</td>
        <td>Pending Transactions</td>
 <!--        <td>Error Transactions</td> -->
        <td>History</td>
      </tr>
    </thead>
    <tbody>
    <?php foreach($file as $file_doc){?>
      <tr <?php if($file_doc->IsActive==0){ echo "class='text-danger'";}else{echo "class='text-success'";} ?>>
        <td><?php echo $file_doc->identification; ?></td>
        <td><!-- //===============================viewing of transactions -->
          <?php
           if(($file_doc->t_table_name=="emp_change_sched")OR($file_doc->t_table_name=="emp_atro")OR($file_doc->t_table_name=="emp_change_rest_day")){
                $count = $this->transaction_employees_model->count_transaction_none_mass_encoding($file_doc->t_table_name);             
           }else if($file_doc->t_table_name==""){
              echo "no database table yet";
           }else {
                $count = $this->transaction_employees_model->count_transaction($file_doc->t_table_name);                 
           }
           
           $array_items = count($count);
                if($array_items=="0"){
                echo $file_doc->form_name. '  <button class="btn btn-danger btn-xs">[ '.$array_items.' ]</button>';
                }
                else{
                echo ' <a href="'.base_url().'app/transaction_employees/view_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to View [ '.$file_doc->form_name.' ] transactions" role="button" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i>  '.$file_doc->form_name. ' <button class="btn btn-danger btn-xs">[ '.$array_items.' ]</button></a>';
                }
                // =============
                 if(($file_doc->t_table_name=="emp_change_sched")OR($file_doc->t_table_name=="emp_atro")OR($file_doc->t_table_name=="emp_change_rest_day")){
                $mass_approve = $this->transaction_employees_model->get_transaction_with_mass_encoding($file_doc->t_table_name);
               $array_items_mass_approve = count($mass_approve);
               echo "<br>";
                echo ' <a href="'.base_url().'app/transaction_employees/view_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to View [ '.$file_doc->form_name.' ] transactions" role="button" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i>  mass encoded/uploaded :automatic approve <button class="btn btn-danger btn-xs">[ '.$array_items_mass_approve.' ]</button></a>';
             }else{
             
              echo "";
             }
          ?>
        </td>
        <td> <!-- //===============================approving of transactions --> 
          <?php  
          $t_approve = $this->transaction_employees_model->to_approve_trans($file_doc->identification,$file_doc->t_table_name);//
          if(!empty($t_approve)){
          echo '<a href="'.base_url().'app/transaction_employees/approve_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to Select [ '.$file_doc->form_name.' ] Transactions to be approved" role="button" class="btn btn-info btn-xs"><i class="fa fa-check-square"></i> approve</a>';
          }else{
          echo '<a class="text-success"><i class="fa fa-check"></i>no transactions to be approve yet</a>';
          }
          ?>
        </td>
        <td> <!-- //===============================cancellation of transactions -->
          <?php            
          $t_cancel = $this->transaction_employees_model->to_cancel_trans($file_doc->identification,$file_doc->t_table_name);
          //$t_cancel_items = count($t_cancel);
          if(!empty($t_cancel)){
          echo '<a href="'.base_url().'app/transaction_employees/cancel_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to Select [ '.$file_doc->form_name.' ] Transactions to be cancel" role="button" class="btn btn-warning btn-xs"><i class="fa fa-exclamation"></i> cancel</a>';
          }else{
          echo '<a class="text-danger"><i class="fa fa-remove"></i>no transactions to be cancel yet</a>';
          }
          ?>
        </td>
        <!-- <td> --><!-- //===============================cancellation option on employee account setting-->
        <?php //$file_doc->id;?>
           <!--  <select class="form-control" name="<?php //echo $file_doc->id;?>">
            <option value="<?php //echo $file_doc->cancellation_option;?>" selected> -->
            <?php 
            // if($file_doc->cancellation_option=="0"){
            //   echo "disable cancellation";
            // }else if($file_doc->cancellation_option=="1"){
            //   echo "cancellation wthin the day on pending status";
            // }else if($file_doc->cancellation_option=="2"){
            //   echo "allow cancellation while pending status";
            // }else{
            //   echo "no setting";
            // }
           // $file_doc->cancellation_option;

            ?><!-- </option>
            <option value="" disabled></option>
            <option value="0">disable cancellation</option>
            <option value="1">cancellation wthin the day on pending status</option>
            <option value="2">allow cancellation while pending status</option>
            </select>    -->                
        </td>
        <td><!-- //===============================delete transactions  -->  
          <?php            
          $t_delete = $this->transaction_employees_model->to_delete_trans($file_doc->identification,$file_doc->t_table_name);
          if(!empty($t_delete)){
          echo '<a href="'.base_url().'app/transaction_employees/delete_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to Select [ '.$file_doc->form_name.' ] Transactions to delete" role="button" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> delete</a>';
          }else{
               
                  echo '<a class="text-danger"><i class="fa fa-remove"></i>no transactions to be deleted</a>';              
          }
           


          ?>
        </td>
        <td><!-- //===============================transfer approval of transactions  -->  
          <?php 
          $current_form=$file_doc->identification;      //variable name important     
          $t_transfer = $this->transaction_employees_model->form_approvers($current_form);
          if(!empty($t_transfer)){
          echo '<a href="'.base_url().'app/transaction_employees/transfer_transactions_approval/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to Select [ '.$file_doc->form_name.' ] Transactions to transfer approval" role="button" class="btn btn-primary btn-xs"><i class="fa fa-mail-forward"></i> transfer approval</a>';
          }else{
          echo '<a class="text-danger"><i class="fa fa-remove"></i>no form approvers yet</a>';
          }
          ?>
        </td>
        <td><!-- //===============================pending transactions  -->  
           <?php            
          $v_pending = $this->transaction_employees_model->pending_list($file_doc->identification,$file_doc->t_table_name);
          if(!empty($v_pending)){
          echo '<a href="'.base_url().'app/transaction_employees/pending_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to View [ '.$file_doc->form_name.' ] Pending Transactions" role="button" class="btn btn-warning btn-xs"><i class="fa fa-info-circle"></i> pending</a>';
          }else{
          echo '<a class="text-danger"><i class="fa fa-remove"></i>no pending transactions</a>';
          }
          ?>


        </td>
        <td><!-- //===============================error transactions (no assigned approvers) -->  
          <?php 
// $find_error = $this->transaction_employees_model->if_error_occur($file_doc->t_table_name,$file_doc->identification);
// if(!empty($find_error)){
//          echo '<i class="fa fa-check-circle-o text-success"></i>with form approvers<br>'; // with form approvers
//        }else{
//          echo '<a href="'.base_url().'app/transaction_employees/error_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to View [ '.$file_doc->form_name.' ] Error Transactions" role="button" class="btn btn-default btn-xs"><i class="fa fa-warning text-danger"></i> no form approvers</a><br>';
//        }
//        if(($file_doc->t_table_name=="emp_change_sched")OR($file_doc->t_table_name=="emp_atro")OR($file_doc->t_table_name=="emp_change_rest_day")){
//                 $count = $this->transaction_employees_model->count_transaction_none_mass_encoding($file_doc->t_table_name);             
//            }else if($file_doc->t_table_name==""){
//               echo "no database table yet";
//            }else {
//                 $count = $this->transaction_employees_model->count_transaction($file_doc->t_table_name);                 
//            }
//        // 
//            if(($file_doc->t_table_name=="emp_change_sched")OR($file_doc->t_table_name=="emp_atro")OR($file_doc->t_table_name=="emp_change_rest_day")){
//                 $get_form_emp = $this->transaction_employees_model->count_transaction_none_mass_encoding($file_doc->t_table_name);                     
//            }else if($file_doc->t_table_name==""){
//               echo "no database table yet";
//            }else {
//                 $get_form_emp = $this->transaction_employees_model->count_transaction($file_doc->t_table_name);                 
//            }
//               $form_emp = count($get_form_emp);
//                 if($form_emp=="0"){
//                   echo '';//'  <button class="btn btn-danger btn-xs">[ '.$form_emp.' ]</button>';
//                 }
//                 else{
//                   //echo ' <a href="'.base_url().'app/transaction_employees/view_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to View [ '.$file_doc->form_name.' ] transactions" role="button" class="btn btn-danger btn-xs">[ '.$form_emp.' ]</a>';
//           foreach($get_form_emp as $emp_applied){
//                    $emp_applied->employee_id;
//           //find if any employee had no approver 
//           $cur_form= $file_doc->identification;//prefix of form example.HR002
//           $dept=$emp_applied->department;
//           $sect=$emp_applied->section;
//           $clas=$emp_applied->classification;
//           $employee_applied="";
//           $get_all_app=$this->transaction_employees_model->get_all_app($dept,$sect,$clas,$cur_form);
//           if(empty($get_all_app)){
//                  $employee_applied.="no_approver_found";}
//           foreach($get_all_app as $doc_app){
//           $name=$doc_app->first_name. " ".$doc_app->middle_name. " ".$doc_app->last_name. " ";
//                  $employee_applied.="_".$doc_app->employee_id;
//           }
//                 }
// if (strpos($employee_applied, 'no_approver_found') !== false) {
// //echo 'employee(s) had no approver';
// echo '<a href="'.base_url().'app/transaction_employees/error_transactions/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to View [ '.$file_doc->form_name.' ] Error Transactions" role="button" class="btn btn-default btn-xs"><i class="fa fa-warning text-danger"></i> employee(s) had no approver</a>';
// }else{
// echo '<i class="fa fa-check-circle-o text-success"></i>employee(s) have approver';
// } 
//                 }

//           // 


          ?>
          </td>         
          <td><!-- //===============================history (no assigned approvers) --> 
             <?php
           if($file_doc->t_table_name==""){
              echo "no database table yet";
           }else{
                $count = $this->transaction_employees_model->count_transaction_on_history($file_doc->t_table_name);
                  $array_items = count($count);
                if($array_items=="0"){
                echo $file_doc->form_name. ' [ '.$array_items.' ]';
                }
                else{
                echo '<a href="'.base_url().'app/transaction_employees/trans_history/'.$file_doc->t_table_name.'/'.$file_doc->form_name.'/'.$file_doc->identification.'" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to View [ '.$file_doc->form_name.' ] transactions" role="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i>  '.$file_doc->form_name. ' [ '.$array_items.' ]</a>';
                }                 
           }           
         
          ?>
          </td>
      </tr>
            <?php } ?>  
              </tbody>
            </table>   
</form>

      </div>   <!--  for table responsiveness -->

        </div>
      </div>
    </div>
    <!--End Employee List Modal Container-->
    <!-- End Content Wrapper. Contains page content -->

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
    <!--//==========End Js/bootstrap==============================//-->

  <!--Start AJAX FUNCTIONS-->   
 <script>
      //for datatables
   $(function () {
     //Initialize Select2 Elements
      $(".select2").select2();
      $("#table_home").DataTable( { lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]   });
    });
function editSendingEmail(val)
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
            
            document.getElementById("editSendingEmail").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/editSendingEmail/"+val,true);
        xmlhttp.send();

        }
function autoload()
{
  getEmployeeList(''); 
}
function getEmployeeList(val)
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
    document.getElementById("showSearchResult").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/showSearchEmployee/"+val,true);
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/select_emp/"+val,false);
        xmlhttp2.send();

        }
// function open_approvers()
//         {  

//         var location = document.getElementById("location").value;
//         var classification = document.getElementById("classification").value;
//         var current_loc = document.getElementById("current_loc").value;
//         var current_doc = document.getElementById("current_doc").value;
      
            
//         if (window.XMLHttpRequest)
//           {
//           xmlhttp2=new XMLHttpRequest();
//           }
//         else
//           {// code for IE6, IE5
//           xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
//           }
//         xmlhttp2.onreadystatechange=function()
//           {
//           if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
//             {
            
//             document.getElementById("show_approvers").innerHTML=xmlhttp2.responseText;
//             }
//           }
//         xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/form_transaction_details_HR002_approvers/"+location+"/"+classification+"/"+current_loc+"/"+current_doc,false);
//         xmlhttp2.send();

//         }
function get_section()
        {  

        var department_add = document.getElementById("department_add").value;
                 
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
            
            document.getElementById("show_section").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/get_section/"+department_add,false);
        xmlhttp2.send();

        }
function active_transaction()
        {  

      var location = document.getElementById("location").value;
      var classification = document.getElementById("classification").value;
      var department_add = document.getElementById("department_add").value;
      var t_form = document.getElementById("t_form").value;
     
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
            
            document.getElementById("show_filing_assigned").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/filing_control/"+location+"/"+classification+"/"+department_add+"/"+t_form,false);
        xmlhttp2.send();

        }
function gotoPage()
        {  

        var page = document.getElementById("page").value;
      
            
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
            
            document.getElementById("showdate").innerHTML=xmlhttp2.responseText;
             $("#blocked_leave").DataTable({
                        
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
            }
          }

        xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/"+page,false);
        xmlhttp2.send();
        }       
function download_template()
        {  

        var template = document.getElementById("template").value;
      
            
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
            
            document.getElementById("download_button").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/get_template/"+template,false);
        xmlhttp2.send();


        }        
   function create_new_transaction(val)
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
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_file_maintenance/create/"+val,true);
        xmlhttp.send();

        }
   function next()
        {          
        var no_of_field = document.getElementById('no_of_field').value;     
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
        xmlhttp.open("GET","<?php echo base_url();?>app/transaction_file_maintenance/next/"+no_of_field,false);
        xmlhttp.send();

        }

        function getLocation(val)
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
              
              document.getElementById("location").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/getLocation/"+val,false);
          xmlhttp.send();
        }
        function save_blocked_dates()
        {

          var datess = document.getElementById('date').value;
          var company= document.getElementById('company').value;
          var count= document.getElementById('location_count').value;
          
          if(datess=='' || count==''){ alert('Please Fill up all fields to continue'); }
          else { 
          var checks = document.getElementsByClassName("location");
          var location='';

          for (i=0;i<count; i++)
            {
            if (checks[i].checked === true)
            {
                location +=checks[i].value + "-";
                
              }
            }
            if(location=='')
              { alert('Select Atleast one location to continue'); }
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
              
              document.getElementById("coll_2").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/save_blocked_dates/"+datess+"/"+company+"/"+location,false);
          xmlhttp.send();
        } }
        }
        function delete_date(val)
        {

         var result = confirm("Are you sure you want to delete this record?");
          if(result == true)
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
              
              document.getElementById("coll_2").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                        
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/delete_date/"+val,false);
          xmlhttp.send();
        }
        }
        function getEmployees(option,company_id,division,department,section,subsection)
        {
          var company =document.getElementById('company').value;
          if(option=='Company')
          {
           
            loadDivision(company);
          }
          else if(option=='Division')
          {
            
             loadDept(division);
          }
          else if(option=='Department')
          {
              get_section(department);
          }
          else if(option=='Section')
          {
            get_subsection(section);
          }
          var xmlhttp;

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
              
              document.getElementById("members").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });

              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/getEmployees/"+option+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection,false);
          xmlhttp.send();

        }

        function loadDivision(val)
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
               document.getElementById("division").innerHTML=xmlhttp2.responseText;
              }
            }
          xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/load_division/"+val,false);
          xmlhttp2.send();
        }
          function loadDept(val)
          {  
          var division = document.getElementById('division').value;
          var company = document.getElementById('company').value;
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
                 document.getElementById("department").innerHTML=xmlhttp2.responseText;
                }
              }
            xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/load_dept/"+val+"/"+company,false);
            xmlhttp2.send();
       
        }
         function get_section(val)
        {  
          var div = document.getElementById('division').value;
          var dept = document.getElementById('department').value;
          var company = document.getElementById('company').value;
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
             document.getElementById("section").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/load_section/"+val+"/"+div+"/"+dept,false);
        xmlhttp2.send();
          
        }
         function get_subsection(val)
    {
          var div = document.getElementById('division').value;
          var dept = document.getElementById('department').value;
          var company = document.getElementById('company').value;
      

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
            document.getElementById("subsection").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/load_subsection/"+val+"/"+div+"/"+dept+"/"+company,false);
        xmlhttp2.send();
     
  }


        function for_emp(val,emp)
        {  
          var i = 'c'+val;
          if(document.getElementById(i).checked==true)
          {
              var selected = document.getElementById('selected_emp').value;

              selected +=emp + "-";
              document.getElementById('selected_emp').value=selected;   
          } 
          else
          {  
              var selected = document.getElementById('selected_emp').value;
              var res = selected.replace(emp+"-", "");
              document.getElementById('selected_emp').value=res;
              document.getElementById('cAll').checked=false;
          }

        
        }
         function for_emp_upd(emp)
        {  
          var i = 'c'+emp;
          if(document.getElementById(i).checked==true)
          {
              var selected = document.getElementById('selected_emp').value;

              selected +=emp + "-";
              document.getElementById('selected_emp').value=selected;   
          } 
          else
          {  
              var selected = document.getElementById('selected_emp').value;
              var res = selected.replace(emp+"-", "");
              document.getElementById('selected_emp').value=res;
          }

        
        }
        function save_atro_members()
        {
          var company = document.getElementById('company').value;
          var type = document.getElementById('type').value;
          var group_name = document.getElementById('group_name').value;
          function_escape("group",group_name);
          var group_final = document.getElementById("group").value;
          var employees = document.getElementById('selected_emp').value 
          
          if(company=='' || type=='' || group_name=='')
          {
            alert('Please fill up all fields to continue');
          }
          else if(employees=='')
            { alert('Please select atleast one employee to continue'); }
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
                    
                    document.getElementById("coll_2").innerHTML=xmlhttp.responseText;
                    $("#blocked_leave").DataTable({
                                 lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                                });

                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/save_atro_members/"+company+"/"+type+"/"+group_final+"/"+employees,false);
                xmlhttp.send();
          }
       
        }

    function add_policy_group()
    {
      document.getElementById('policy_t').value='All';
      document.getElementById('group_list_company').value='';
      document.getElementById('company_f').value='';
      
       
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
              
              document.getElementById("main_atro").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });

              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/add_new_atro_group/",false);
          xmlhttp.send();
    }

    function getGroupList(policy)
    {
      var company = document.getElementById('company_f').value;
      if(company==''){ alert('Please select company to continue'); }
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
              
              document.getElementById("group_list_company").innerHTML=xmlhttp.responseText;

              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/getGroupList/"+company+"/"+policy,false);
          xmlhttp.send();

      }

    }

    function policy_group_details(group)
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
              
              document.getElementById("main_atro").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });

              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/policy_group_details/"+group,false);
          xmlhttp.send();
    }

    function delete_group_member(member,group)
    {
        var result = confirm("Are you sure you want to delete this record?");
          if(result == true)
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
              
              document.getElementById("main_atro").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });

              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/delete_member_policy/"+member+"/"+group,false);
          xmlhttp.send();
        } else{}
    }
    function del_group_policy(group)
    {
         var result = confirm("Are you sure you want to delete this record?");
          if(result == true)
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
                    
                    document.getElementById("coll_2").innerHTML=xmlhttp.responseText;
                    $("#blocked_leave").DataTable({
                                 lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                                });

                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/del_group_policy/"+group,false);
                xmlhttp.send();
        } else{}
    }

    function update_group_policy(group,company)
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
                    
                    document.getElementById("main_atro").innerHTML=xmlhttp.responseText;
                    $("#blocked_leave").DataTable({
                                 lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]]             
                                });

                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/update_group_details/"+group+"/"+company,false);
                xmlhttp.send();
    }
     function save_updated_group_policy(group)
        {
          var company = document.getElementById('company_upd').value;
          var type = document.getElementById('policy_upd').value;
          var group_name = document.getElementById('group_upd').value;
          function_escape("group_f",group_name);
          var group_final = document.getElementById("group_f").value;
          var employees = document.getElementById('selected_emp').value 
          
          
          if(company=='' || type=='' || group_name=='')
          {
            alert('Please fill up all fields to continue');
          }
          else if(employees=='')
            { alert('Please select atleast one employee to continue'); }
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
                    
                    document.getElementById("main_atro").innerHTML=xmlhttp.responseText;
                    $("#blocked_leave").DataTable({
                                 lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                                });

                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/save_updated_group_policy/"+company+"/"+type+"/"+group_final+"/"+employees+"/"+group,false);
                xmlhttp.send();
          }
       
        }
      function atro_home()
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
            
            document.getElementById("coll_2").innerHTML=xmlhttp2.responseText;
             $("#blocked_leave").DataTable({
                        
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
            }
          }

        xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/atro_members/",false);
        xmlhttp2.send();


        }  

    function checkall(option,company,division,department,section,subsection)
    {
     if(document.getElementById('cAll').checked)
      {
        var value = 1;
       
      } else{ var value =0; }
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
            
            document.getElementById("check_uncheck").innerHTML=xmlhttp2.responseText;
            $("#blocked_leave").DataTable({
                        
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
            }
          }

        xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/check_employees/"+option+"/"+company+"/"+division+"/"+department+"/"+section+"/"+subsection+"/"+value,false);
        xmlhttp2.send();
    } 
    function function_escape(ids,titles)
    {
       var a = titles.replace(/\?/g, '-a-');
       var b = a.replace(/\!/g, "-b-");
       var c = b.replace(/\//g, "-c-");
       var d = c.replace(/\|/g, "-d-");
       var e = d.replace(/\[/g, "-e-");
       var f = e.replace(/\]/g, "-f-");
       var g = f.replace(/\(/g, "-g-");
       var h = g.replace(/\)/g, "-h-");
       var i = h.replace(/\{/g, "-i-");
       var j = i.replace(/\}/g, "-j-");
       var k = j.replace(/\'/g, "-k-");
       var l = k.replace(/\,/g, "-l-");
       var m = l.replace(/\'/g, "-m-");
       var n = m.replace(/\_/g, "-n-");
       var o = n.replace(/\@/g, "-o-");
       var p = o.replace(/\#/g, "-p-");
       var q = p.replace(/\%/g, "-q-");
       var r = q.replace(/\$/g, "-r-");
       var s = r.replace(/\^/g, "-s-");
       var t = s.replace(/\&/g, "-t-");
       var u = t.replace(/\*/g, "-u-");
       var v = u.replace(/\+/g, "-v-");
       var w = v.replace(/\=/g, "-w-");
       var x = w.replace(/\:/g, "-x-");
       var y = x.replace(/\;/g, "-y-");
       var z = y.replace(/\%20/g, "-z-");
       var aa = y.replace(/\./g, "-zz-");
       var bb = aa.replace(/\</g, "-aa-");
       var cc = bb.replace(/\>/g, "-bb-");
       document.getElementById(ids).value=cc;
    }
    //for trip ticket
     function save_trip_ticket()
        {

        
          var car_model = document.getElementById("model").value;
          var platenumber = document.getElementById('platenumber').value;
          function_escape("car_p",platenumber);
          var car_platenumber= document.getElementById("car_p").value;
          var company= document.getElementById('company').value;
          var count= document.getElementById('location_count').value;
          
          if(model=='' || platenumber=='' || count==''){ alert('Please Fill up all fields to continue'); }
          else { 
          var checks = document.getElementsByClassName("location");
          var location='';

          for (i=0;i<count; i++)
            {
            if (checks[i].checked === true)
            {
                location +=checks[i].value + "-";
                
              }
            }
            if(location=='')
              { alert('Select Atleast one location to continue'); }
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
              
              document.getElementById("coll_2").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/save_trip_ticket/"+car_model+"/"+car_platenumber+"/"+company+"/"+location,false);
          xmlhttp.send();
        } }
        }
         function delete_trip_ticket(val)
        {

         var result = confirm("Are you sure you want to delete this record?");
          if(result == true)
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
              
              document.getElementById("coll_2").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                        
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/delete_trip_ticket/"+val,false);
          xmlhttp.send();
        }
        }
        function edit_trip_ticket(val)
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
              
              document.getElementById("add_edit").innerHTML=xmlhttp.responseText;
            
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/edit_trip_ticket/"+val,false);
          xmlhttp.send();
        }
        }

    function save_updated_tripticket(id)
    {
          
          var car_model = document.getElementById("model").value;
          var platenumber = document.getElementById('platenumber').value;
          function_escape("car_p",platenumber);
          var car_platenumber= document.getElementById("car_p").value;
          
          
          if(model=='' || platenumber==''){ alert('Please Fill up all fields to continue'); }
          else { 
          
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
              
              document.getElementById("coll_2").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/save_updated_tripticket/"+car_model+"/"+car_platenumber+"/"+id,false);
          xmlhttp.send();
        } 
    }

    function manage_car_model()
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
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/manage_car_model/",false);
          xmlhttp.send();
    }

    function save_model(option,id)
    {
      var m = document.getElementById('model_').value;
      function_escape("model_name",m);
      var model= document.getElementById("model_name").value;
      if(model=='')
      {
        alert("Please fill up the car model field to continue");
      }
      else
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
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/save_model/"+option+"/"+model+"/"+id,false);
          xmlhttp.send();
      }
    }
    function edit_trip_ticket_model(id)
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
              document.getElementById("addedit_model").innerHTML=xmlhttp.responseText;
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/edit_trip_ticket_model/"+id,false);
          xmlhttp.send();
    }
     function delete_trip_ticket_model(option,id)
    {
      var model = 'none';
      var result = confirm("Are you sure you want to delete this record?");
      if(result == true)
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
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/save_model/"+option+"/"+model+"/"+id,false);
          xmlhttp.send();
        }
    }
    function  tripticket_home()
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
              
              document.getElementById("coll_2").innerHTML=xmlhttp.responseText;
              $("#blocked_leave").DataTable({
                           lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                          });
              }
            }
          xmlhttp.open("GET","<?php echo base_url();?>app/transaction_employees/trip_ticket/",false);
          xmlhttp.send();

      }
</script>

  <!--END ajaxX FUNCTIONS-->