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

     <link href="<?php echo base_url()?>public/bootstrap/css/developer.css" rel="stylesheet">

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
      Payroll
       <small>Hold Employee</small>
    </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url()?>app/payroll_priority_deduction">Payroll</a></li>
      <li class="active">Hold Employee </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
      <br>


<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="panel-heading"><strong><?php echo $compInf->company_name;?></strong></div>
        <div class="panel-body">

         <form action="<?php echo base_url()?>app/payroll_hold_employee/save_hold_emp" method="post">

<!-- //=========== start store filter criterias -->

<input type="hidden" name="pay_type_group" value="<?php echo $pay_type_group;?>">
<input type="hidden" name="location_clause" value="<?php echo $location_clause;?>">
<input type="hidden" name="classification_clause" value="<?php echo $classification_clause;?>">
<input type="hidden" name="employment_clause" value="<?php echo $employment_clause;?>">
<input type="hidden" name="division_clause" value="<?php echo $division_clause;?>">
<input type="hidden" name="department_clause" value="<?php echo $department_clause;?>">
<input type="hidden" name="section_clause" value="<?php echo $section_clause;?>">
<input type="hidden" name="sub_section_clause" value="<?php echo $sub_section_clause;?>">
<input type="hidden" name="masterlist_table" value="<?php echo $masterlist_table;?>">
<input type="hidden" name="employee_status_clause" value="<?php echo $employee_status_clause;?>">
<input type="hidden" name="pay_period" value="<?php echo $pay_period;?>">
<input type="hidden" name="selected_individual_employee_id" value="<?php echo $selected_individual_employee_id;?>">

<!-- //=========== end store filter criterias -->

<?php
if($selected_individual_employee_id==""){

?>

<table class="table">
<thead>
    <tr>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Reason to Hold Employee Payroll</th>
        <th>Hold Payroll?</th>
    </tr>
</thead>
<tbody>
    <?php 
    $already_hold="";
    foreach($mymasterlist as $e){
echo '
  <tr>
    <td>'.$e->employee_id.'</td>
    <td>'.$e->first_name.' '.$e->last_name.'</td>
    <td>
<select name="reason_'.$e->employee_id.'" class="form-control" required>
';
if(!empty($ReasonList)){
  echo '<option value="no_selected">Select Reason to Hold Payroll</option>';
  foreach($ReasonList as $r){
    echo '<option value="'.$r->id.'">'.$r->reason.'</option>';
  }
}else{
echo '
  <option value="">Notice: You do not have Setup for Reason to Hold Payroll Yet.</option>
  ';
}


  echo '
</select>

     </td>
    <td><input type="checkbox" name="hold_emp_'.$e->employee_id.'"></td>
  </tr>
';

      }
    ?>
</tbody>  
          </table>
<?php
}else{// indvidual employee

echo $name;

$checkIfPayrollisHold=$this->payroll_hold_employee_model->checkIfPayrollisHold($selected_individual_employee_id,$pay_period);
if(!empty($checkIfPayrollisHold)){
  $already_hold="yes";
  $reason_to_hold= $checkIfPayrollisHold->reason_to_hold;
  echo " (<span class='text-danger'>Notice: Payroll is already Hold.</span>)";
}else{
  $already_hold="";
}

  echo '<select name="reason" class="form-control" required>
';
if(!empty($ReasonList)){
  echo '<option value="">Select Reason to Hold Payroll</option>';
  foreach($ReasonList as $r){
    if($already_hold=="yes"){
      if($reason_to_hold==$r->id){
          $sel="selected";
      }else{
          $sel="";
      }
    }else{
      $sel="";
    }
    echo '<option value="'.$r->id.'" '.$sel.'>'.$r->reason.'</option>';
  }
}else{
echo '
  <option value="">Notice: You do not have Setup for Reason to Hold Payroll Yet.</option>
  ';
}


  echo '
</select>';


?>




<?php 
}// end individual employee




if(!empty($ReasonList)){


  if($already_hold=="yes"){
echo ' <button type="button" class="disabled btn btn-default pull-right" title="Notice: Kindly Setup Reason to Hold Employee Payroll First"><i class="fa fa-floppy-o"></i> Save</button>';
  }else{

    echo ' <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>';    

}

}else{
echo ' <button type="button" class="disabled btn btn-default pull-right" title="Notice: Kindly Setup Reason to Hold Employee Payroll First"><i class="fa fa-floppy-o"></i> Save</button>';
}

?>


          </form>

        </div>
    </div>
  </div>
</div>



  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">


</script>
          

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

    <script>
      function loading(){
        $("#loading").removeAttr("hidden");
      }
    </script>

  </body>
</html>