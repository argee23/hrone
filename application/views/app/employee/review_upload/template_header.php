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
    <div class="box box-success">
      <div class="panel panel-info"  id="print_here" >
        <div class="panel-heading">
        <div style="margin-bottom: 10px;"><button onclick="closeWin()" class="btn btn-success">Close</button></div>
        <?php if($action=='save'){?>
        <h3 class="text-danger"><center><?php echo $count_data." "?> New record/s is successfully saved in company id - <?php echo $company?></center></h3>
        <?php } else{?>
        <h3 class="text-danger"><center>Review Employee Mass Uploaded File</center></h3>
      <?php } ?>
      <div   style="overflow:scroll;">
           <table class="table table-bordered">
                <thead style="background-color:#DCDCDC;">
                  <tr>
                  <th>Employee ID</th>
                  <th>First Name</h4></th>
                  <th>Middle Name</h4></th>
                  <th>Last Name</h4></th>
                  <th>Birthday</h4></th>
                  <th>Gender</h4></th>
                  <th>Civil Status</h4></th>
                  <th>Company ID</h4></th>

                  <th>Location</h4></th>
                  <th>Division</h4></th>
                  <th>Department</h4></th>
                  <th>Section</h4></th>
                  <th>Subsection</h4></th>

                  <th>Employment</h4></th>
                  <th>Classification</h4></th>
                  <th>Position</h4></th>
                  <th>Taxcode</h4></th>
                  <th>PayType</h4></th>
                  <th>Date Employed</h4></th>
                  <th style="width: 20%;">Remarks</h4></th>

                  </tr>
                </thead>
                <tbody>


        