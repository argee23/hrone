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
        <?php if($action=='review'){?>
        <h3 class="text-danger"><center>Review Employee Compensation Uploaded File</center></h3>
        <?php } elseif($action=='insert'){?>
        <h3 class="text-danger"><center><?php echo $count_data." "?> New record/s is successfully saved in company id - <?php echo $company?></center></h3>
        <?php } elseif($action=='update'){?>
          <h3 class="text-danger"><center><?php echo $count_data." "?> existing record/s is successfully updated/added in company id - <?php echo $company?></center></h3>
        <?php } ?>
           <table class="table table-bordered">
                <thead style="background-color:#DCDCDC;">
                  <tr>
                  <th>Employee ID</th>
                  <th>Salary Date Effective</h4></th>
                  <th>Salary Rate</h4></th>
                  <th>Salary Amount</h4></th>
                  <th>No. of Hours</h4></th>
                  <th>No. of days a Month</h4></th>
                  <th>No. of days a Year</h4></th>
                  <th>Reason</h4></th>
                  <th>Is Salary fixed?</h4></th>
                  <th>Will deduct withholding tax?</h4></th>
                  <th>Will deduct PAGIBIG?</h4></th>
                  <th>Will deduct SSS?</h4></th>
                  <th>Will deduct PHILHEALTH?</h4></th>
                   <?php if($action=='review'){ echo "<th>Remarks</h4></th>"; } ?>
                  </tr>
                </thead>
                <tbody>


        