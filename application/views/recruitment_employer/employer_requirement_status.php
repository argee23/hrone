<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $companyInfo->company_name;?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />

      <link href="<?php echo base_url()?>public/bootstrap/css/developer.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">   
   

   
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php 

      if($this->session->userdata('is_logged_in')){
      $current_account_logged_in="admin or employee account";
      }else{
      $current_account_logged_in="employer_account";
      }    
      if($current_account_logged_in!="employer_account"){
         require_once(APPPATH.'views/include/sidebar.php');
        }else{
       require_once(APPPATH.'views/include/sidebar_recruitment_employer.php');
        }

    ?>

<body>

<?php
$employer_id = $this->session->userdata('employer_id');
$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
$account ='public';
$check_if_active_free_trial_request =  $this->recruitment_employer_management_model->check_if_active_free_trial_request($this->session->userdata('employer_id'),$company_id,'free_trial');
$check_if_active_subscription_request =  $this->recruitment_employer_management_model->check_if_active_free_trial_request($this->session->userdata('employer_id'),$company_id,'subscription');
$check_if_active_license =  $this->recruitment_employer_management_model->check_if_active_license($this->session->userdata('employer_id'),$company_id);
$for_free_license_checker =  $this->recruitment_employer_management_model->for_free_license_checker($this->session->userdata('employer_id'),$company_id,'free_trial');
$employer_id = $this->session->userdata('employer_id');


?>

