 <div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"><center>            
            <?php 
                if($action=='view'){}
                else{
                if($job_id=='all'){ $j = 'All Jobs'; } else { $j = 'Job ID '.$job_id;}
                if($this->session->flashdata('success_approved') AND $status_res=='approved')
                      { 
                        echo ''.$j.' is successfully approved.';
                      } 
                    
                      else if($this->session->flashdata('success_cancelled') AND $status_res=='cancelled')
                      { 
                        echo ''.$j.' is successfully cancelled.';
                      }
                      else if($this->session->flashdata('success_rejected') AND $status_res=='rejected')
                      { 
                        echo ''.$j.' is successfully rejected.';
                      }
                      else if($this->session->flashdata('success_save_comment') AND $status_res=='save_comment')
                      { 
                        echo 'Comment for '.$j.' is Successfully updated.';
                      }
                       else if($this->session->flashdata('success_disable') AND $status_res=='disable')
                      { 
                        echo 'Package  '.$j.' is Successfully disabled.';
                      }
                      else
                      { 
                        
                      }
                    }
                ?>
  </center>
  </n>
  </div>
                <div class="col-md-12" style="padding-top: 30px;">
                      <div class="col-md-3"></div>
                      <div class="col-md-6">
                        <select class="form-control" onchange="get_company_job_manage(this.value,'<?php echo $status;?>');">
                          <?php
                             $companyList=$this->serttech_recruitment_setting_model->employers_job();
                          ?>
                            <option value="" disabled selected>Select Company</option>
                          <?php if(empty($companyList)){ echo "<option value=''>No company found.</option>"; } else{
                            foreach($companyList as $comp){?>
                            <option value="<?php echo $comp->company_id;?>" <?php if($company_id==$comp->company_id){ echo "selected"; }?>><?php echo $comp->company_name;?></option>
                          <?php } }?>
                        </select>
                      </div>
                      <div class="col-md-3"></div>
                  </div>
                   <div id="by_company_result">
                  <table class="col-md-12 table table-hover" id="table_requirements">
                     <thead>
                       <tr class="danger">
                              <th>ID</th>
                              <th>Company Name</th>
                              <th>Position</th>
                               <th style="width:10%;">Date Posted</th>
                              <th>Comment</th>
                              <?php if($status=='waiting')
                              {?><th>Action
                              <?php if(empty($jobs)){}
                                else{?>
                              <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Reject Job Request'><i  class="fa fa-times fa-lg  pull-right text-danger" onclick="job_management_action('status_update','<?php echo $status;?>','all','rejected','<?php echo $company_id;?>')"></i></a>

                                   <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Job Request'><i  class="fa fa-undo fa-lg  pull-right text-warning" onclick="job_management_action('status_update','<?php echo $status;?>','all','cancelled','<?php echo $company_id;?>')"></i></a>

                                    <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Approve Job Request'><i  class="fa fa-check fa-lg  pull-right text-success" onclick="job_management_action('status_update','<?php echo $status;?>','all','approved','<?php echo $company_id;?>')"></i></a>
                              <?php } ?>
                              </th> <?php } elseif($status=='cancelled'){?>
                               <th>Date Cancelled</th>
                               <th>Action</th>
                               <?php } elseif($status=='rejected'){ echo "<th>Date Rejected</th>"; } elseif($status=='approved'){?><th>Date Approved</th><?php }?>

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
                             <?php if($status=='waiting'){}
                            else{ echo "<td>".$j->date_approved."</td>"; }?>
                             <?php if($status=='waiting' || $status=='cancelled')
                              {?>
                              <td>
                              
                                  <div id="original<?php echo $j->job_id;?>">
                                    <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Job Details'><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left" onclick="job_management_action('update','<?php echo $status;?>','<?php echo $j->job_id;?>','status_action','<?php echo $company_id;?>')"></i></a>

                                    <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Approve Job Request'><i  class="fa fa-check fa-lg  pull-left text-success" onclick="job_management_action('status_update','<?php echo $status;?>','<?php echo $j->job_id;?>','approved','<?php echo $company_id;?>')"></i></a>

                                     <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Reject Job Request'><i  class="fa fa-times fa-lg  pull-left text-danger" onclick="job_management_action('status_update','<?php echo $status;?>','<?php echo $j->job_id;?>','rejected','<?php echo $company_id;?>')"></i></a>
                                     <?php if($status=='cancelled'){}
                                    else{?>
                                     <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Job Request'><i  class="fa fa-undo fa-lg  pull-left text-warning" onclick="job_management_action('status_update','<?php echo $status;?>','<?php echo $j->job_id;?>','cancelled','<?php echo $company_id;?>')"></i></a>
                                   <?php  } ?>
 
                                  </div>
                                  <div id="update<?php echo $j->job_id;?>" style='display: none;'>
                                  <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Comment Job Details' onclick="job_management_action('save_comment','<?php echo $status;?>','<?php echo $j->job_id;?>','save_comment','<?php echo $company_id;?>')"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>
                                  <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Comment' onclick="job_management_action('cancel','<?php echo $status;?>','<?php echo $j->job_id;?>','status_action','<?php echo $company_id;?>')"><i  class="fa fa-times fa-lg  pull-left text-danger"></i></a>
                                  </div>
                             </td>
                                <?php } ?>

                        </tr>
                    <?php $i++; } ?>
                     </tbody>
                  </table>
                  </div>
