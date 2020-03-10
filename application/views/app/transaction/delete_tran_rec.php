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
    document.getElementById("to_edit_table").style.display='none';
    document.getElementById("to_view").style.display='none';
     document.getElementById("deleted").style.display='none';
    document.getElementById("sd").style.display='none';
    }
// 
    function show_deleted(){
        document.getElementById("viewing").style.display='block';
        document.getElementById("std").style.display='block';
        document.getElementById("sd").style.display='none';
        document.getElementById("deleted").style.display='none';
    }
    function show_to_deleted(){
        document.getElementById("deleted").style.display='block';
        document.getElementById("sd").style.display='block';
        document.getElementById("std").style.display='none';
        document.getElementById("viewing").style.display='none';
         document.getElementById("to_edit_table").style.display='none';
    }

// 
    function show_edit(){
        document.getElementById("to_edit_table").style.display='block';
        document.getElementById("to_view").style.display='block';
        document.getElementById("to_edit").style.display='none';
        document.getElementById("viewing").style.display='none';
         document.getElementById("deleted").style.display='none';
                 document.getElementById("std").style.display='block';
        document.getElementById("sd").style.display='none';
    }
    function show_view(){
        document.getElementById("viewing").style.display='block';
        document.getElementById("to_edit").style.display='block';
        document.getElementById("to_view").style.display='none';
        document.getElementById("to_edit_table").style.display='none';

        document.getElementById("deleted").style.display='none';
        document.getElementById("std").style.display='block';
        document.getElementById("sd").style.display='none';
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
      <li class="active">Delete <?php echo urldecode($this->uri->segment('5'));?> Transactions</li>
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
          <strong><a class="text-danger"><i class="fa fa-remove"></i> Delete</a>&nbsp;<u> <?php echo urldecode($this->uri->segment('5'));?> Transactions</u></strong>     
          <form name="f" method="post" action="<?php echo base_url()?>app/transaction_employees/delete_all_transactions/<?php echo $this->uri->segment('4');?>/<?php echo $this->uri->segment('5');?>" >  

<button type="button" id="to_edit" class="btn btn-success pull-right btn-xs " onclick ="show_edit()"><i class="fa fa-edit"></i> edit mode?</button>
<button type="button" id="to_view" class="btn btn-success pull-right btn-xs " onclick ="show_view()"><i class="fa fa-folder-open"></i> view mode?</button>

                   <button type="submit" class="btn btn-danger btn-xs pull-right" onclick="return confirm('Are you sure you want to delete all <?php echo urldecode($this->uri->segment('5'));?> ?')" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to delete all leave transaction"><i class="fa fa-floppy-o"></i> Delete All?</button>

<button type="button" id="sd" style="background-color: #838911;border-color: #838911;" class="btn btn-warning pull-right btn-xs " onclick ="show_deleted()"><i class="fa fa-eye"></i> View Active Transactions?</button>
<button type="button" id="std" class="btn btn-warning pull-right btn-xs " onclick ="show_to_deleted()"><i class="fa fa-eye"></i> View Deleted Transactions?</button>



	</form>
        </div>
        <div class="box-body">

<div class="table-responsive" id="deleted">

<button type="button" class="btn btn-warning btn-xs "><i class="fa fa-arrow-down"></i> Deleted Transactions Record</button>
               <table id="example" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <td width="7%">Date Filed</td>
                  <td width="8%">Doc.No</td>
                  <td width="8%">Employee ID</td>
                  <td width="19%">Employee Name</td>
                  <td width="8%">Classification</td>
                  <td width="8%">Department</td>
                  <td width="8%">Section</td>
                  <td width="10%">Position</td>
                  <td width="10%">Remarks</td>
                  <td width="8%">Entry Type</td>
                  <td width="5%">Status</td>
                  
                </tr>
              </thead>
              <tbody>
              <?php foreach($file_d as $file_doc){?>
                <tr <?php if ($file_doc->status=="cancel"){echo 'class="text-danger"';}else if($file_doc->status=="pending"){echo 'class="text-warning"';}else{echo 'class="text-info"';} ?>>
                  <td><?php echo $file_doc->date_created; ?></td>
                  <td>
                    <?php echo ' <a target="_blank"  href="'.base_url().'app/transaction_employees/form_view/'.$file_doc->doc_no.'/'.$this->uri->segment('4').'/'.$this->uri->segment('6').'" title="Click to View Form" role="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> '.$file_doc->doc_no.'</a>'; ?>
                  </td>
                    <td> <?php echo $file_doc->employee_id; ?></td>
                  <td> <?php echo $file_doc->first_name. " ".$file_doc->middle_name. " ".$file_doc->last_name. " "; ?></td>
                  <td  > 
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


<div class="table-responsive" id="viewing">               
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <td width="7%">Date Filed</td>
                  <td width="8%">Doc.No</td>
                  <td width="8%">Employee ID</td>
                  <td width="19%">Employee Name</td>
                  <td width="8%">Classification</td>
                  <td width="8%">Department</td>
                  <td width="8%">Section</td>
                  <td width="10%">Position</td>
                  <td width="10%">Remarks</td>
                  <td width="8%">Entry Type</td>
                  <td width="5%">Status</td>
                  
                </tr>
              </thead>
              <tbody>
              <?php foreach($file as $file_doc){?>
                <tr <?php if ($file_doc->status=="cancel"){echo 'class="text-danger"';}else if($file_doc->status=="pending"){echo 'class="text-warning"';}else{echo 'class="text-info"';} ?>>
                  <td><?php echo $file_doc->date_created; ?></td>
                  <td>
                    <?php echo ' <a target="_blank"  href="'.base_url().'app/transaction_employees/form_view/'.$file_doc->doc_no.'/'.$this->uri->segment('4').'/'.$this->uri->segment('6').'" title="Click to View Form" role="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> '.$file_doc->doc_no.'</a>'; ?>
                  </td>
                    <td> <?php echo $file_doc->employee_id; ?></td>
                  <td> <?php echo $file_doc->first_name. " ".$file_doc->middle_name. " ".$file_doc->last_name. " "; ?></td>
                  <td  > 
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
 <!-- //===========================editing -->
<div class="table-responsive" id="to_edit_table">          
<form name="f1" method="post" action="<?php echo base_url()?>app/transaction_employees/save_delete_transactions/<?php echo $this->uri->segment('4');?>/<?php echo $this->uri->segment('5');?>" >        
            <table id="" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <td width="7%">Date Filed</td>
                  <td width="8%">Doc.No</td>
                  <td width="8%">Employee ID</td>
                  <td width="19%">Employee Name</td>
                  <td width="8%">Classification</td>
                  <td width="8%">Department</td>
                  <td width="8%">Section</td>
                  <td width="10%">Position</td>
                  <td width="8%">Entry Type</td>
                  <td width="5%">Status</td>
                  <td width="20%" style="text-align: center;"> 
 <button type="submit" class="btn btn-warning btn-xs pull-right" onclick="return confirm('Are you sure you want to delete selected <?php echo urldecode($this->uri->segment('5'));?> ?')"data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to delete selected <?php echo urldecode($this->uri->segment('5'));?> "><i class="fa fa-floppy-o text-success"></i> Delete / Update?</button>
 <i class="fa fa-arrow-up text-danger"></i>
                   </td>
                </tr>
              </thead>
              <tbody>
              <?php foreach($file as $file_doc){?>
                <tr <?php if ($file_doc->status=="cancel"){echo 'class="text-danger"';}else if($file_doc->status=="pending"){echo 'class="text-warning"';}else{echo 'class="text-info"';} ?>>
                  <td><?php echo $file_doc->date_created; ?></td>
                  <td>
                    <?php echo ' <a target="_blank"  href="'.base_url().'app/transaction_employees/form_view/'.$file_doc->doc_no.'/'.$this->uri->segment('4').'/'.$this->uri->segment('6').'" title="Click to View Form" role="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> '.$file_doc->doc_no.'</a>'; ?>
                  </td>
                  	<td> <?php echo $file_doc->employee_id; ?></td>
	                <td> <?php echo $file_doc->first_name. " ".$file_doc->middle_name. " ".$file_doc->last_name. " "; ?></td>
	                <td  > 
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
                   <td  > <?php echo $file_doc->entry_type; ?></td>
	               	<td  > <?php echo $file_doc->status; ?></td>
               <td>  

					<div class="form-group">
						<label for="comment" ><i>Comment</i></label>
						<input type="text" class="form-control" name="<?php echo $file_doc->id;?>"  value="<?php echo $file_doc->remarks;?>">
						<input type="checkbox" value="<?php echo $file_doc->doc_no;?>" name="doc_no[]" >
					</div>				   
               </td>
             
                </tr>
                 <?php } ?>  
              </tbody>
            </table> 
      
 </form></div>

         </div>
      </div>
    </div>



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

        var example1 = $('#example1').dataTable();
        example1.fnSort( [ [0,'desc'], [0,'desc'] ] );

        var example = $('#example').dataTable();
        example.fnSort( [ [0,'desc'], [0,'desc'] ] );
      });

    </script>

  </body>
</html>