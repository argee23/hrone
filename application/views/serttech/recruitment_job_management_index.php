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
                <li><a><n class="text-danger"><b><i class="fa fa-dashboard text-danger"></i>Job Management</b></n></a>
                </li>
                  <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="job_management_action('view','rejected','rejected','rejected','all')"> <b>REJECTED</b></a> 
                </li>
                <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="job_management_action('view','cancelled','cancelled','cancelled','all')"> <b>CANCELLED</b></a> 
                </li>
                 <li class="pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="job_management_action('view','approved','approved','approved','all')"><b>APPROVED</b></a>
                </li>
                <li class="active pull-right">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="job_management_action('view','waiting','pending','pending','all')"> <b>PENDING</b></a>
                </li>
              
            </ul>
          </div>
              <div style="height:750px;margin-bottom:100px;overflow-y: scroll;margin-top: 10px;" id="main_res">


          <!--   list of employer's requirements -->

              <div class="col-md-12" style="padding-top: 40px;">
                
                <div class="col-md-12" id="job_management_result">

                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <select class="form-control" onchange="get_company_job_manage(this.value,'waiting');">
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

                <div id="by_company_result">
                  <table class="col-md-12 table table-hover" id="table_requirements">
                     <thead>
                       <tr class="danger">
                              <th style="width:10%;">ID</th>
                              <th style="width:20%;">Company Name</th>
                              <th style="width:25%;">Position</th>
                              <th style="width:10%;">Date Posted</th>
                              <th style="width:20%;">Comment</th>
                              <th style="width:20%;">Action
                                <?php if(empty($jobs)){}
                                else{?>
                                   <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Reject Job Request'><i  class="fa fa-times fa-lg  pull-right text-danger" onclick="job_management_action('status_update','waiting','all','rejected' ,'all')"></i></a>

                                   <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Job Request'><i  class="fa fa-undo fa-lg  pull-right text-warning" onclick="job_management_action('status_update','waiting','all','cancelled','all')"></i></a>

                                    <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Approve Job Request'><i  class="fa fa-check fa-lg  pull-right text-success" onclick="job_management_action('status_update','waiting','all','approved','all')"></i></a>
                                <?php } ?>
                              </th>
                       </tr>
                     </thead>
                     <tbody>
                     <?php $i=1; foreach ($jobs as $j) {
                       $job_specs=$this->recruitments_model->getjob_specs($j->job_specialization);
                      $thejob_specizalization=$job_specs->cValue;
                    ?>
                        <tr>
                            <td><?php echo $j->job_id;?></td>
                            <td><?php echo $j->company_name;?></td>
                            <td><strong><?php echo $j->job_title;?></strong>
                                <button data-toggle="collapse" data-target="#seemore_<?php echo $j->job_id."_".$j->company_id;?>" class="btn-info pull-right">see more</button>
                                    <div id="seemore_<?php echo $j->job_id."_".$j->company_id;?>" class="collapse">
                                    Slot: <button class="btn-default"><?php echo $j->job_vacancy; ?></button><br>
                                    Salary: <button class="btn-danger"><?php echo $j->salary; ?></button><br>
                                    Job Specialization: <button class="btn-default"><?php echo $thejob_specizalization; ?></button><br>
                                    Job Description: <button class="btn-default"><?php echo nl2br($j->job_description); ?></button><br>
                                    Job Qualification: <button class="btn-default"><?php echo nl2br($j->job_qualification); ?></button><br>
                                    <span class="label label-primary">Hiring Start : <?php echo $j->hiring_start; ?></span><br>
                                    <span class="label label-warning">Closed On : <?php echo $j->hiring_end; ?></span>
                                    </div>
                            </td>
                            <td><?php echo $j->date_posted;?></td>
                            <td>
                              <div id="ocomment<?php echo $j->job_id;?>">  <?php if(empty($j->comment)){ echo "No comment";} else { echo $j->comment;} ?> </div>
                              <div id="ucomment<?php echo $j->job_id;?>" style='display: none;'>
                                  <textarea class="form-control" rows="3" style="width: 100%;" id="updatecomment<?php echo $j->job_id;?>"><?php echo $j->comment;?></textarea>
                                  <input type="hidden" id="updatecomment_<?php echo $j->job_id;?>">
                              </div>
                              
                            </td>
                            <td>
                                <div id="original<?php echo $j->job_id;?>">
                                  <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Job Details'><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left" onclick="job_management_action('update','pending','<?php echo $j->job_id;?>','status_action','all')"></i></a>

                                  <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Approve Job Request'><i  class="fa fa-check fa-lg  pull-left text-success" onclick="job_management_action('status_update','waiting','<?php echo $j->job_id;?>','approved','all')"></i></a>

                                   <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Reject Job Request'><i  class="fa fa-times fa-lg  pull-left text-danger" onclick="job_management_action('status_update','waiting','<?php echo $j->job_id;?>','rejected','all')"></i></a>

                                   <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Job Request'><i  class="fa fa-undo fa-lg  pull-left text-warning" onclick="job_management_action('status_update','waiting','<?php echo $j->job_id;?>','cancelled','all')"></i></a>

                                </div>
                                <div id="update<?php echo $j->job_id;?>" style='display: none;'>
                                <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Comment Job Details' onclick="job_management_action('save_comment','waiting','<?php echo $j->job_id;?>','save_comment','all')"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>
                                <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Comment' onclick="job_management_action('cancel','pending','<?php echo $j->job_id;?>','status_action','all')"><i  class="fa fa-times fa-lg  pull-left text-danger"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php $i++; } ?>
                     </tbody>
                  </table>
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
  