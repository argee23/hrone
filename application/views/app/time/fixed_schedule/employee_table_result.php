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

        <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
    <script>
    function printProfile(divID) {

      var printContents = document.getElementById(divID).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;

    }
    </script>
      
  </head>


<body>
<!-- Content Header (Page header) -->

      <div class="container-fluid">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>
      <div class="row">
      
<!-- TIME FLEXI SCHEDILE ================================================================================================= -->
    
<!--         <div class="col-md-3">
 -->


<?php //$i=0; 

for ($i = 0; $i <= 100000; $i++) { 
  $i = $i + 1; 
} 

echo "<input type='hidden' id='topic_count' value='".$i."'>";?>

<script type="text/javascript">
function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
  
function checkbox_stat()
{
var count= document.getElementById("topic_count").value;
var checks = document.getElementsByClassName("case1");

if(document.getElementById('check_uncheck').checked==true)
{  
for (i=0;i < count; i++)
{
checks[i].checked =true;
}  
}
else{      
for (i=0;i < count; i++)
{
checks[i].checked =false;
}   
}
}
</script>


<div class="box-body">
      <div class="panel panel-success">
         <div class="box-body">
         <div class="row">
         	 <form method="post" action="<?php echo base_url()?>app/time_fixed_schedule/save_employee_group/<?php echo $this->uri->segment("4");?>" >


             <div class="col-md-12">
<!-- 
<input type="checkbox" name="case1" class="checkbox_stat" id="check_uncheck" onclick="checkbox_stat();"><span class="text-danger">Check | Uncheck All</span> -->
<input type="checkbox" name="case1" class="checkbox_stat" id="check_uncheck" onclick="toggle(this);"><span class="text-danger">Check | Uncheck All</span>

	            <table id="example1" class="table table-bordered table-striped">
	            <thead>
	              <tr>
	                <th>Employee ID</th>
	                <th>Employee Name</th>
	                <th>Classification</th>
	              </tr>
	            </thead>
	            <tbody>
	             <?php foreach($available_employee as $employee){ 

              $company_id=$employee->company_id;
              $location=$employee->location; //location id
              $classification=$employee->classification_id; //classification id

               //echo "$company_id $location $classification <br>";
              require(APPPATH.'views/include/loc_class_restriction.php');

          if($allowed>0){ // check this variable at loc_class_restriction
                ?>
	              <tr>
	                <td><input type="checkbox" name="employeeselected[]" class="case" name="case" value="<?php echo $employee->employee_id?>">
	                <?php echo $employee->employee_id?> </td>
	                <td><?php echo $employee->first_name.' '.$employee->last_name.' '.$employee->middle_name.' '.$employee->name_extension?></td>
	                <td><?php echo $employee->classification ?></td>
	              </tr><?php 

          }else{

          }


                } ?>
	            </tbody>
	            </table>

	            <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-user-plus"></i> ADD</button>

              </div>


         </div> 
         </div><!-- /.box-body --> 
      </div>
      </div>
      </form>


        </div> 
        </div> 
        </body>
        </html>