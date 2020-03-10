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
      <div class="panel panel-info"  id="print_here">
        <div class="panel-heading">
        <div style="margin-bottom: 10px;"><button onclick="closeWin()" class="btn btn-success">Close</button></div>
        <?php if($action=='save'){?>
        <h3 class="text-danger"><center><?php echo $count_data." "?> New record/s is successfully saved in company id - <?php echo $company?></center></h3>
        <?php } else{?>
        <h3 class="text-danger"><center>Review Employee Loan Enrolment Uploaded File</center></h3>
      <?php } ?>
      <div>
           <table class="table table-bordered">
                <thead style="background-color:#DCDCDC;">
                  <tr>
                  <th>Employee ID</th>
                  <th>Loan Amt</h4></th>
                  <th>Amortization</h4></th>
                  <th>Principal Amt</h4></th>
                  <th>Date Effective</h4></th>
                  <th>Date Granted</h4></th>
                  <th>Reference Number</h4></th>
                  <th>Option</h4></th>
                   <?php if($action=='review'){ echo "<th>Remarks</h4></th>"; } ?>
                  </tr>
                </thead>
                <tbody>


        