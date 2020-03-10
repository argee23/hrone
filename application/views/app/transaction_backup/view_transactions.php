<!DOCTYPE html>
<!--
This page is being used to preview transactions of employee leave/change of schedule request
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
        <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    <!-- start//edit/view -->
    <script>
    window.onload=function(){
    document.getElementById("mass_filed").style.display='none';
    document.getElementById("to_show_emp_filed").style.display='none';
    }
    function show_mass(){
        document.getElementById("mass_filed").style.display='block';
        document.getElementById("to_show_emp_filed").style.display='block';
        document.getElementById("to_show_mass").style.display='none';
        document.getElementById("emp_filed").style.display='none';
    }
    function show_emp_filed(){
        document.getElementById("emp_filed").style.display='block';
        document.getElementById("to_show_mass").style.display='block';
        document.getElementById("to_show_emp_filed").style.display='none';
        document.getElementById("mass_filed").style.display='none';
    }
    </script>
     <!-- end//edit/view -->    
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
      <li class="active"><?php echo urldecode($this->uri->segment('5'));?> Transactions</li>
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
          <strong><?php echo urldecode($this->uri->segment('5'));?> Transactions</strong>
<?php
  if (($this->uri->segment('4')=="emp_change_sched") OR ($this->uri->segment('4')=="emp_atro") OR ($this->uri->segment('4')=="emp_change_rest_day")){
?>
<button type="button" id="to_show_mass" class="btn btn-success pull-right btn-xs pull-right" onclick ="show_mass()"><i class="fa fa-info"></i> Employee Filed </button>

<button type="button" id="to_show_emp_filed" class="btn btn-success pull-right btn-xs " onclick ="show_emp_filed()"><i class="fa fa-info"></i>  Automatic Approved [mass encoding/uploading]</button>

<i class="fa fa-arrow-right text-danger pull-right"></i>
<?php            
  }else{
        echo "";
  }
?>

        </div>
        <div class="box-body">
 <div class="table-responsive" id="emp_filed">       
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <td>Date Filed</td>
                  <td>Doc.No</td>
                  <td>Employee ID</td>
                  <td>Employee Name</td>
                  <td width="8%">Classification</td>
                  <td width="8%">Department</td>
                  <td width="8%">Section</td>
                  <td width="10%">Position</td>
                  <td width="10%">Remarks</td>
                  <td width="8%">Entry Type</td>
                  <td>Status</td>
                </tr>
              </thead>
              <tbody>
              <?php foreach($file as $file_doc){?>
                <tr <?php if ($file_doc->status=="cancel"){echo 'class="text-danger"';}else if($file_doc->status=="pending"){echo 'class="text-warning"';}else{echo 'class="text-info"';} ?>>

                  <td><?php echo $file_doc->date_created; ?></td>
                  <td>
                  <?php
                              echo ' <a target="_blank"  href="'.base_url().'app/transaction_employees/form_view/'.$file_doc->doc_no.'/'.$this->uri->segment('4').'/'.$this->uri->segment('6').'" title="Click to View Form" role="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> '.$file_doc->doc_no.'</a>';
                  ?>
                  </td>
                  <td> <?php echo $file_doc->employee_id; ?></td>
                <td> <?php echo $file_doc->first_name. " ".$file_doc->middle_name. " ".$file_doc->last_name. " "; ?></td>
                <td> 
                  <?php 
          $clas=$file_doc->classification; 
          $clas=$this->transaction_employees_model->get_emp_clas($clas);
            foreach($clas as $class){
              echo $class->classification;
            }
                  ?></td>
                  <td  > 
                  <?php 
                  $dept= $file_doc->department; 
          $dept=$this->transaction_employees_model->get_emp_dept($dept);
            foreach($dept as $dpt){
              echo $dpt->dept_name;
          }
                  ?></td>
                  <td  > 
                  <?php 
                  $sect= $file_doc->section; 
          $sec=$this->transaction_employees_model->get_emp_sect($sect);
            foreach($sec as $sect){
              echo $sect->section_name;
          }
                  ?></td>
                  <td  > 
                  <?php 
                  $pos= $file_doc->position; 
          $pos=$this->transaction_employees_model->get_emp_pos($pos);
            foreach($pos as $pos){
              echo $pos->position_name;
          }
                  ?></td>
                   <td  > <?php echo $file_doc->remarks; ?></td>
                <td  > <?php echo $file_doc->entry_type; ?></td>
                <td  > <?php echo $file_doc->status; ?></td>
               
                </tr>
                 <?php } ?>  
              </tbody>
            </table>       
