<!DOCTYPE html>
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
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/css/dashboard_recruitment_employer.css" rel="stylesheet">
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');
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

        $employer_id = $this->session->userdata('employer_id');
        $company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
        $account ='public';
        $check_if_active_free_trial_request =  $this->recruitment_employer_management_model->check_if_active_free_trial_request($this->session->userdata('employer_id'),$company_id,'free_trial');
        $check_if_active_subscription_request =  $this->recruitment_employer_management_model->check_if_active_free_trial_request($this->session->userdata('employer_id'),$company_id,'subscription');
        $check_if_active_license =  $this->recruitment_employer_management_model->check_if_active_license($this->session->userdata('employer_id'),$company_id);
        $for_free_license_checker =  $this->recruitment_employer_management_model->for_free_license_checker($this->session->userdata('employer_id'),$company_id,'free_trial');
        $employer_id = $this->session->userdata('employer_id');
    ?>
  <body>
  <div class="row">
  <div class="col-md-12">
    <div class="col-md-4" style="padding-top: 20px;">

        
            <div class="nav-tabs-custom">
                <div class="tab-content">
                  <div class="active tab-pane" id="admin_reminders"> 

                   <?php  if($check_if_active_license > 0){?>   <h4> Remaining Job License of 100</h4>
                      <h4>Valid till December 18, 2018 </h4>
                   <?php } else { ?>

                   <h4 class="text-danger"><span class="blink"><center> NO ACTIVE LICENSE </center><br><n>Avail now to enjoy the recruitment system features!</n></span></h4>

                   <?php } ?>
                  </div>
                </div>
            </div>
     
         
      
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active" style="width:100%;"> <h4 style="padding-left: 10px;"><i class="fa fa-bullhorn text-danger"></i>Active License Detail</h4></li>
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="active_license">
                     <div class="datagrid">
                    <table>
                      <thead>
                        
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
                             <?php  } else {
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
                                 <td colspan="2"><center><button style="cursor: pointer;" class="btn btn-default btn-modal" data-toggle="modal" data-target="#fsModal"><strong><small>View More Details</small></strong></button></center></td>
                              </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>
                </div>
            </div>
      
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"  style="width:100%;"><h4 style="padding-left: 10px;"><i class="fa fa-bullhorn text-danger"></i>Pending Request</h4></li>
           
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="pending_request">

                 <div class="datagrid">
                          <table>
                            <thead>
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
                                     <td colspan="2"><center><button style="cursor: pointer;" class="btn btn-default btn-modal" data-toggle="modal" data-target="#fsModal"><strong><small>View More Details</small></strong></button></center></td>
                                </tr>
                            </tbody>
                          </table>
                    </div>     


            </div>
          </div>
        </div>
      

       
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"  style="width:100%;"><h4 style="padding-left: 10px;"><i class="fa fa-bullhorn text-danger"></i>Free Trial Detail</h4></li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="admin_reminders"> 
                 <div class="datagrid">
                          <table>
                            <thead>
                             
                            </thead>
                          <tbody> 
                                  <?php 
                                      $get_free_trial_details = $this->recruitment_employer_management_model->get_free_trial_details();
                                  ?>

                              <tr class="alt">
                                <td> <i class="fa fa-check text-success">Free for <?php echo $get_free_trial_details->free_trial_months_can_post;?> month(s)</i></td>
                                <td> <i class="fa fa-check text-success">Can Post up to <?php echo $get_free_trial_details->free_trial_jobs_can_post;?> Job(s)</i></td>
                              </tr>
                              <tr class="alt">
                                <td> <i class="fa fa-check text-success">With Email Notification</i></td>
                                <td> <i class="fa fa-check text-success">Generate Reports</i></td>
                              </tr>
                              
                              <tr>
                                <td colspan="2"><center><button style="cursor: pointer;" class="btn btn-default btn-modal" data-toggle="modal" data-target="#fsModal"><strong><small>View More Details</small></strong></button></center></td>
                              </tr>
                          </tbody>
                          </table>
                    </div>

            </div>
          </div>
        </div>
     

      
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"  style="width:100%;"><h4 style="padding-left: 10px;"><i class="fa fa-bullhorn text-danger"></i>Subscription Detail</h4></li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="subscription_details">
                <div class="datagrid">
                    <table>
                      <thead>
                       
                      </thead>
                      <tbody>
                          <tr class="alt">
                            <td> <i class="fa fa-check text-success">With Job License Validity</i></td>
                            <td> <i class="fa fa-check text-success">With Month License Validity</i></td>
                          </tr>
                          <tr>
                          </tr>
                          <tr class="alt">
                            <td> <i class="fa fa-check text-success">With Email Notification</i></td>
                            <td > <i class="fa fa-check text-success">Generate Reports</i></td>
                          </tr>
                           <tr>
                          </tr>
                          <tr>
                            <td colspan="2"><center><button style="cursor: pointer;" class="btn btn-default btn-modal" data-toggle="modal" data-target="#fsModal"><strong><small>View More Details</small></strong></button></center></td>
                          </tr>
                      </tbody>
                    </table>
              </div>
            </div>
          </div>
        </div>
      

    </div>


     <div class="col-md-8" style="padding-top: 20px;">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#license_requirements" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>License Requirements</a></li>
              <li><a href="#applicant_all" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>Applicants</a></li>
              <li><a href="#unread_applicants" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>Unread Applicants</a></li>
              <li><a href="#applicant_interview_request" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>Applicant Reschedule Interview Request</a></li>
              <li><a href="#todays_update" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>Todays Updates</a></li>
            </ul>
            <div class="tab-content">

                 <!--   //for license requirements -->
              <div class="active tab-pane" id="license_requirements">
              <br>
                <h5>Note: Kindly complete all the required requirements for the activation of your license. Thanks you!</h5>
              <br>

                <div class="datagrid">
                    <table>
                      <thead>
                        <tr>
                          <th colspan="6">Required Requirements for Free Trial License</th>
                        </tr>
                      </thead>
                      <tbody>
                         <tr class="alt">
                              <td>No</td>
                              <td>Requirement Title</td>
                              <td>Requirement Description</td>
                              <td>IsUploadable</td>
                          </tr>
                          <?php $i=1; foreach($serttech_free_trial_requirements as $free){ ?>
                           <tr>
                              <td><?php echo $i;?></td>
                              <td><?php echo $free->title;?></td>
                              <td><?php echo $free->description;?></td>
                              <td><?php if($free->uploadable==1){ echo "yes"; } else{ echo "no"; }?></td>
                         <?php $i++; }?>
                          </tr>
                          <tr class="alt">
                              <td colspan="6"></td>
                          </tr>
                      </tbody>
                    </table>
                </div>
                <br>
                 <div class="datagrid">
                    <table>
                      <thead>
                        <tr>
                          <th colspan="6">Required Requirements for Subscription</th>
                        </tr>
                      </thead>
                      <tbody>
                            <tr class="alt">
                              <td>No</td>
                              <td>Requirement Title</td>
                              <td>Requirement Description</td>
                              <td>IsUploadable</td>
                          </tr>
                          <?php $i=1; foreach($serttech_package_requirements as $pack){ ?>
                           <tr>
                              <td><?php echo $i;?></td>
                              <td><?php echo $pack->title;?></td>
                              <td><?php echo $pack->description;?></td>
                              <td><?php if($pack->uploadable==1){ echo "yes"; } else{ echo "no"; }?></td>
                         <?php $i++; }?>
                         <tr class="alt">
                              <td colspan="6"></td>
                          </tr>
                      </tbody>
                    </table>
                </div>
            </div>
                 <!--   //for license requirements -->

               <!--   //for list of all applicant --> 
                  <div class="tab-pane" id="applicant_all" style="height:688px;overflow-y: scroll;">

                    <?php foreach($recruitment_status_options as $so){?>
                    
                      <h4 class="text-danger"><center><i class="fa fa-user"></i>List of  Applicants</center></h4>
                        <div class="col-md-12">
                          <table class="table table-hover">
                            <thead>
                              <tr class="danger">
                                <th>Position</th>
                                <th>Applicant</th>
                                <th>Date Applied</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>  
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                      <?php } ?>

                      </div>


                 
                <!--  //for list of all applicant -->


                  <!--   //for list of all applicant --> 
                  <div class="tab-pane" id="unread_applicants">

                      <h4>Unread Applicants</h4>

                  </div>
                <!--  //for list of all applicant -->


                  <!--   //for list of all applicant --> 
                  <div class="tab-pane" id="applicant_interview_request">

                      <h4>Applicant Reschedule Interview Request</h4>

                  </div>
                <!--  //for list of all applicant -->


                <!--   //for list of all applicant --> 
                  <div class="tab-pane" id="todays_update">

                      <h4>Todays Updates</h4>

                  </div>
                <!--  //for list of all applicant -->



        </div>


     </div>
        
    </div>


</div> 
</div>    


   

















<!-- all modals here -->

<div id="fsModal" class="modal animated bounceIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel"
            class="modal-title">
         <n class="text-danger"> Subscription Complete Details</n>
        </h4>
      </div>
      <div class="modal-body">
       <div class="col-md-12" style="padding-top: 10px;overflow: scroll;" id="d">
           <table id="sem_tra" class="table table-bordered table-striped" style="height: 10%;overflow: scroll;">
                <thead>
                  <tr class="danger">
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
                    <th>Avail?</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                foreach($rec_employer_bill_setting as $bill_offers){

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
                if ($bill_offers->InActive=="0" || $bill_offers->InActive=="" ){
                  $color="text-danger";
                  $todo="disable_bill";
                  $bg="";

                }elseif($bill_offers->InActive=="1"){
                  $color="text-success";
                  $todo="enable_bill";
                $bg="class='text-danger'";
                }else{
                  $bg="";
                }

                echo 
                '<tr '.$bg.'>
                  <td>'.$customer.' customers</td>
                  <td>'.$num_months.' months</td>
                  <td>'.$num_jobs.'</td>
                  <td>'.$orig_price.'</td>
                  <td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>
                  <td>'.$discounted_amount.'</td>
                  <td>'.$is_vat_included_at_last_price.'</td>
                  <td>'.$vat_per.'%</td>
                  <td>'.number_format($vat_amount,2).'</td>
                  <td>'.number_format($gross,2).'</td>
                  <td>';
                  $check_if_active_license =  $this->recruitment_employer_management_model->check_if_active_license($this->session->userdata('employer_id'),$company_id);
                  if($check_if_active_license > 0){ echo "You're currently subscribe to other promo"; }else{ 
                  ?>

                     <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to avail package'
                      onclick="avail_package('<?php echo $company_id;?>','<?php echo $this->session->userdata('employer_id');?>','<?php echo $bill_offers->id;?>','subscription');" ><i class="fa fa-circle-check fa-lg text-success  pull-left"></i></a>
                  
                  <?php } echo '</td>'
                  ;?>
                  
                <?php echo '</tr>';
                }
                ?>
                </tbody>
          </table>
        </div>
       </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">close</button>
      </div>
    </div>
  </div>
</div>




<!-- Central Modal Medium Warning-->
  <div class="bts-popup" role="alert">
      <div class="bts-popup-container"><br>
        <h3 style="font-family: serif;"><center>Kindly Check Your Notification Alerts!</center></h3>
        <div class="col-md-12" style="height:340px;overflow-y: scroll;">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
                <span class="dl-horizontal col-sm-12">
                  <?php if(empty($job_licensee))
                  { if(empty($check_license_request)) { ?>
                    <h4 class="text-danger"><span class="blink"> NO ACTIVE LICENSE <br><n>Avail now to enjoy the recruitment system features!</n></span></h4>
                  <?php } else{ 
                    foreach($check_license_request as $clr)
                    { 
                      $package_id = $clr->package_id;
                      $pid = $clr->pid;
                      if($package_id==0){ $res_result= 'free_trial'; }else{ $res_result= 'subscription'; }
                      break;
                    }

                  ?>

                    <n class="text-danger"><span class="blink">Kindly complete the required requirements <br><?php if($res_result=='subscription'){?> and settle payment <?php } ?>for the activation of the <?php echo $res_result;?>  license!  </span></n>
                    <br><br>
                    <table class="col-md-12 table table-bordered">
                    <thead>
                      <tr class="danger">
                        <th><center>Requirement</center></th>
                        <th><center>Status</center></th>
                        <th><center>Comment</center></th>
                        <th><center>Date Updated</center></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($check_license_request as $clr){ ?>
                      <tr>
                        <td><?php echo $clr->title;?></td>
                        <td><?php echo $clr->status;?></td>
                        <td><?php if(empty($clr->comment)) { echo "No Comment"; } else { echo $clr->comment; } ?></td>
                        <td><?php if(empty($clr->date_approved)) { echo "Not yet approved"; } else{  echo $clr->date_approved; } ?></td>
                      </tr>
                    <?php } ?>
                    </tbody>  
                  </table>
                  <a href="<?php echo base_url();?>recruitment_employer/recruitment_employer_management/get_package_pending_requirements/<?php echo $company_id."/".$employer_id."/".$pid."/".$res_result;?>" target="_blank"  href class="btn btn" style="color:black;border:1px solid brown;font-size: 10px;">View Details</a>

                  <?php } }
                  else
                  {
                    $jleft = $job_licensee[2] - $job_licensee[0];

                    if($jleft==0)
                    {
                      echo "<h4 class='text-danger'><span class='blink'>You have used up your job license . Please avail package to continue posting!</span></h4>";
                    } 
                    else
                    {
                      if($job_licensee[1]=='free_trial'){ $h = 'Free Trial'; } else { $h='Subscription'; } 
                      echo "<h4 class='text-danger'><span>Active ".$h."  License!</span></h4>";
                    }
                    
                  ?>
                    <div class="col-md-6">
                      <n>Validity License of <?php echo $job_licensee[3]; if($job_licensee[3]>1){ echo " Months"; } else{ echo " Month";} ?> </n><br>
                      <n>Job License of <?php echo $job_licensee[2]; if($job_licensee[2]>1){ echo " Jobs"; } else{ echo "Job";} ?> : </n><br>
                      <n>Posted <?php echo $job_licensee[0];?> Job<?php if($job_licensee[0] > 1){ echo "s"; } else{ echo "";} ?> </n><br>
                    
                    </div>

                    <div class="col-md-6">
                      <n>Date End :
                      <?php 
                        $month=substr($job_licensee[4], 5,2);
                    $day=substr($job_licensee[4], 8,2);
                    $year=substr($job_licensee[4], 0,4);

                    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                      ?>

                      </n><br>
                      <n>Date Now: 

                      <?php 
                        $month=substr(date('Y-m-d'), 5,2);
                    $day=substr(date('Y-m-d'), 8,2);
                    $year=substr(date('Y-m-d'), 0,4);

                    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                      ?>
                      
                      </n><br>
                      <n>Remaining job license of  <?php echo $jleft;?> Job<?php if($jleft > 1){ echo "s"; } else{ echo "";} ?> </n><br>
                      
                    </div>
                  <?php }
                  ?>
                  
                </span>
              </div>
          </div>
          </div>


      <?php  if(empty($job_checker)){}else{?> 

          <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
                <span class="dl-horizontal col-sm-12"><h4 class="text-danger">Posted Job Position/s Status Updates</h4>
              <div class="col-md-12">
                  <table class="col-md-12 table table-bordered">
                    <thead>
                      <tr class="danger">
                        <th><center>Job Position</center></th>
                        <th><center>Status</center></th>
                        <th><center>Comment</center></th>
                        <th><center>Date Updated</center></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($job_checker as $jc){?>
                      <tr>
                        <td><?php echo $jc->position_name;?></td>
                        <td><?php if($jc->admin_verified==1){ echo "approved"; } else{ echo $jc->position_name; } ?></td>
                        <td><?php if(empty($jc->comment)){ echo "no comment"; } else { echo $jc->comment; } ?></td>
                        <td><?php echo $jc->date_approved;?></td>
                      </tr>
                    <?php } ?>
                    </tbody>  
                  </table>
                    <a <?php if(empty($check_license_request) AND empty($job_licensee)){} else{ ?> href="<?php echo base_url();?>app/recruitments/job_vacancy_index/public" target="_blank" <?php } ?> class="btn btn" style="color:black;border:1px solid brown;font-size: 10px;"><?php if(empty($check_license_request) AND empty($job_licensee)){ echo "Avail License to continue"; } else{ echo "View Details"; }?></a>
              </div>   
                </span>
              </div>
          </div>
          </div>
      <?php } ?>


      <?php  if($unread_applications==0){}
      else{?>
          <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
                <span class="dl-horizontal col-sm-12">
                <br>
                  <h4 class="text-danger"><span class="blink"><b><?php echo $unread_applications;?> Unread Applicant Application</b></span></h4>
                  <a <?php if(empty($check_license_request) AND empty($job_licensee)){} else{ ?> href="<?php echo base_url();?>app/recruitments/job_application_index/public/all/all" target="_blank" <?php } ?>  class="btn btn" style="color:black;border:1px solid brown;font-size: 10px;"><?php if(empty($check_license_request) AND empty($job_licensee)){ echo "Avail License to continue"; } else{ echo "View Details"; }?></a>
                </span>
              </div>
          </div>
          </div>
      <?php } ?>

      <?php  if(count($applicant_interview_response)==0)
      {}else{?>
          <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
                <span class="dl-horizontal col-sm-12">
                  <h4 class="text-danger"><span class="blink"><b><?php echo count($applicant_interview_response);?> Interview Applicant/s Response</b></span></h4>
                  <a <?php if(empty($check_license_request) AND empty($job_licensee)){} else{ ?> href="<?php echo base_url();?>app/recruitments/job_application_index/public/all/all" target="_blank" <?php } ?> href class="btn btn" style="color:black;border:1px solid brown;font-size: 10px;"><?php if(empty($check_license_request) AND empty($job_licensee)){ echo "Avail License to continue"; } else{ echo "View Details"; }?></a>
                </span>

              </div>
          </div>
          </div>
      <?php } ?>

     
      <?php if(count($applicant_reschedule_request) == 0){}
      else{?>
      <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
                <span class="dl-horizontal col-sm-12">
                  <h4 class="text-danger"><span class="blink"><b><?php echo count($applicant_reschedule_request);?> Pending Applicant Reschedule Interview Request </b></span></h4>
                  <a <?php if(empty($check_license_request) AND empty($job_licensee)){} else{ ?> href="<?php echo base_url();?>app/recruitments/job_application_index/public/all/all" target="_blank"  <?php } ?> class="btn btn" style="color:black;border:1px solid brown;font-size: 10px;"><?php if(empty($check_license_request) AND empty($job_licensee)){ echo "Avail License to continue"; } else{ echo "View Details"; }?></a>
                </span>
              </div>
          </div>
      </div>
      <?php } ?>
     </div>
          <div class="bts-popup-button">
             <a href=""><b><n class="text-success">MARK AS READ</n></b></a>
           </div>
          <a href="#0" class="bts-popup-close img-replace">Close</a>
      </div>
  </div>


<!-- new added modal for list of subscription



<!-- all modals here -->





<style type="text/css">
* {
  box-sizing: border-box;
  }


.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
}

