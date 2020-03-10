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
      <li class="active">Transfer <?php echo urldecode($this->uri->segment('5'));?> Approval</li>
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
          <strong><a class="text-danger"><i class="fa fa-mail-forward"></i> Transfer</a>&nbsp;<u> <?php echo urldecode($this->uri->segment('5'));?> <a class="text-danger">Approval</a></u></strong>     
        </div>
        <div class="box-body">
<form name="f1" method="post" action="<?php echo base_url()?>app/transaction_employees/save_transfer_transactions_approval" >        
	<div class="form-group"   >
			<label for="cutoff" class="col-sm-2 control-label">Transaction Type</label>
		<div class="col-sm-10" >
			<input readonly type="text" name="" class="form-control" placeholder="<?php echo urldecode($this->uri->segment('5'));?>">
			<input  type="hidden" name="cur_form" class="form-control" value="<?php echo urldecode($this->uri->segment('6'));?>">
		</div>
	</div>       
	<div class="form-group"   >
			<label for="cutoff" class="col-sm-2 control-label">From Old Approver</label>
		<div class="col-sm-10" >
			<select name="from_approver" class="form-control select2" required>
			<option selected disabled value="">[ From ] Select Approver</option>
				<?php 
				foreach($file as $app){
					echo '<option value="'.$app->approver.'">'.$app->name.'</option>';
				}
			?>
			</select>	
		</div>
	</div>      
	<div class="form-group">
			<label for="cutoff" class="col-sm-2 control-label">To New Approver</label>
		<div class="col-sm-10" >
			<select name="to_approver" class="form-control select2" required>
			<option selected disabled value="">[ To ] Select Approver</option>
				<?php 
				foreach($emp as $employee){
					echo '<option value="'.$employee->employee_id.'">'.$employee->name.'</option>';
				}
			?>
			</select>	
		</div>
	</div>
	<div class="form-group"   >		
		<div class="col-sm-12" >
&nbsp;
	</div>
	</div>
	<div class="form-group"   >		
		<div class="col-sm-12" >
				<button type="submit" class="btn btn-danger pull-right" onclick="return confirm('Are you sure you want to transfer approval?')" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to delete all leave transaction"><i class="fa fa-floppy-o"></i>Transfer?</button>
	</div>
	</div>

 </form>

         </div>
      </div>
    </div>




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