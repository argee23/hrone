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
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
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
Dashboard  <small>Generate Payslip</small>
<?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
?>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Dashboard</li>
</ol>
</section>

<section class="content">
<div class="row">
<!--//============================================================= Start Main content -->  
      <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Emp. ID</th>
            <th>Employee Name</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Ann</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Ben</td>
          </tr>
        </tbody>
      </table>
      </div>

<!--//============================================================= End Main content -->
</div>
</section>



</div><!-- /.content-wrapper -->






<footer class="footer ">
<div class="container-fluid">
<strong>Copyright &copy; 2019 <a href="#">Serttech</a>.</strong> All rights reserved.
<div class="text-right">Page rendered in <strong>{elapsed_time}</strong> seconds. <b>Version</b> 2.0</div>
</div>
</footer>


<!--END footer-->
<!--//==========Start Js/bootstrap==============================//-->
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

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
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
<script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
<!--//==========End Js/bootstrap==============================//-->

<script type="text/javascript">

// $(function () {
//   $("#example1").DataTable();
// });
$(document).ready(function() {
$("#example1").DataTable({
"dom": '<"top">Bfrt<"bottom"li><"clear">',
"pageLength":-1,
lengthMenu: [[-1,10, 25, 50, 100], ["All",10, 25, 50, 100]],
buttons:
[
{
extend: 'excel',
title: 'Report'
},
{
extend: 'print',
title: 'Report'
}
]              
});




} );

</script>

</body>
</html>