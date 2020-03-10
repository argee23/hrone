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
    <script type="text/javascript">
        window.onload = function() { <?php echo $onload ?>; };
    </script>
<body>  
    <div class="col-md-12" id="mmmmm">
      <div class="col-md-12" style="margin-top: 20px;"><?php echo $message;?></div> 
    </div>


      <div class="col-md-12" style="padding-top:20px;">
        <div class="col-md-12" >
          <div class="box box">
          <div>
            <ul class="nav nav-tabs">
                <li><a><n class="text-danger"><b><i class="fa fa-dashboard text-danger"></i>Employer's Pending Requirements</b></n></a>
                </li>
                 <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="recruitment_requirement_stat('active');"><b> <i class="fa fa-check"></i>ACTIVE</b></a>
                </li>
                 <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="recruitment_requirement_stat('manual_activation');"><b> <i class="fa fa-check"></i>FOR ACTIVATION</b></a>
                </li>
                <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="recruitment_requirement_stat('payment');"> <b><i class="fa fa-adjust"></i>PENDING PAYMENT</b></a> 
                </li>
             
                <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="recruitment_requirement_stat('All');"><b> <i></i>PENDING REQUIREMENTS</b></a>
                </li>
            </ul>
          </div>
              <div style="height:750px;margin-bottom:100px;overflow-y: scroll;margin-top: 10px;" id="main_res">


          <!--   list of employer's requirements -->

              <div class="col-md-12" style="padding-top: 40px;">
                <div class="col-md-8" id="requirements_main_body">
                  <div class="col-md-12">
                  <div class="col-md-12">
                        <div class="col-md-3"><label class="pull-right">Filter:</label></div>
                        <div class="col-md-4">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
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
                          <div class="col-md-2">
                          <select class="form-control" onchange="recruitment_requirement_stat_by_company('All',this.value);">
                              <option value="" disabled selected>Select</option>
                              <option>All</option>
                              <option>Subscription</option>
                              <option>Free Trial</option>
                          </select>
                        </div>
                        <div class="col-md-3"></div>
                  </div>
                   <div class="col-md-12">
                      <div class="col-md-12"><br>
                          <div class="box box-default" class='col-md-12'></div>
                      </div>  
                    </div>

                  
                  <div class="col-md-12" id="by_company_requirements">
                      <table class="col-md-12 table table-hover" id="table_requirements">
                         <thead>
                           <tr class="danger">
                                  <th>No</th>
                                  <th>Employer</th>
                                  <th>Type</th>
                                  <th>Registration Date</th>
                                  <th>Payment Status</th>
                                  <th>Activation Type</th>
                                  <th>Status</th>
                                  <th>Action</th>
                           </tr>
                         </thead>
                         <tbody>
                         <?php $i=1; 
                         foreach ($details as $row) {
                            $pending_req= $this->serttech_recruitment_setting_model->total_pending_requirements($row->id);
                          ?>
                         
                            <tr>
                                  <td><span class="badge"><?php echo $pending_req;?></span></td>
                                  <td><a style="cursor: pointer;" aria-hidden='true' data-toggle='tooltip' title='Click to View Employers details' onclick="view_details_employer_requirements('view_employer_details','view_employer','<?php echo $row->employer_id;?>','All');"><?php echo $row->company_name;?></a></td>
                                  <td><?php if($row->type=='free_trial'){ echo "Free Trial"; } else{ echo "Package"; }?></td>
                                  <td><?php echo $row->date_registered;?></td>
                                  <td><?php echo $row->status;?></td>
                                  <td><?php if($row->type=='free_trial'){ echo "Free"; } else { if($row->payment_status=='paid'){ echo 'Paid'; } else{ echo 'Not yet paid'; } };?></td> 
                                  <td><?php echo $row->setting_activation;?></td> 
                                  <td>
                                    
                                  <?php if($row->status!='pending')
                                  {?>
                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to View Requirement Status' onclick="view_details_employer_requirements('view_employer_req','view_req','<?php echo $row->id;?>','All');"><i  class="fa fa-files-o fa-lg  pull-left"></i></a>
                                  <?php } else{?>
                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Requirement Status' onclick="view_details_employer_requirements('view_employer_req','Update_req','<?php echo $row->id;?>','All');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                  <?php }?>

                                  </td>
                            </tr>

                          <?php $i++;  } ?>
                         </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="col-md-4" id="sidebar_req" style="padding-top: 49px;">

                      <div class="col-md-12">
                        <div class="box box-default">
                           <div class="box-header with-border">
                                <h3 class="box-title">Free Trial Requirements</h3>
                            </div>
                            <div class="box-body">
                              <table class="table table-user-information" id="free_trial">
                                <thead>
                                   <tr style="display: none;">
                                      <th></th>
                                      <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($free_trial as $row) {?>
                                  <tr>
                                    <td class="pull-right"><?php echo $i.")";?></td>
                                    <td class="text-info"><strong><?php echo $row->title;?></strong></td>
                                  </tr>
                                <?php $i++; } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                      </div>
                       <div class="col-md-12">
                        <div class="box box-default">
                           <div class="box-header with-border">
                                <h3 class="box-title">Subscription Requirements</h3>
                            </div>
                            <div class="box-body">
                              <table class="table table-user-information" id="subscription">
                                 <thead>
                                   <tr style="display: none;">
                                      <th></th>
                                      <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $i=1; foreach ($package as $row) {?>
                                  <tr>
                                    <td class="pull-right"><?php echo $i.")";?></td>
                                    <td class="text-info"><strong><?php echo $row->title;?></strong></td>
                                  </tr>
                                <?php $i++; } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                      </div>


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
  