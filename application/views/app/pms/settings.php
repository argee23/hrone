<!DOCTYPE html>
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
<!--end of DataTables -->
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
<link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
</head>

<script>
window.onload = function() { <?php echo $onload ?>; };
</script>

</head>


<?php 

require_once(APPPATH.'views/include/header.php');

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


<div class="content-wrapper2">
<section class="content-header">

<h1>
Form Setting
<?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
?>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Form Setting</li>
</ol>
</section>

<section class="content">

<!--//============================================================= Start Main content -->	

   <?php echo $message;?>
              <?php echo validation_errors(); ?>
              <div class="box box-primary">

              <br>
                <div class="box-header">
                <!-- <h3 class="box-title"></h3> -->
          
                <div class="btn-toolbar">
                <!--  class="btn-toolbar/M11 -->

          <!--         <a href="#filter" role="button" data-toggle="collapse" class="btn btn-warning btn-xs "><i class="fa fa-arrow-down"></i> More Filter Options</a> -->
                  

                

                  <a href="#" type="button" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-user-plus"></i> Add Form</a>
               

                  </div><!-- /.btn-toolbar/M11 -->
              </div>
          

		
         <div class="box box-body">
		 <table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Form Title</th>
						<th>Form Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($appraisal_form as $appraisal_form){ ?>
					<tr>
						<td><?php echo $appraisal_form->form_title ?></td>
						<td><?php echo $appraisal_form->form_description ?></td>
						<td><a href="#"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true" title="edit" style="color: green;"></i></a>
							  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="#"><i class="fa fa-trash fa-lg" aria-hidden="true" title="delete" style="color: red;"></i></a>
						</td>
					</tr>
						<?php } ?>
				</tbody>
			</table>
	</div>


	</div>

<!--//============================================================= End Main content -->

</section>



</div><!-- /.content-wrapper -->






 <?php require_once(APPPATH.'views/include/footer.php');?>


<!--END footer-->
<!--//==========Start Js/bootstrap==============================//-->



<script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
<script>vex.defaultOptions.className = 'vex-theme-os'</script>
<script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>public/app.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
<script src="<?php echo base_url()?>public/angular.min.js"></script>
<script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">

   
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  

  <!-- DataTables -->
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
<!--//==========End Js/bootstrap==============================//-->

<script type="text/javascript">

// $(function () {
//   $("#example1").DataTable();
// });

     
 
$(document).ready(function() {

    $("#example1").DataTable();




} );


</script>

</body>
</html>