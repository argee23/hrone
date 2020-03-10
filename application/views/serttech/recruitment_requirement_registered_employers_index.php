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
                <li><a><n class="text-danger"><b><i class="fa fa-dashboard text-danger"></i>Registered Employees</b></n></a>
                </li>
            </ul>
          </div>
              <div style="height:750px;margin-bottom:100px;overflow-y: scroll;margin-top: 10px;" id="main_res">


          <!--   list of employer's requirements -->

              <div class="col-md-12" style="padding-top: 40px;">
                  <div class="col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                          <select class="form-control" onchange="registered_employers_by_company(this.value);">
                            <?php
                               $companyList=$this->serttech_recruitment_setting_model->employers_job();
                            ?>
                              <option value="" disabled selected>Select Company</option>
                            <?php if(empty($companyList)){ echo "<option value=''>No company found.</option>"; } else{
                              foreach($companyList as $comp){?>
                              <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                            <?php } }?>
                          </select>
                        </div>
                        <div class="col-md-3"></div>
                  </div>

                <div class="col-md-12" id="registered_main_body">
                   <table class="table table-user-information" id="active">
                      <thead>
                          <tr>
                              <th>Company Name</th>
                              <th>Details</th>
                              <th>Account Type</th>
                              <th>Account Status</th>
                              <th>Registration Date</th>
                              <th>End Date</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php $i=0; foreach($details as $row) {?>
                          <tr>
                              <td><?php echo $row->company_name;?></td>
                              <td>
                              <button data-toggle="collapse" data-target='#id<?php echo $i;?>' class="btn btn-sm">view employer details</button>
                                <div class="col-md-12 collapse" id="id<?php echo $i;?>">
                                  <?php $details_req = $this->serttech_recruitment_setting_model->view_details_employer_requirements('view_employer_details','view',$row->employer_id,'none');

                                foreach($details_req as $row1){?>
                              
                                <div class="col-md-12">Industry <br><strong><?php echo $row1->cValue;?></strong></div>
                                <div class="col-md-12">Employees  <br><strong><?php echo $row1->employee_counts;?> Employees</strong></div>
                                <div class="col-md-12">Company TIN  <br><strong><?php echo $row1->company_tin;?></strong></div>
                                <div class="col-md-12">Contact Person  <br><strong><?php echo $row1->contact_person;?></strong></div>
                                <div class="col-md-12">Designation  <br><strong><?php echo $row1->designation;?></strong></div>
                                <div class="col-md-12">Website  <br><strong><?php echo $row1->company_website;?></strong></div>
                                <div class="col-md-12">Telephone No.  <br><strong><?php echo $row1->tel_no;?></strong></div>
                                <div class="col-md-12">Mobile No.  <br><strong><?php echo $row1->mobile_no;?></strong></div>
                             
                             
                          <?php } ?>
                          </div>
                              
                              </td>
                              <td>
                              <?php if($row->active_usage_type=='free_trial')
                              {?>
                                <button data-toggle="collapse" data-target='#type<?php echo $i;?>' class="btn btn-sm">free trial</button>
                              <?php } else{?>
                                <button data-toggle="collapse" data-target='#type<?php echo $i;?>' class="btn btn-sm">view subscription</button>
                              <?php } ?>
                               <div class="col-md-12 collapse" id="type<?php echo $i;?>">
                                    <?php if($row->active_usage_type=='free_trial')
                                    {?>
                                      <div class="col-md-12"><strong>Free Trial for  <?php echo $row->free_trial_months_can_post?>  Month (s)<br></strong></div>
                                      <div class="col-md-12"><strong>Can Post Job Up to  <?php echo $row->free_trial_jobs_can_post ?> Job (s)</strong></div>
                                    <?php 
                                    }else{ 
                                      $usage_id = $row->package_id;
                                      $myactive_bill=$this->serttech_login_model->rec_bill($usage_id);  
                                      $myactive_bill=$this->serttech_login_model->rec_bill($usage_id);  

                                      $customer=$myactive_bill->customer_type;
                                      $num_months=$myactive_bill->no_of_months;
                                      $num_jobs=$myactive_bill->no_of_jobs;
                                      $orig_price=$myactive_bill->orig_price;
                                      $disc_percent=$myactive_bill->discount_percentage;

                                      $vat_per=$myactive_bill->vat_percentage;
                                      $is_vat_included_at_last_price=$myactive_bill->is_vat_included_at_last_price;

                                      $less_amount = ($disc_percent / 100) * $orig_price;
                                      $discounted_amount = $orig_price-$less_amount;
                                      $vat_amount= ($vat_per / 100) * $discounted_amount;

                                      if($is_vat_included_at_last_price=="no"){
                                        $my_gross=$discounted_amount+$vat_amount;
                                      }else{
                                        $my_gross=$discounted_amount;//-$vat_amount
                                      }
                                      $date = date('Y-m-d',strtotime($row->date_registered));
                                      $date_end = date('Y-m-d', strtotime('+'.$row->free_trial_months_can_post.' month', strtotime($date)));
                                      ?>
                                        <?php echo '
                                            <b>Subscription Date:</b> '.date('F d Y', strtotime($row->date_registered))." to ".date('F d Y', strtotime($date_end)).'<br>
                                            <b>Validity:</b> '.$num_months.'months<br>
                                            <b>Job License:</b> '.$num_jobs.'<br>
                                            <b>Orig Price: </b>'.$orig_price.'<br>
                                            <b>Discount %:</b> '.$less_amount.'<br>
                                            <b>Discounted Price:</b> '.$discounted_amount.'<br>
                                            <b>Vat Included already:</b> '.$is_vat_included_at_last_price.'<br>
                                            <b>Vat Percentage:</b> '.$vat_per.'<br>
                                            <b>Amount of Vat:</b> '.$vat_amount.'<br>
                                            <b>Gross: </b>'.$my_gross.''?>
                                      
                                    
                                   <?php }?>
                                  
                                  
                                </div>
                              </td>
                              <td><?php if($row->is_usage_active=='1'){ echo "Active"; } else{ echo "Not Active"; } ?></td>
                              <td><?php echo $row->date_registered;?></td>
                              <td>
                              <?php 
                                  $date = date('Y-m-d',strtotime($row->date_registered));
                                  $date_end = date('Y-m-d', strtotime('+'.$row->free_trial_months_can_post.' month', strtotime($date)));
                              ?>
                              <?php echo $date_end;?>
                              </td>
                          </tr>
                      <?php $i++; } ?> 
                      </tbody>
                  </table>

                </div>


              </div>


            <!--   list of employer's requirements -->


              </div>
          </div>
        </div>
      </div>

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
  <?php require_once(APPPATH.'views/serttech/js_functions.php');?>