<div class="content-wrapper2">
    <div class="col-md-12">
    <br>
      <?php echo $message;?>
      <?php echo validation_errors(); ?>
    </div>
   <div class="col-sm-12" style="padding-top: 10px;">
      <div class="box box-box" style="height: auto;margin-bottom: 70px;">

      <!-- free trial -->
       
        <div class="col-md-3">


          <div class="col-md-12" style="padding-top: 4px;width: 100%;">
          <div class="datagrid">
                    <table>
                      <thead>
                        <tr>
                          <th colspan="2">Notifications<i class="fa fa-payment pull-right"></i> </th>
                        </tr>
                      </thead>
                    <tbody> 
                      <tr>
                        <td>New Uploaded File</td>
                      </tr>
                      <tr>
                        <td>New Applicants</td>
                      </tr>
                      <tr>
                        <td>Job left</td>
                      </tr>
                    </tbody>
                    </table>
                  </div>
          </div>

          <div class="col-md-12" style="padding-top: 4px;width: 100%;">
              <div class="datagrid">
                    <table>
                      <thead>
                        <tr>
                          <th colspan="2">Active License<i class="fa fa-payment pull-right"></i> </th>
                        </tr>
                      </thead>
                    <tbody> 
                           <?php if($check_if_active_license > 0){
                              $get_active_license_details =  $this->recruitment_employer_management_model->get_active_license_details($this->session->userdata('employer_id'),$company_id);
                              if($get_active_license_details->active_usage_type=='free_trial')
                                          {
                                            $date = date('Y-m-d',strtotime($get_active_license_details->date_registered));
                                            $date_end = date('Y-m-d', strtotime('+'.$get_active_license_details->free_trial_months_can_post.' month', strtotime($date)));
                                          ?>   
                               <tr class="alt">
                              <td colspan="2">  <n class="text-danger">Free Trial services :</n></td>
                              </tr>
                               <tr>
                                <td colspan="2"><i class="fa fa-check text-success">Free for <?php echo $get_active_license_details->free_trial_months_can_post;?> month(s)</i></td>
                              </tr>
                               <tr class="alt">
                                <td colspan="2"> <i class="fa fa-check text-success">Can Post up to <?php echo $get_active_license_details->free_trial_jobs_can_post;?> Job(s)</i></td>
                              </tr>
                               <tr>
                                <td colspan="2"> <i class="fa fa-check text-success">Valid until ( <?php echo $date_end;?> )</i></td>
                              </tr>
                              <tr class="alt">
                                <td colspan="2">  <center><a class="pull-right" style="cursor: pointer;" onclick="get_active_license('free_trial','<?php echo $company_id;?>','<?php echo $get_active_license_details->id;?>');"><strong><small>View More Details</small></strong></a></center></td>
                              </tr>

                             <?php  } else{
                               $get_package_details = $this->recruitment_employer_management_model->get_active_package_details($this->session->userdata('employer_id'),$company_id,$get_active_license_details->package_id);
                                            $date = date('Y-m-d',strtotime($get_active_license_details->date_registered));
                                            $date_end = date('Y-m-d', strtotime('+'.$get_active_license_details->free_trial_months_can_post.' month', strtotime($date)));

                              ?>
                            <tr class="alt">
                              <td colspan="2">  <n class="text-danger">Package services :</n></td>
                            </tr>
                             <tr>
                              <td colspan="2"><i class="fa fa-check text-success">Free for <?php echo $get_package_details->no_of_months;?> month(s)</i></td>
                            </tr>
                             <tr class="alt">
                              <td colspan="2"> <i class="fa fa-check text-success">Can Post up to <?php echo $get_package_details->no_of_jobs;?> Job(s)</i></td>
                            </tr>
                             <tr>
                              <td colspan="2"> <i class="fa fa-check text-success">Valid until ( <?php echo $date_end;?> )</i></td>
                            </tr>
                            <tr class="alt">
                              <td colspan="2"> <center><a class="pull-right" style="cursor: pointer;" onclick="get_active_license('subscription','<?php echo $company_id;?>','<?php echo $get_active_license_details->id;?>');"><strong><small>View More Details</small></strong></a></center><br></td>
                            </tr>

                           <?php } }
                           else{?>
                            <tr class="alt">
                                <td colspan="2">
                                  <n class='text-danger'>No License found.</n>
                                </td>
                            </tr>
                           <?php }?>

                        <tr>
                          <td colspan="2"><center><a class="pull-right text-success" style="cursor: pointer;" onclick="get_employer_history('active_license','<?php echo $company_id;?>');">History</a></center></td>
                        </tr>
                    </tbody>
                    </table>
              </div>
          </div>

           <div class="col-lg-12" >
              <div class="datagrid">
                    <table>
                      <thead>
                        <tr>
                          <th colspan="2">Pending Request<i class="fa fa-payment pull-right"></i> </th>
                        </tr>
                      </thead>
                    <tbody> 
                            <?php 
                                $get_free_trial_details = $this->recruitment_employer_management_model->get_free_trial_details();
                            ?>

                        <tr class="alt">
                          <td colspan="2"> 
                               <?php if(!empty($check_if_active_free_trial_request) AND $check_if_active_free_trial_request->status=='pending')
                                { ?> 
                                    <n class="text-danger"> Free Trial Request is ongoing. . </n><br><br>
                                    <center><a href="<?php echo base_url()?>recruitment_employer/recruitment_employer_management/get_package_pending_requirements/<?php echo $company_id."/".$employer_id."/".$check_if_active_free_trial_request->id."/".'free_trial';?>" class="pull-right" style="cursor: pointer;" ><strong><small>View Requirements Status</small></strong></a></center>
                              
                                <?php }
                                else if(!empty($check_if_active_subscription_request) AND $check_if_active_subscription_request->status=='pending')
                                {?>
                                    <n class="text-danger">Package Request is ongoing. . </n><br><br>
                                      <center><a class="pull-right" style="cursor: pointer;" href="<?php echo base_url();?>recruitment_employer/recruitment_employer_management/get_package_pending_requirements/<?php echo $company_id."/".$employer_id."/".$check_if_active_subscription_request->id."/"."package";?>"><strong><small>View Requirements Status</small></strong></a></center>
                              
                                
                               <?php  }
                                else{ echo "<n class='text-danger'>No Pending Request</n>"; }?>
                          </td>
                        </tr>
                        
                          <td colspan="2"><center> <a class="pull-right text-success" style="cursor: pointer;" onclick="get_employer_history('active_license','<?php echo $company_id;?>');">History</a></center></td>
                        </tr>
                    </tbody>
                    </table>
              </div>     
          </div>

           <div class="col-lg-12">
                 <div class="datagrid">
                    <table>
                      <thead>
                        <tr>
                          <th colspan="2">Free Trial Details<i class="fa fa-payment pull-right"></i> </th>
                        </tr>
                      </thead>
                    <tbody> 
                            <?php 
                                $get_free_trial_details = $this->recruitment_employer_management_model->get_free_trial_details();
                            ?>

                        <tr class="alt">
                          <td colspan="2"> <i class="fa fa-check text-success">Free for <?php echo $get_free_trial_details->free_trial_months_can_post;?> month(s)</i></td>
                        </tr>
                        <tr>
                          <td colspan="2"> <i class="fa fa-check text-success">Can Post up to <?php echo $get_free_trial_details->free_trial_jobs_can_post;?> Job(s)</i></td>
                        </tr>
                        <tr class="alt">
                          <td colspan="2"> <i class="fa fa-check text-success">With Email Notification</i></td>
                        </tr>
                         <tr>
                          <td colspan="2"> <i class="fa fa-check text-success">Generate Reports</i></td>
                        </tr>
                        <tr>
                          <td colspan="2"><center><a class="pull-right" style="cursor: pointer;" data-toggle="modal" data-target="#centralModalWarning"><strong><small>View More Details</small></strong></a></center></td>
                        </tr>
                    </tbody>
                    </table>
              </div>
          </div>
          
            <div class="col-lg-12">
                <div class="datagrid">
                    <table>
                      <thead>
                        <tr>
                          <th colspan="2">Subscription Details<i class="fa fa-payment pull-right"></i> </th>
                        </tr>
                      </thead>
                    <tbody>
                        <tr class="alt">
                          <td colspan="2"> <i class="fa fa-check text-success">With Job License Validity</i></td>
                        </tr>
                        <tr>
                          <td colspan="2"> <i class="fa fa-check text-success">With Month License Validity</i></td>
                        </tr>
                        <tr class="alt">
                          <td colspan="2"> <i class="fa fa-check text-success">With Email Notification</i></td>
                        </tr>
                         <tr>
                          <td colspan="2"> <i class="fa fa-check text-success">Generate Reports</i></td>
                        </tr>

                        <tr>
                          <td colspan="2"><center><a class="pull-right" style="cursor: pointer;" onclick="get_package_details('<?php echo $company_id;?>','<?php echo $employer_id;?>');"><strong><small>View More Details</small></strong></a></center></td>
                        </tr>
                    </tbody>
                    </table>
              </div>
          </div>

        </div>
      <!-- end free trial -->
      <div class="col-md-9" style="margin-top: 40px;" id="main_body_result">

         <div class="col-md-12" style="padding-top: 10px;">
 <h4 class="text-danger"><center> Requirement/s Request Status </center></h4>
   <table id="req_status" class="table table-bordered table-striped">
      <thead>
          <tr class="danger">
              <th>No.</th>
              <th>Requirement</th>
              <th>Status</th>
              <th>IS Uploadable</th>
              <th>Uploaded File</th>
              <th>Serttech Comment</th>
              <th>Action</th>
          </tr>
      </thead>
      <?php $i=1;
    
        foreach($details as $row){?>
          <tr>
              <td><?php echo $i;?></td>
              <td><?php echo $row->title;?></td>
              <td><?php echo $row->req_status; ?></td>
              <td><?php if($row->IsUploadable==1){ echo "Yes"; } else{ echo "No"; } ?></td>
              <td>
              
                        <?php if($row->file==''){ echo "no uploaded file"; }
                        else {?>
                       
                        <a href="<?php echo base_url(); ?>recruitment_employer/recruitment_employer_management/download_requirement/<?php echo $row->file; ?>"
                          type="button" class="btn btn-info btn-xs" title="Download File" ><i class="fa fa-download"></i><?php echo $row->file;?></a>

                  <?php  }?>
               
              </td>
              <td><?php echo $row->comment; ?></td>
              <td>
                
                <div id="o_action<?php echo $row->id;?>">
                  <?php if($row->IsUploadable==1){?>
                       <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  data-toggle='modal' data-target='#modal' href="<?php echo base_url(); ?>recruitment_employer/recruitment_employer_management/employer_upload_requirements/<?php echo $company_id."/".$employer_id."/".$row->req_id."/".$row->idd."/".$type."/".$row->requirement_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to Edit Requirement' class='btn btn-xs btn-default'><i  class="fa fa-upload fa-lg  pull-left"></i></a>
                  <?php }
                  else{ echo "--"; } ?>
                </div>
              </td>
          </tr>
        <?php $i++;  } ?>
      <tbody>                    
      </tbody>
  </table>