.modal-dialog {
  position: fixed;
  margin: 0;
  width: 100%;
  height: 100%;
  padding: 0;
}

.modal-content {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  border: 2px solid #3c7dcf;
  border-radius: 0;
  box-shadow: none;
}

.modal-header {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  height: 50px;
  padding: 10px;
  background: #6598d9;
  border: 0;
}

.modal-title {
  font-weight: 300;
  font-size: 2em;
  color: #fff;
  line-height: 30px;
}

.modal-body {
  position: absolute;
  top: 50px;
  bottom: 60px;
  width: 100%;
  font-weight: 300;
  overflow: auto;
}

.modal-footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  height: 60px;
  padding: 10px;
  background: #f1f3f5;
}


/*.btn-modal {
  position: absolute;
  top: 50%;
  left: 50%;
  margin-top: -20px;
  margin-left: -100px;
  width: 200px;
}*/
 .blink{
          
          font-family: cursive;
          animation: blink 2s linear infinite;
        }
   
              
        @keyframes blink{
        0%{opacity: 0;}
        50%{opacity: .5;}
        100%{opacity: 1;}
    }      
        

  .img-replace {
  /* replace text with an image */
  display: inline-block;
  overflow: hidden;
  text-indent: 100%; 
  color: transparent;
  white-space: nowrap;
}
.bts-popup {
  position: fixed;
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  opacity: 0;
  visibility: hidden;
  -webkit-transition: opacity 0.3s 0s, visibility 0s 0.3s;
  -moz-transition: opacity 0.3s 0s, visibility 0s 0.3s;
  transition: opacity 0.3s 0s, visibility 0s 0.3s;
}
.bts-popup.is-visible {
  opacity: 1;
  visibility: visible;
  -webkit-transition: opacity 0.3s 0s, visibility 0s 0s;
  -moz-transition: opacity 0.3s 0s, visibility 0s 0s;
  transition: opacity 0.3s 0s, visibility 0s 0s;
}

