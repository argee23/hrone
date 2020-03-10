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
    <script>
        window.onload = function() { <?php echo $onload ?>; };
    </script>

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

        if(empty($job_licensee))
        {
          $job_left_license = '1';
          $month_left_license = '1';
        }
        else
        {
            $job_left_license = $job_licensee[2] - $job_licensee[0];
            $month_left_license = $job_licensee[4];
        }

       

        
    ?>
  <body>

  <div class="col-md-12" style="margin-top: 10px;">
    <?php echo $message;?>
  </div>

  <div class="row">
  <div class="col-md-12"  id="main_table_div">
    <div class="col-md-4" style="padding-top: 20px;">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                  <div class="active tab-pane" id="admin_reminders"> 

                   <?php  if($check_if_active_license > 0){  
                      $jleft = $job_licensee[2] - $job_licensee[0];
                    ?> 


                     <center> <h4 class="text-danger"><span class="blink">
                      <?php if($jleft==0){?>
                        You have used up your job license.<br> Please avail package to continue posting!
                     <?php } else{ ?>
                        Remaining Job License of <?php echo $jleft;?>
                     <?php }?> 
                          

                      </span></h4>
                       <h4 class="text-danger">
                        <span class="blink">Valid Until
                              <?php 
                                  $month=substr($job_licensee[4], 5,2);
                                  $day=substr($job_licensee[4], 8,2);
                                  $year=substr($job_licensee[4], 0,4);

                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                              ?>
                       </span>
                       </h4>
                       </center>

                   <?php } else { ?>

                   <center><h4 class="text-danger"><span class="blink">NO ACTIVE LICENSE <br>Avail now to enjoy the recruitment system features!</span></h4>
                   </h4>


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
                                            $date_end = $get_active_license_details->date_end;
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
                                <td colspan="2"> </td>
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
                              <tr class="alt"></td>
                              </tr>
                              <?php } }
                               else{?>
                              <tr class="alt">
                                <td colspan="2">
                                  <n class='text-danger'>No License found.</n>
                                </td>
                              </tr>
                           <?php } ?>

                            <tr>
                               <?php if(empty($get_active_license_details)){ $fs=''; } elseif($get_active_license_details->active_usage_type=='free_trial'){ $fs='free_trial'; } else{ $fs='subscription'; } ?>
                                 <td>
                                 <?php  if(empty($get_active_license_details)){}else{?>
                                  <center><a style="cursor: pointer;"  onclick="get_active_license('<?php echo $fs;?>','<?php echo $company_id;?>','<?php echo $get_active_license_details->id;?>');" data-toggle="modal" data-target="#fsModal"><strong><small>View More Details</small></strong></a></center>
                                  <?php } ?>
                                  <center><button style="cursor: pointer;margin-top: 10px;" class="btn btn-default btn-modal" onclick="get_employer_history('active_license','<?php echo $company_id;?>');" class="btn btn-default btn-modal" data-toggle="modal" data-target="#fsModal"><strong><small>View History</small></strong></button></center>
                                </td>
                                <td></td>
                               
                              </tr>

                          </tbody>
                        </table>  
                    </div>
                  </div>
                </div>
            </div>
      
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"  style="width:100%;"><h4 style="padding-left: 10px;"><i class="fa fa-bullhorn text-danger"></i>Pending Request
            <?php if(!empty($check_if_active_free_trial_request) || !empty($check_if_active_subscription_request)){?>
            <a class="pull-right" onclick="cancel_pending_request('<?php echo $company_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Pending Request'>
                <i style='font-size: 20px;margin-right: 20px;cursor: pointer;' class="fa fa-times-circle-o pull-right text-success"></i>
            </a>
            <?php } ?>
            </h4></li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="pending_request">
                 <div class="datagrid">
                          <table>
                            <thead></thead>
                            <tbody> 
                                <?php  $get_free_trial_details = $this->recruitment_employer_management_model->get_free_trial_details(); ?>
                                <tr class="alt">
                                  <td colspan="2"> 
                                       <?php if(!empty($check_if_active_free_trial_request) AND $check_if_active_free_trial_request->status=='pending')
                                        { ?> 
                                           <n> <span class="text-danger">Free Trial Request is ongoing, kindly complete all required requirements for the activation of your license. </span></n><br>
                                           <n class="text-info"-> Check <b>Todays Update</b>-><b>Pending License Requirement</b></n>  

                                        <?php }
                                        else if(!empty($check_if_active_subscription_request) AND $check_if_active_subscription_request->status=='pending')
                                        {?>
                                            <n> <center><span class="text-danger">Package Request is ongoing, kindly complete all required requirements and payment for the activation of your license. </span></center></n><br>
                                            <n class="text-info"-> Check <b>Todays Update</b>-><b>Pending License Requirement</b></n>    
                                        
                                       <?php  }
                                        else{ echo "<n class='text-danger'>No Pending Request</n>"; }?>
                                  </td>
                                </tr>
                                     <td colspan="2"><center><button style="cursor: pointer;"   onclick="get_employer_history('request_history','<?php echo $company_id;?>');" class="btn btn-default btn-modal"><strong><small>View Requirement Request History</small></strong></button></center></td>
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
                              <td colspan="2">
                              	<?php 
                              		 if(!empty($for_free_license_checker) AND $for_free_license_checker->status=='pending'){ echo "<center>Pending FREE TRIAL Request.</center>"; } 
						        	 else if(!empty($for_free_license_checker) AND $for_free_license_checker->status=='approved'){ echo "<center>You already used your free trial</center>"; }
						         	 else if($check_if_active_license > 0){ 
                        
                        $check_if_active_license =  $this->recruitment_employer_management_model->check_if_active_license($this->session->userdata('employer_id'),$company_id);
                        $date = date('Y-m-d');
                        if($date < $month_left_license AND $job_left_license==0)
                        { 
                          if (!empty($check_if_active_free_trial_request) || !empty($check_if_active_subscription_request))
                                    {
                                      echo "You have pending request.";
                                    } 
                          else{?>
                             <a type="button" class="col-md-12 btn btn-success" onclick="get_free_trial('<?php echo $company_id;?>');"><b><span class="blink"> Avail it Now!</b> </span></a>
                          <?php }
                        }
                        else
                        { echo "You're currently subscribe to subscription promo"; }

                      }
                       else if(!empty($check_if_active_free_trial_request) || !empty($check_if_active_subscription_request))
                        {
                          echo "<h5><center>You have pending request.</center></h5>";
                        }
						         	 else{ ?>
						             <a type="button" class="col-md-12 btn btn-success" onclick="get_free_trial('<?php echo $company_id;?>');"><b><span class="blink"> Avail it Now!</b> </span></a>
						            <?php }?>
						        </td>
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
                            <td colspan="2"><center><button style="cursor: pointer;" class="btn btn-default btn-modal" onclick="view_package_details();"><strong><small>View More Details</small></strong></button></center></td>
                          </tr>
                      </tbody>
                    </table>
              </div>
            </div>
          </div>
        </div>
      

    </div>


     <div class="col-md-8" style="padding-top: 20px;">


        <div class="nav-tabs-custom" id="main_nav_tab_div">
            <ul class="nav nav-tabs">

              <li class="active"><a href="#todays_update" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>Today's Updates</a></li>
              <li><a href="#license_requirements" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>License Requirements</a></li>
              <li><a href="#applicant_all" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>Applicants</a></li>
              <li><a href="#unread_applicants" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>Unread Applicants</a></li>
              <li><a href="#applicant_interview_request" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i><span>Reschedule Interview Request</span></a></li>
            </ul>
            <div class="tab-content">

                
                  <div class="active tab-pane" id="todays_update">

                    <?php if(!empty($check_if_active_free_trial_request) AND $check_if_active_free_trial_request->status=='pending')
                              { 

                                $today_res= "free_trial"; 
                                $idd_active = $check_if_active_free_trial_request->id;
                                
                              }
                              else if(!empty($check_if_active_subscription_request) AND $check_if_active_subscription_request->status=='pending')
                             { $today_res= "package";  $idd_active = $check_if_active_subscription_request->id; } else{ $today_res= ""; }?>
                      <?php if(!empty($today_res))
                      {

                       $details_pending_license = $this->recruitment_employer_management_model->get_requirement_status($company_id,$employer_id,$idd_active,$today_res);
                       
                      ?>     
                        <div class="datagrid">
                          <table>
                            <thead>
                              <tr>
                                <th colspan="7">Pending License Requirements</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="alt">
                                <td>No</td>
                                <td>Requirement</td>
                                <td>Status</td>
                                <td>IS Uploadable</td>
                                <td>File</td>
                                <td>Serttech Comment</td>
                                <td>Action</td>
                              </tr>

                               <?php $i=1;
                                foreach($details_pending_license as $row){?>
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
                                               <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  data-toggle='modal' data-target='#modal_lg' href="<?php echo base_url(); ?>recruitment_employer/recruitment_employer_management/employer_upload_requirements/<?php echo $company_id."/".$employer_id."/".$row->req_id."/".$row->idd."/".$today_res."/".$row->requirement_id;?>" aria-hidden='true' data-toggle='tooltip' title='Click to Edit Requirement' class='btn btn-xs btn-default'><i  class="fa fa-upload fa-lg  pull-left"></i></a>
                                          <?php }
                                          else{ echo "--"; } ?>
                                        </div>
                                      </td>
                                  </tr>
                                <?php $i++;  } ?>

                              <tr class="alt">
                                <td colspan="7"><i><span class="blink text-danger">Kindly complete all requirements for the activation of the license</span></i></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <br>
                      <?php } else{}?>

                      <?php if(count($applicant_job_position_today)==0){ }else{ ?>
                       <div class="datagrid">
                        <table>
                          <thead>
                            <tr>
                              <th colspan="6">Job Position Updates</th>
                            </tr>
                          </thead>
                          <tbody>
                             <tr class="alt">
                                <td>No</td>
                                <td>Position</td>
                                <td>Job Vacancy</td>
                                <td>Date Created</td>
                                <td>Salary</td>
                                <td>Status</td>
                            </tr>
                            <?php $ii=1; foreach($applicant_job_position_today as $pto){?>

                             <tr>
                                <td><?php echo $ii;?></td>
                                <td><?php echo $pto->position_name;?></td>
                                <td><?php echo $pto->job_vacancy;?></td>
                                 <td>

                                 <?php  
                                    $month=substr($pto->date_posted, 5,2);
                                    $day=substr($pto->date_posted, 8,2);
                                    $year=substr($pto->date_posted, 0,4);

                                    echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;

                                 ?>
                                   
                                 </td>
                                <td><?php echo number_format($pto->salary,2);?></td>
                                <td><?php if($pto->admin_verified==1){ echo "approved"; } else{ echo $pto->admin_verified; }?></td>

                            <?php $ii++; } ?>
                            </tr>

                             <tr class="alt">
                                <td colspan="6">
                                	<a target="_blank" style="cursor: pointer;" href="<?php echo base_url();?>/app/final_recruitments/job_vacancy_index/public"><center>Click here to redirect in Job Vacancies</center></a>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <br>

                      <?php  } ?>
                       <?php if(count($applicant_finalinterview_response_today)==0) { }else { ?>
                      <div class="datagrid">
                        <table>
                          <thead>
                            <tr>
                              <th colspan="6">Applicant Response for Company Final Interview Invitation</th>
                            </tr>
                          </thead>
                          <tbody>
                              <tr class="alt">
                              <td>Applicant</td>
                              <td>Position</td>
                              <td>Interview Details</td>
                              <td>Applicant Response</td>
                            </tr>
                          <?php foreach($applicant_finalinterview_response_today as $i_today){?>  
                             <tr>
                              <td><?php echo $i_today->fullname;?></td>
                              <td><?php echo $i_today->position_name;?></td>
                              <td>
                                <?php 

                                  echo "Interview Date : ".$i_today->new_date."<br>";
                                  echo "Interview Time : ".$i_today->new_time."<br>";
                                ?>
                                
                              </td>
                              <td><?php echo $i_today->response;?></td>
                            </tr>
                          <?php } ?>
                             <tr class="alt">
                              <td colspan="4">
                              	
                              	<a target="_blank" style="cursor: pointer;" href="<?php echo base_url();?>/app/recruitments/job_application_index/public/all/all"><center>Click here to redirect in Job Applications</center></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <br>
                      <?php } ?>

                      <?php if(count($todays_applicants)==0){}else{?>
                      <div class="datagrid">
                        <table>
                          <thead>
                            <tr>
                              <th colspan="6">Today's Applicants</th>
                            </tr>
                          </thead>
                          <tbody>
                              <tr class="alt">
                              <td>Applicant</td>
                              <td>Position</td>
                              <td>Application Status</td>
                              <td></td>
                            </tr>
                            <?php foreach($todays_applicants as $cc){?>
                             <tr>
                              <td><?php echo $cc->fullname;?></td>
                              <td><?php echo $cc->position_name;?></td>
                              <td><?php if(empty($cc->ApplicationStatus)){ echo "Pending Application"; } else { echo $cc->status_title; } ?></td>
                              <td>
                              		  <?php if($check_if_active_license > 0){?> <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' target="_blank" style="cursor: pointer;" href="<?php echo base_url();?>app/recruitments/applicant_profile/<?php echo $cc->employee_info_id;?>/<?php echo $cc->applicant_id;?>/<?php echo $cc->job_id;?>/<?php echo $company_id;?>/<?php echo $account;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a></td>
                                    <?php  } else{ echo "avail license to continue"; }?>
                              </td>
                            </tr>
                            <?php } ?>
                        
                             <tr class="alt">
                                <td colspan="7"><a target="_blank" style="cursor: pointer;" href="<?php echo base_url();?>/app/final_recruitments/job_application_index/public/all/all"><center>Click here to redirect in Job Applications</center></a></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <br>
                      <?php } ?>


                      <?php if(count($for_interview_applicants)==0) { }else { ?>
                       <div class="datagrid">
                        <table>
                          <thead>
                            <tr>
                              <th colspan="7">For Interview Applicants Today</th>
                            </tr>
                          </thead>
                          <tbody>
                           <tr class="alt">
                              <td>Applicant</td>
                              <td>Position</td>
                              <td>Interview Details</td>
                              <td>Interview Process</td>
                             
                            </tr>
                          <?php foreach($for_interview_applicants as $i_today){?>  
                             <tr>
                              <td><?php echo $i_today->fullname;?></td>
                              <td><?php echo $i_today->position_name;?></td>
                              <td>
                                <?php 
                                  echo "Interview Date : ".$i_today->applicant_official_time."<br>";
                                ?>
                                
                              </td>
                              <td><?php echo $i_today->title;?></td>
                            
                            </tr>
                          <?php } ?>
                             <tr class="alt">
                              <td colspan="7"><a target="_blank" style="cursor: pointer;" href="<?php echo base_url();?>/app/final_recruitments/job_application_index/public/all/all"><center>Click here to redirect in Job Applications</center></a></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <br>
                      <?php } ?>
                  </div>

               <!--   //for list of all applicant --> 
                  <div class="tab-pane" id="applicant_all" style="height:688px;overflow-y: scroll;">
                  <br><br>
                  <?php  $check = $this->recruitment_employer_model->get_status_job_application('pending',$company_id);
                  if(empty($check)){}else{
                  ?>
                     <script type="text/javascript">
                          $(function () {
                              $('#sem_trap').DataTable({
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
                      <h4 class="text-danger"><center><b>Applicants with Pending Application</b></center></h4>
                        <div class="col-md-12">
                          <table class="table table-hover" id="sem_trap">
                            <thead>
                              <tr class="danger">
                                <th>Position</th>
                                <th>Applicant</th>
                                <th>Date Applied</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($check as $cc){?>
                                <tr>
                                  <td><?php echo $cc->position_name;?></td>
                                  <td><?php echo $cc->fullname;?></td>
                                  <td>
                                       <?php 
                                          $month=substr($cc->date_applied, 5,2);
                                          $day=substr($cc->date_applied, 8,2);
                                          $year=substr($cc->date_applied, 0,4);

                                          echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                        ?>
                                  </td>
                                  <td>
                                    <?php if($check_if_active_license > 0){?> <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' target="_blank" style="cursor: pointer;" href="<?php echo base_url();?>app/recruitments/applicant_profile/<?php echo $cc->employee_info_id;?>/<?php echo $cc->applicant_id;?>/<?php echo $cc->job_id;?>/<?php echo $company_id;?>/<?php echo $account;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a></td>
                                    <?php  } else{ echo "avail license to continue"; }?>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      <?php } ?>

                    <?php foreach($recruitment_status_options as $so){

                      $check = $this->recruitment_employer_model->get_status_job_application($so->id,$company_id);
                      if(empty($check)){}
                      else{
                      ?>
                      <script type="text/javascript">
                          $(function () {
                              $('#sem_tra<?php echo $so->id;?>').DataTable({
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
                      <h4 class="text-danger"><center><b><?php echo $so->status_title;?></b>  Applicants</center></h4>
                        <div class="col-md-12">
                          <table class="table table-hover" id="sem_tra<?php echo $so->id;?>">
                            <thead>
                              <tr class="danger">
                                <th>Position</th>
                                <th>Applicant</th>
                                <th>Date Applied</th>
                                <?php if($so->id==1){ echo "<th>Status</th>"; }?>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($check as $cc){?>
                                <tr>
                                  <td><?php echo $cc->position_name;?></td>
                                  <td><?php echo $cc->fullname;?></td>
                                  <td>
                                       <?php 
                                          $month=substr($cc->date_applied, 5,2);
                                          $day=substr($cc->date_applied, 8,2);
                                          $year=substr($cc->date_applied, 0,4);

                                          echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                        ?>
                                  </td>
                                  <?php if($so->id==1){ 
                                   $details_interview = $this->recruitment_employer_model->get_applicant_details_interview($cc->job_id,$cc->interview_process);
                                   echo "<td>";
                                   foreach($details_interview as $di){
                                    if($di->response=='Accept' || $di->response=='Decline'){ echo $di->response; } 
                                    else if($di->response=='Reschedule')
                                    {
                                      if($di->company_response=='Accept' || $di->company_response=='Decline'){ echo $di->company_response; }
                                      else if($di->company_response=='Reschedule')
                                      {
                                        if(empty($di->company_resched_applicant_response))
                                        {
                                            echo $di->company_resched_applicant_response;
                                        } else { echo "No response yet"; }
                                      }
                                      else
                                      {
                                        echo "Applicant Reschedule Request: Pending";
                                      }
                                    } 
                                    else{ echo "No Response Yet"; }
                                  ?>
                                

                                  <?php  } echo "</td>"; } ?>
                                  <td>
                                    <?php if($check_if_active_license > 0){?> <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' target="_blank" style="cursor: pointer;" href="<?php echo base_url();?>app/recruitments/applicant_profile/<?php echo $cc->employee_info_id;?>/<?php echo $cc->applicant_id;?>/<?php echo $cc->job_id;?>/<?php echo $company_id;?>/<?php echo $account;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a></td>
                                    <?php  } else{ echo "avail license to continue"; }?>
                               

                                  </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>

                      <?php } } ?>

                      </div>


                 
                <!--  //for list of all applicant -->


                  <!--   //for list of all applicant --> 
                  <div class="tab-pane" id="unread_applicants" style="height:745px;overflow-y: scroll;">
                  
                    <?php if($unread_applications==0)
                    {?>
                      <br><br>
                      <h3 class="text-danger"><center>No Unread Applicants Application.</center></h3>
                      <br>
                    <?php } else{?>
                    <br>
                       <h4 class="text-danger"><center><b>List of Unread Applicant Application</b></center></h4>

                       <div class="col-md-12">
                          <table class="table table-hover" id="sem_tra">
                            <thead>
                              <tr class="danger">
                                <th>Position</th>
                                <th>Applicant</th>
                                <th>Date Applied</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($unread_applicants as $cc){
                                $if_unread = $this->recruitment_employer_model->check_if_account_seen($cc->company_id,$cc->employee_info_id,$cc->job_id);
                               
                                if($if_unread!=0){}else{
                                ?>
                                <tr>
                                  <td><?php echo $cc->position_name;?></td>
                                  <td><?php echo $cc->fullname;?></td>
                                  <td>
                                       <?php 
                                          $month=substr($cc->date_applied, 5,2);
                                          $day=substr($cc->date_applied, 8,2);
                                          $year=substr($cc->date_applied, 0,4);

                                          echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                        ?>
                                  </td>
                                  <td>
                                    <?php if($check_if_active_license > 0){?> <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' target="_blank" style="cursor: pointer;" href="<?php echo base_url();?>app/recruitments/applicant_profile/<?php echo $cc->employee_info_id;?>/<?php echo $cc->applicant_id;?>/<?php echo $cc->job_id;?>/<?php echo $company_id;?>/<?php echo $account;?>" aria-hidden='true' data-toggle='tooltip' title='Click to View Applicants Details' ><i  class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a></td>
                                    <?php  } else{ echo "avail license to continue"; }?>
                               

                                  </td>
                                </tr>
                              <?php }}  ?>
                            </tbody>
                          </table>
                       </div>


                    <br>
                    <?php } ?>
                  </div>
                <!--  //for list of all applicant -->


                  <!--   //for list of all applicant --> 
                  <div class="tab-pane" id="applicant_interview_request"  style="height:745px;overflow-y: scroll;">
                     <?php if(count($applicant_reschedule_request) == 0){?>

                        <br>
                        <h3 class="text-danger"><center>No Applicant Reschedule Interview Request Found!</center></h3>
                        <br>

                     <?php }
                     else { ?>
                          
                          <br>
                          <h4 class="text-danger"><center><b>List of Applicant Reschedule Interview Request</b></center></h4>
                          <script type="text/javascript">
                              $(function () {
                                  $('#sem_traa').DataTable({
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
                           <div class="col-md-12">
                            <table class="table table-hover" id="sem_traa">
                              <thead>
                                <tr class="danger">
                                  <th>Position</th>
                                  <th>Applicant</th>
                                  <th>Date Applied</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach($applicant_reschedule_request as $cc){
                                 
                                  ?>
                                  <tr>
                                    <td><?php echo $cc->position_name;?></td>
                                    <td><?php echo $cc->fullname;?></td>
                                    <td>
                                         <?php 
                                            $month=substr($cc->date_applied, 5,2);
                                            $day=substr($cc->date_applied, 8,2);
                                            $year=substr($cc->date_applied, 0,4);

                                            echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                          ?>
                                    </td>

                                  </tr>
                                   
                                <?php } ?>
                              </tbody>
                            </table>
                       </div>
                    <?php } ?>
                  </div>
                <!--  //for list of all applicant -->

                 <!--   //for license requirements -->
              <div class="tab-pane" id="license_requirements">
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
              

        </div>

     </div>

       <div class="nav-tabs-custom" style="display: none;" id="activelicensehistory_nav_tab_div">
	        <ul class="nav nav-tabs">
	              <li class="active" style="width: 100%;"><a href="#todays_update" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>Active License History</a></li>
	        </ul>
	        <div class="tab-content"  id="div_history_active">

	       </div>
	    </div>

	    <div class="nav-tabs-custom" style="display: none;" id="licenserequesthistory_nav_tab_div">
	        <ul class="nav nav-tabs">
	              <li class="active" style="width: 100%;"><a href="#todays_update" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>License Request History</a></li>
	        </ul>
	        <div class="tab-content" id="div_history_request">

	       </div>
	    </div>

	    <div class="nav-tabs-custom" style="display: none;" id="activelicensedetails_nav_tab_div">
	        <ul class="nav nav-tabs">
	              <li class="active" style="width: 100%;"><a href="#todays_update" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i>Active License Details</a></li>
	        </ul>
	        <div class="tab-content" id="main_body_result">

	       </div>
	    </div>
        
    </div>


  </div> 

  <!-- for the bill settings -->
  <div class="col-md-12" id="bill_setting_id" style="display: none;padding-top: 20px;">

        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                  <div class="active tab-pane" id="admin_reminders" style="height: 600px;overflow: scroll;">

                    <div class="col-md-12" id="d">
                        <script type="text/javascript">
                            $(function () {
                                $('#sem_trad').DataTable({
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
                        <br>
                        <h4 class="text-danger"><center>Subscription List </center></h4>
                        <?php $date= date('Y-m-d'); if($date < $month_left_license AND $job_left_license==0)
                                  { echo "<center><h5 class='text-success'><b>(Remaining Month Validity will be added to next approved license)</b></h5></h5>"; }
                            ?>
                         <table id="sem_trad" class="table table-bordered table-striped">
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
                                  $date = date('Y-m-d');
                                  if($date < $month_left_license AND $job_left_license==0)
                                  { 
                                    if (!empty($check_if_active_free_trial_request) || !empty($check_if_active_subscription_request))
                                    {
                                      echo "You have pending request.";
                                    } else{
                                  ?>
                                      <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to avail package'
                                    onclick="avail_package('<?php echo $company_id;?>','<?php echo $this->session->userdata('employer_id');?>','<?php echo $bill_offers->id;?>','subscription');" ><i class="fa fa-check fa-lg text-success  pull-left"></i></a>
                                
                                  <?php } }
                                  else if (!empty($check_if_active_free_trial_request) || !empty($check_if_active_subscription_request))
                                  {
                                    echo "You have pending request.";
                                  }
                                  else if($check_if_active_license > 0){ echo "You're currently subscribe to other promo"; } else{ 
                                  ?>

                                   <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to avail package'
                                    onclick="avail_package('<?php echo $company_id;?>','<?php echo $this->session->userdata('employer_id');?>','<?php echo $bill_offers->id;?>','subscription');" ><i class="fa fa-check fa-lg text-success  pull-left"></i></a>
                                
                                <?php } echo '</td>';?>
                                
                              <?php echo '</tr>';
                              }
                              ?>
                              </tbody>
                        </table>
                        <div class="col-md-12"><button class="btn btn-danger pull-right" onclick="location.reload();">BACK</button></div>
                      </div>

                  </div>
                </div>
            </div>
        </div>
      
  </div>


 <!--  end for bill settings -->


</div>    


   

















<!-- all modals here -->
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
             <a href=""><b><n class="text-success">CLOSE</n></b></a>
           </div>
          <a href="#0" class="bts-popup-close img-replace">Close</a>
      </div>
  </div>

  <div class="modal fade" id="modal_lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>


<!-- new added modal for list of subscription



<!-- all modals here -->





<style type="text/css">

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

  function view_package_details()
  {
    $('#main_table_div').hide();
    $('#bill_setting_id').show();
    
  }
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