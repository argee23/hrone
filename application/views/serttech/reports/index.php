<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My HRIS- Serttech<?php //echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header_serttech.php');?>
<!-- SIDEBAR -->
    <?php require_once(APPPATH.'views/include/sidebar_serttech.php');?>

<body>  
  

      <div class="col-md-12" style="padding-top:20px;">
        <div class="col-md-12" >
          <div class="box box">
          <div>
            <ul class="nav nav-tabs">
                <li><a><n class="text-danger"><b><i class="fa fa-dashboard text-danger"></i>REPORTS</b></n></a>
                </li>
                  <!-- <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick=""><b> <i></i>CRYSTAL REPORT</b></a>
                 </li> -->
                 <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="get_report('requirement_status');"><b> <i class="fa fa-check"></i>REQUIREMENT STATUS</b></a>
                </li>
                 <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="get_report('job_management');"><b> <i class="fa fa-check"></i>JOB MANAGEMENT</b></a>
                </li>
                <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="get_report('registered_employees');"> <b><i class="fa fa-adjust"></i>REGISTERED EMPLOYERS</b></a> 
                </li>
        
                <li class="active pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="get_report('settings');"><b> <i></i>SETTINGS</b></a>
                </li>
            </ul>
          </div>
          <div style="height:750px;margin-bottom:100px;overflow-y: scroll;margin-top: 10px;" id="main_res">
                
<div class="col-md-12">
<br>
<div class="col-md-3"></div>
<div class="col-md-6">
      <select class="form-control" onchange="get_settings_filter(this.value,'settings');">
        <option value='SD1'>Package List</option>
        <option value='SD12'>Free Trial Requirement List</option>
        <option value='SD3'>Subscription Requirement List</option>
        <option value='SD6'>Email Settings</option>
        <option value='others'>Others</option>
      </select>
</div>
<div class="col-md-3"></div>
<div class="col-md-12" id="setting_filter">
      <table id="package_tables" class="table table-bordered table-striped">
          <thead>

            <tr class="danger">
              <th>No</th>
              <th>Customer Type</th>
              <th>Validity</th>
              <th>Jobs License</th>
              <th>Orig Price</th>
              <th>Discount %</th>
              <th>Discounted Price</th>
              <th>Vat Included already</th>
              <th>Vat Percentage</th>
              <th>Amount of Vat</th>
              <th>Gross</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $i=1;
          foreach($rec_employer_bill_setting_mng as $bill_offers){

          if ($bill_offers->InActive=="0"){
            $color="";
            $todo="disable_bill";
            $bg="";

          }elseif($bill_offers->InActive=="1"){
            $color="";
            $todo="enable_bill";
          $bg="";
          }else{

          }

          $enable_disable= '<a href="'.base_url().'serttech/mypublic_recruitment/'.$todo.'/'.$bill_offers->id.'"  " ><i class="fa fa-power-off '.$color.' pull-right"></i></a>'.'<br>';
          $edit = '<i class="fa fa-pencil-square-o fa-lg text-primary pull-right"   data-toggle="tooltip" data-placement="left" title="Edit" onclick="editbill('.$bill_offers->id.')"></i>';
          $delete = anchor('serttech/mypublic/delete_bill/'.$bill_offers->id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-right"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ?')"));


          $customer=$bill_offers->customer_type;
          $num_months=$bill_offers->no_of_months;
          $num_jobs=$bill_offers->no_of_jobs;
          $orig_price=$bill_offers->orig_price;
          $disc_percent=$bill_offers->discount_percentage;

          $vat_per=$bill_offers->vat_percentage;
          $is_vat_included_at_last_price=$bill_offers->is_vat_included_at_last_price;

          $less_amount = ($disc_percent / 100) * $orig_price;
          $discounted_amount = $orig_price-$less_amount;
          $vat_amount= ($vat_per / 100) * $discounted_amount;

          if($is_vat_included_at_last_price=="no"){
            $gross=$discounted_amount+$vat_amount;
          }else{
            $gross=$discounted_amount-$vat_amount;
          }

          echo '<tr '.$bg.'>';
          echo '<td>'.$i.'</td>';
          echo '<td>'.$customer.' customers</td>';
          echo '<td>'.$num_months.' months</td>';
          echo '<td>'.$num_jobs.'</td>';
          echo '<td>'.$orig_price.'</td>';
          echo '<td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>';
          echo '<td>'.$discounted_amount.'</td>';
          echo '<td>'.$is_vat_included_at_last_price.'</td>';
          echo '<td>'.$vat_per.'%</td>';
          echo '<td>'.number_format($vat_amount,2).'</td>';
          echo '<td>'.number_format($gross,2).'</td>';

          echo '</tr>';
        $i++; }
          ?>
          </tbody>
    </table>
</div>
</div>
          </div>

          </div>
          </div>
          </div>
          </body>
    <script src="<?php echo base_url()?>public/validation.js"></script>
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
  </body>
</html>
  <?php require_once(APPPATH.'views/serttech/js_functions_reports.php');?>