.bts-popup-container {
  position: relative;
  width: 100%;
  max-width: 800px;
  margin: 4em auto;
  background: #a0cff1;
  border-radius: none; 
  text-align: center;
  box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
  -webkit-transform: translateY(-40px);
  -moz-transform: translateY(-40px);
  -ms-transform: translateY(-40px);
  -o-transform: translateY(-40px);
  transform: translateY(-40px);
  /* Force Hardware Acceleration in WebKit */
  -webkit-backface-visibility: hidden;
  -webkit-transition-property: -webkit-transform;
  -moz-transition-property: -moz-transform;
  transition-property: transform;
  -webkit-transition-duration: 0.3s;
  -moz-transition-duration: 0.3s;
  transition-duration: 0.3s;
}
.bts-popup-container img {
  padding: 20px 0 0 0;
}
.bts-popup-container p {
  color: white;
  padding: 10px 40px;
}
.bts-popup-container .bts-popup-button {
  padding: 5px 25px;
  border: 2px solid white;
  display: inline-block;
  margin-bottom: 10px;
}

.bts-popup-container a {
  color: white;
  text-decoration: none;
  text-transform: uppercase;
}

.bts-popup-container .bts-popup-close {
  position: absolute;
  top: 8px;
  right: 8px;
  width: 30px;
  height: 30px;
}
.bts-popup-container .bts-popup-close::before, .bts-popup-container .bts-popup-close::after {
  content: '';
  position: absolute;
  top: 12px;
  width: 16px;
  height: 3px;
  background-color: red;

}
.bts-popup-container .bts-popup-close::before {
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
  left: 8px;
}
.bts-popup-container .bts-popup-close::after {
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  transform: rotate(-45deg);
  right: 6px;
  top: 13px;
}
.is-visible .bts-popup-container {
  -webkit-transform: translateY(0);
  -moz-transform: translateY(0);
  -ms-transform: translateY(0);
  -o-transform: translateY(0);
  transform: translateY(0);
}
@media only screen and (min-width: 1170px) {
  .bts-popup-container {
    margin: 8em auto;

  }
}
</style>

<script type="text/javascript">
    $(function () {
        $('#sem_tra').DataTable({
          "pageLength":-1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[-1,20, 40, 60,100], ["All",20,40,60,100]],
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
  });

</script>


<?php if($view_modal==true)
{?>

<script type="text/javascript">
  jQuery(document).ready(function($){
  
  window.onload = function (){
    $(".bts-popup").delay(1000).addClass('is-visible');
  }
  
  //open popup
  $('.bts-popup-trigger').on('click', function(event){
    event.preventDefault();
    $('.bts-popup').addClass('is-visible');
  });
  
  //close popup
  $('.bts-popup').on('click', function(event){
    if( $(event.target).is('.bts-popup-close') || $(event.target).is('.bts-popup') ) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });
  //close popup when clicking the esc keyboard button
  $(document).keyup(function(event){
      if(event.which=='27'){
        $('.bts-popup').removeClass('is-visible');
      }
    });
});
</script>

<?php } ?>


 <?php require_once(APPPATH.'views/include/footer.php');?>
 <script src="<?php echo base_url()?>public/validation.js"></script>
    <?php require_once(APPPATH.'views/include/footer.php');?>
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