<?php

    /*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */
    $add_emp_tax_type=$this->session->userdata('add_emp_tax_type');
    $del_emp_tax_type=$this->session->userdata('del_emp_tax_type');
    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */  


?>

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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/iCheck/all.css">

    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>
      
  </head>

<body>


<div class="container-fluid">
<?php echo $message;?>
<?php echo validation_errors(); ?>
<br>
<?php //$i=0; 

for ($i = 0; $i <= 100000; $i++) { 
  $i = $i + 1; 
} 

echo "<input type='hidden' id='topic_count' value='".$i."'>";

echo "<input type='hidden' id='topic_count2' value='".$i."'>";

?>

<script type="text/javascript">

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


function checkbox_stat_2()
{
var count= document.getElementById("topic_count2").value;
var checks = document.getElementsByClassName("case2");

if(document.getElementById('check_uncheck_2').checked==true)
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
<?php
if($taxtype_chosen=="1"){// base on tax tab;e
	$enroll_location_text="Check employee Tax Base on Tax Table";
	$enroll_location_style="primary";
	$taxt_type_for_save="tax_table";
}else{// base on annualize
	$enroll_location_text="Check employee Tax Base on Annualize Tax";
	$enroll_location_style="danger";
	$taxt_type_for_save="annualize";
}
?>


	<div class="row">
<div class="col-md-4">
		<div class="panel panel-<?php echo $enroll_location_style;?>">
			<div class="panel-heading"><strong><?php echo $enroll_location_text;?></strong></div>
			<div class="panel-body">

			<?php
			if(!empty($employeeList)){
?>
			<input type="checkbox" name="case1" class="checkbox_stat" id="check_uncheck" onclick="checkbox_stat();">
			<span class="text-danger">Click to Check | Uncheck All</span>

			<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/enrolLtaxTableBase/" >
			
			<input type="hidden" name="company_id" value="<?php echo $company_id;?>">
			<input type="hidden" name="taxt_type_for_save" value="<?php echo $taxt_type_for_save;?>">
<?php
$choices_count=0;
			foreach($employeeList as $e){
$choices_count++;
				echo $choices_count.' )
				<input type="checkbox" class="case1" name="employee_id[]" value="'.$e->employee_id.'" /> '. $e->employee_id.' | '. $e->name.'<br>
				';
			}

if(!empty($add_emp_tax_type)){
echo '<button type="submit" class="btn btn-danger" disabled><i class="fa fa-arrow-right"></i>Not Allowed To Add (Check Your Access at administrator > user roles)</button>';
}else{
echo '<button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Click to Save/Enrolled Selected Employees</button>';
}


?>
			</form>
<?php
			}else{
echo 'No Employees Found.';
			}
			?>


		</div>
		</div>
</div>


<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading"><strong>Currently Enrolled Employees Tax Based on Tax Table</u></strong></div>
			<div class="panel-body">


			<?php
			if(!empty($tax_table_base)){
?>

			<input type="checkbox" name="case2" class="checkbox_stat_2" id="check_uncheck_2" onclick="checkbox_stat_2();">
			<span class="text-danger">Click to Check | Uncheck All</span>
	<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/un_enrol_employee/" >
	<input type="hidden" name="company_id" value="<?php echo $company_id;?>">
<?php

			$choices_count_reg=0;
			foreach($tax_table_base as $a){
			$choices_count_reg++;

echo $choices_count_reg.' )
<input type="checkbox" class="case2" name="un_employee_id[]" value="'.$a->employee_id.'" /> '. $a->employee_id.' | '. $a->last_name.' '.$a->first_name.'<br>';

			}


if(!empty($del_emp_tax_type)){
echo '<button type="submit" class="btn btn-danger" disabled><i class="fa fa-arrow-right"></i>Not Allowed To Remove (Check Your Access at administrator > user roles)</button>';
}else{
echo '<button type="submit" class="btn btn-danger"><i class="fa fa-remove"></i> Click to Remove Selected/Checked Employees</button>';
}


?>
	</form>

<?php
			}else{
echo 'No Enrolled Employees Yet.';
			}

// ======================= generallay enrolled emp.
?>

			</div>
		</div>
</div>

<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading"><strong>Currently Enrolled Employees Tax Based on Annualize</u></strong></div>
			<div class="panel-body">


			<?php
			if(!empty($annualize_base)){
?>

			<input type="checkbox" name="case2" class="checkbox_stat_2" id="check_uncheck_2" onclick="checkbox_stat_2();">
			<span class="text-danger">Click to Check | Uncheck All</span>
	<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/un_enrol_employee/" >
	<input type="hidden" name="company_id" value="<?php echo $company_id;?>">
<?php

			$choices_count_reg=0;
			foreach($annualize_base as $a){
			$choices_count_reg++;

echo $choices_count_reg.' )
<input type="checkbox" class="case2" name="un_employee_id[]" value="'.$a->employee_id.'" /> '. $a->employee_id.' | '. $a->last_name.' '.$a->first_name.'<br>';

			}


if(!empty($del_emp_tax_type)){
echo '<button type="submit" class="btn btn-danger" disabled><i class="fa fa-arrow-right"></i>Not Allowed To Remove (Check Your Access at administrator > user roles)</button>';
}else{
echo '<button type="submit" class="btn btn-danger"><i class="fa fa-remove"></i> Click to Remove Selected/Checked Employees</button>';
}


?>
	</form>

<?php
			}else{
echo 'No Enrolled Employees Yet.';
			}

// ======================= generallay enrolled emp.
?>

			</div>
		</div>
</div>





	</div>
</div>


</div>


</body>
</html>