</div>


      </div>

        <div class="btn-group-vertical btn-block"></div>  
      </div>             
    </div>
</div>


<!-- Central Modal Medium Warning -->
<div class="modal fade" id="centralModalWarning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-notify modal-default" role="document">
    <!--Content-->
    <div class="modal-content">
        <!--Header-->
       
        <!--Body-->
        <div class="modal-body" style="height: 200px;">
                  

                  <div class="datagrid">
                    <table>
                      <thead>
                        <tr>
                          <th colspan="2">Free Trial Details<i class="fa fa-payment pull-right"></i> </th>
                        </tr>
                      </thead>
                    <tbody> 
                        
                        <tr class="alt">
                            <td colspan="2"><center> <i class="fa fa-check text-success"></i>With Month Validity License of <?php echo $get_free_trial_details->free_trial_months_can_post;?> month(s)</center></td>
                        </tr>

                        <tr>
                            <td colspan="2"><center><i class="fa fa-check text-success"></i>With Job Validity License of <?php echo $get_free_trial_details->free_trial_jobs_can_post;?> Job(s)</center></td>
                        </tr>
                        <tr class="alt">
                            <td colspan="2"><center><i class="fa fa-check text-success"></i>Can Generate Report(s)</center></td>
                        </tr>
                        <tr>
                            <td colspan="2"><center><i class="fa fa-check text-success"></i>View Applicant Profile</center></td>
                        </tr>
                        <tr class="alt">
                            <td colspan="2"><center><i class="fa fa-check text-success"></i>Manage Employer Settings</center></td>
                        </tr>
                        <tr>
                            <td colspan="2"><center><i class="fa fa-check text-success"></i>Email Notification</center></td>
                        </tr>

                        <tr>
                          <td colspan="2"> 
                              <?php  if(!empty($for_free_license_checker) AND $for_free_license_checker->status=='pending'){ echo '<center><n class="text-danger">Waiting for sert tech approval</n></center>'; } 
                              else if(!empty($for_free_license_checker) AND $for_free_license_checker->status=='approved'){ echo '<center><n class="text-danger">You already used your free trial. Please subscribe to other services </n></center>';  }
                               else{ echo '<center><n class="text-success">USe your free trial now!</n></center>';}?>
                           </td>
                        </tr>

                    </tbody>
                    </table>
                  </div>

        </div>

        <!--Footer-->
        <div class="modal-footer justify-content-center">
        <?php  if(!empty($for_free_license_checker) AND $for_free_license_checker->status=='pending'){ echo '<a style="cursor: pointer;" data-dismiss="modal">Close</a>'; } 
        else if(!empty($for_free_license_checker) AND $for_free_license_checker->status=='approved'){ echo  '<a style="cursor: pointer;" data-dismiss="modal">Close</a>';  }
         else{ ?>
            <a type="button" class="btn btn-warning" onclick="get_free_trial('<?php echo $company_id;?>');">Get it now <i class="fa fa-diamond ml-1"></i></a>
             <a type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">No, thanks</a>
            <?php }?>
      
        </div>
        </div>
    <!--/.Content-->
</div>
</div>
<!-- Central Modal Medium Warning-->
 <div id="modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>

 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->

  <!-- Placed at the end of the document so the pages load faster --> 

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
<?php require_once(APPPATH.'views/recruitment_employer/js_functions.php');?>
<script type="text/javascript">
     
   $(function () {
        $('#req_status').DataTable({
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],  
          "pageLength": 10,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
</script>