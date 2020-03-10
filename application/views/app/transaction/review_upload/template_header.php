<?php error_reporting(0); ?>
<meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
<style>
  th,td{
    text-align: center;
  }
</style>
   <div class="col-md-12">
    <div class="box box-success" >
      <div class="panel panel-info">
        <div class="panel-heading">
        <div style="margin-bottom: 10px;"><button onclick="closeWin()" class="btn btn-success">Close</button></div>

<?php
$chosen_template=$this->input->post('template');
if($chosen_template=="employee_atro_form_template"){
?>
            <table class="table table-bordered">
                <thead style="background-color:#DCDCDC;">
                  <tr>
                  <th>Employee ID</th>
                  <th>Overtime Date</h4></th>
                  <th>Overtime Hrs/Minutes</h4></th>
                  <th>Remarks</h4></th>
                  </tr>
                </thead>
                <tbody>

<?php
}else{
?>


        <?php if($action=='review'){?>           
        <h3 class="text-danger"><center>Review Leave Type Uploaded File</center></h3>
        <?php } elseif($action=='update') {?>
         <h3 class="text-danger"><center><?php echo $count_data." "?>  record/s is successfully updated in Employee Leave List</center></h3>
        <?php } else {?>
        <h3 class="text-danger"><center><?php echo $count_data." "?> New record/s is successfully saved in Employee Leave List</center></h3>
        <?php } ?>
            <table class="table table-bordered">
                <thead style="background-color:#DCDCDC;">
                  <tr>
                  <th>Employee ID</th>
                  <th>Date From</h4></th>
                  <th>Date To</h4></th>
                   <th>Leave Type</h4></th>
                  <th>Address while on leave</h4></th>
                  <th>Half day (Yes/No)</h4></th>
                  <th>Reason</h4></th>
                  <?php if($action=='review'){ echo "<th>Remarks</h4></th>"; } ?>
                  </tr>
                </thead>
                <tbody>
<?php
}
?>

        