</div>
<!-- //======================= from mass encoding / automatic approve -->
<?php
  if (($this->uri->segment('4')=="emp_change_sched") OR ($this->uri->segment('4')=="emp_atro") OR ($this->uri->segment('4')=="emp_change_rest_day")){
?>

 <div class="table-responsive" id="mass_filed">       
            <table id="example" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <td>Date Filed</td>
                  <td>Doc.No</td>
                  <td>Employee ID</td>
                  <td>Employee Name</td>
                  <td width="8%">Classification</td>
                  <td width="8%">Department</td>
                  <td width="8%">Section</td>
                  <td width="10%">Position</td>
                  <td width="10%">Remarks</td>
                  <td width="8%">Entry Type</td>
                  <td>Status</td>
                </tr>
              </thead>
              <tbody>
              <?php foreach($file_h as $file_doc){?>
                <tr <?php if ($file_doc->status=="cancel"){echo 'class="text-danger"';}else if($file_doc->status=="pending"){echo 'class="text-warning"';}else{echo 'class="text-info"';} ?>>

                  <td><?php echo $file_doc->date_created; ?></td>
                  <td>
                  <?php
                              echo ' <a target="_blank"  href="'.base_url().'app/transaction_employees/form_view/'.$file_doc->doc_no.'/'.$this->uri->segment('4').'/'.$this->uri->segment('6').'" title="Click to View Form" role="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> '.$file_doc->doc_no.'</a>';
                  ?>
                  </td>
                  <td> <?php echo $file_doc->employee_id; ?></td>
                <td> <?php echo $file_doc->first_name. " ".$file_doc->middle_name. " ".$file_doc->last_name. " "; ?></td>
                <td> 
                  <?php 
          $clas=$file_doc->classification; 
          $clas=$this->transaction_employees_model->get_emp_clas($clas);
            foreach($clas as $class){
              echo $class->classification;
            }
                  ?></td>
                  <td  > 
                  <?php 
                  $dept= $file_doc->department; 
          $dept=$this->transaction_employees_model->get_emp_dept($dept);
            foreach($dept as $dpt){
              echo $dpt->dept_name;
          }
                  ?></td>
                  <td  > 
                  <?php 
                  $sect= $file_doc->section; 
          $sec=$this->transaction_employees_model->get_emp_sect($sect);
            foreach($sec as $sect){
              echo $sect->section_name;
          }
                  ?></td>
                  <td  > 
                  <?php 
                  $pos= $file_doc->position; 
          $pos=$this->transaction_employees_model->get_emp_pos($pos);
            foreach($pos as $pos){
              echo $pos->position_name;
          }
                  ?></td>
                   <td  > <?php echo $file_doc->remarks; ?></td>
                <td  > <?php echo $file_doc->entry_type; ?></td>
                <td  > <?php echo $file_doc->status; ?></td>
               
                </tr>
                 <?php } ?>  
              </tbody>
            </table>       
</div>
<?php            
  }else{
      echo "";
  }
?>
        </div>
      </div>
    </div>
<script >
// function gotoPage()
//         {  

//         var page = document.getElementById("page").value;
      
            
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
            
//             document.getElementById("showdate").innerHTML=xmlhttp2.responseText;
//             }
//           }
//         xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/"+page,false);
//         xmlhttp2.send();


//         }
// function download_template()
//         {  

//         var template = document.getElementById("template").value;
      
            
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
            
//             document.getElementById("download_button").innerHTML=xmlhttp2.responseText;
//             }
//           }
//         xmlhttp2.open("GET","<?php echo base_url();?>app/transaction_employees/get_template/"+template,false);
//         xmlhttp2.send();


//         }        
//    function create_new_transaction(val)
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
//         xmlhttp.open("GET","<?php echo base_url();?>app/transaction_file_maintenance/create/"+val,true);
//         xmlhttp.send();

//         }
//    function next()
//         {          
//         var no_of_field = document.getElementById('no_of_field').value;     
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
//         xmlhttp.open("GET","<?php echo base_url();?>app/transaction_file_maintenance/next/"+no_of_field,false);
//         xmlhttp.send();

//         }
</script>


    <div class="col-md-6" id="showdate"></div>



  </div>


  
    
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

             
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

        //$("#example1").DataTable();
        var example1 = $('#example1').dataTable();
        example1.fnSort( [ [0,'desc'], [0,'desc'] ] );

        var example = $('#example').dataTable();
        example.fnSort( [ [0,'desc'], [0,'desc'] ] );
       
      });
    </script>

  </body>
</html>