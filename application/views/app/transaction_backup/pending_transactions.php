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
      <li class="active">Pending <?php echo urldecode($this->uri->segment('5'));?> Transactions</li>
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
          <strong><a class="text-danger"><i class="fa fa-info-circle"></i> Pending</a>&nbsp;<u> <?php echo urldecode($this->uri->segment('5'));?> Transactions</u></strong>     
         
	</form>
        </div>
        <div class="box-body">
     
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
                  <td width="5%">Status</td>
                  <td width="20%"> 
 Approvers
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
	               	<td  > <?php echo $file_doc->status; ?></td>
               <td style="text-align:center;">  
<table>
<tr>
	<?php 
$cur_form=$this->uri->segment('6'); //prefix of form examp.HR002
$dept=$file_doc->department;
$sect=$file_doc->section;
$clas=$file_doc->classification;

$get_all_app=$this->transaction_employees_model->get_all_app($dept,$sect,$clas,$cur_form);
if(empty($get_all_app)){echo "warning: no approvers yet.";}
foreach($get_all_app as $doc_app){
$name=$doc_app->first_name. " ".$doc_app->middle_name. " ".$doc_app->last_name. " ";
$app_position=$doc_app->position_name;

  if ($doc_app->approval_level=="1"){
    $ext="st";
  }else if($doc_app->approval_level=="2"){
    $ext="nd";
  }else if($doc_app->approval_level=="3"){
    $ext="rd";
  }else{
    $ext="th";
  }
$trans_stat=$this->transaction_employees_model->get_trans_stat($doc_app->approver,$file_doc->doc_no);
  if(!empty($trans_stat)){
    foreach($trans_stat as $t_stat){
       $stat=$t_stat->status;     
    }
  }else{
       $stat="pending";
  }
  //
  if($stat=="approved"){
    $bgstyle='#000';
  }else{
    $bgstyle='#ff0000';
  }
      echo '
         <td width="220px" style="color:'.$bgstyle.';">
           <label style="text-transform:uppercase;text-decoration:none;">'.$stat.'</label><br>  
            <font style="text-decoration:underline; ">'.'['.$doc_app->approver.'] '.$name.'</font><br>'.$doc_app->approval_level.$ext. ' Level'.'<br>'.$app_position.'
          </td>
          ';
}
?>	
</tr>
</table>




               </td>
             
                </tr>
                 <?php } ?>  
			
              </tbody>
            </table> 
       


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

        $("#example1").DataTable();
      });

    </script>

  </body>
</html>