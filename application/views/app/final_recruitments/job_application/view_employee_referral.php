 <div class="modal-content">
        

              <div>
                <div class="box-body">
                  <div class="col-lg-12">      
                       <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-aqua-active">
                          <h4 style="font-family: serif;"><n><center><b><?php echo $app_info->fullname;?></b></center></n></h4> 
                          <h4 style="font-family: serif;"><n><center><?php echo $app_info->job_title;?></center></n></h4> 
                            <br>
                        </div>
                          <div class="widget-user-image pull" style="padding-top: 12px;">
                            <img class="img-circle" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $app_info->picture;?>" alt="User Avatar">
                          </div>
                          <div class="box-footer"></div>
                        </div>
                  </div>
                </div>
              </div>
           <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/final_recruitments/save_blocked_applicant_job_application/">

              <div class="col-md-12">
                <h4><center>Employee Referral</center></h4>
              <div class="panel panel-default">
                <div class="panel-body">
                  <span class="dl-horizontal col-sm-12" id="referral_action"> 
                   
                      <table class="table table-hover" id="reff">
                          <thead>
                              <tr class="danger">
                                <th style="width: 5%;">ID</th>
                                <th style="width: 20%;">Employee Name</th>
                                <th style="width: 20%;">Employee ID</th>
                                <th style="width: 20%;">Status</th>
                                <th style="width: 45%;"></th>
                                <th style="width: 10%;"></th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php $i=1; foreach ($referral as $r) {?>
                              <tr>
                                <td><?php echo $r->id;?></td>
                                <td><?php echo $r->employee;?></td>
                                <td><?php if(empty($r->employee_id)){ echo "<n class='text-danger'>No employee id yet.</n>";} else { echo $r->employee_id;}?></td>
                                <td><?php if(empty($r->status)){ echo "Pending"; } else{ echo $r->status; }?></td>
                                <td>
                                  <?php if(empty($r->status)){?>
                                    <div id="orig<?php echo $r->id;?>"><n class="text-danger"><center>[Action here]</center></n></div>
                                    <div class="col-md-12" id="upd<?php echo $r->id;?>" style="display: none;">

                                        <select class="form-control" name="status<?php echo $r->id;?>" id="status<?php echo $r->id;?>" style='width: 100%;' onchange="referral_status(this.value,'<?php echo $r->id;?>');">
                                            <option value="">Select Status</option>
                                            <option value="approved">Approve</option>
                                            <option value="rejected">Reject</option>
                                        </select>

                                        <select class="form-control" style="margin-top: 5px;width: 100%;" name="company<?php echo $r->id;?>" id="company<?php echo $r->id;?>" required onchange="get_employees(this.value,'<?php echo $r->id;?>');"> 
                                            <option>Select Company</option>
                                            <?php foreach($companyList as $comp){?>
                                                <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                            <?php } ?>
                                        </select>

                                         <select class="form-control" style="margin-top: 5px;width: 100%;" name="employee<?php echo $r->id;?>" id="employee<?php echo $r->id;?>" required> 
                                            <option>Select Employee</option>
                                        </select>

                                        <input class="form-control" style="margin-top: 5px;width: 100%;"  name="comment<?php echo $r->id;?>" id="comment<?php echo $r->id;?>" placeholder="Comment" required>
                                        <input type="hidden" id="commentfinal<?php echo $r->id;?>">
                                          
                                    </div>
                                    <?php } else{ echo "Comment : <n class='text-danger'>".$r->admin_comment."</n>"; } ?>
                                </td>
                                <td>
                                <?php if(empty($r->status)){?>
                                    <div id="actionorig<?php echo $r->id;?>">
                                      <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'   onclick="update_referral_status('<?php echo $r->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to update referral status'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                                    </div>

                                    <div id="actionupd<?php echo $r->id;?>" style='display: none;'>
                                      <a style='cursor:pointer;color:green;'   onclick="saveupdate_referral_status('<?php echo $r->id;?>','<?php echo $idd;?>','<?php echo $job_id;?>','<?php echo $applicant_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to update referral status'  ><i  class="fa fa-check fa-lg  pull-left"></i></a>
                                      <a style='cursor:pointer;color:red;'   onclick="cancel_referral_status('<?php echo $r->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to cancel referral status'  ><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                    </div>
                                <?php } else { echo "-"; } ?>
                                </td>
                                
                              </tr>
                          <?php $i++; } ?>
                          </tbody>
                      </table>

                  </span>

                
                </div>
              </div>
              </div>

        
          <div class="modal-footer">
           
            <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
          </div> 

          </form>
      </div>
    </div>

    <script type="text/javascript">
      $(function () {
        $('#reff').DataTable({
          "pageLength": -1,
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