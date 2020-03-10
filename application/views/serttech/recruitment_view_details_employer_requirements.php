
<?php if($view_option=='view_employer_details'){?>
<div class="col-md-12">
    <div class="box box-default">
        <div class="box-header with-border">
             <h3 class="box-title"><?php foreach($details_req as $row){ echo $row->company_name;}?></h3>
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
                <?php foreach($details_req as $d){?>
                  <tr>
                    <td>Industry</td>
                    <td class="text-info"><strong><?php echo $row->cValue;?></strong></td>
                  </tr>
                  <tr>
                    <td>Employees</td>
                    <td class="text-info"><strong><?php echo $row->employee_counts;?> Employees</strong></td>
                  </tr>
                  <tr>
                    <td>Company TIN</td>
                    <td class="text-info"><strong><?php echo $row->company_tin;?></strong></td>
                  </tr>
                  <tr>
                    <td>Contact Person</td>
                    <td class="text-info"><strong><?php echo $row->contact_person;?></strong></td>
                  </tr>
                  <tr>
                    <td>Designation</td>
                    <td class="text-info"><strong><?php echo $row->designation;?></strong></td>
                  </tr>
                  <tr>
                    <td>Website</td>
                    <td class="text-info"><strong><?php echo $row->company_website;?></strong></td>
                  </tr>
                  <tr>
                    <td>Telephone No.</td>
                    <td class="text-info"><strong><?php echo $row->tel_no;?></strong></td>
                  </tr>
                   <tr>
                    <td>Mobile No.</td>
                    <td class="text-info"><strong><?php echo $row->mobile_no;?></strong></td>
                  </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php }elseif($view_option=='view_employer_req' AND $view_action=='Update_req'){ 
  $status = $this->serttech_recruitment_setting_model->check_request_status_requirement($id);
?>

<div class="col-md-12">
    <div class="box box-default">
        <div class="box-header with-border">
             <h3 class="box-title">Update Requirement Status</h3>
             <?php if(empty($status)){} else{ if($status=='pending'){?>
              <a class="btn pull-right btn-success btn-xs" style='cursor:pointer;'aria-hidden='true' data-toggle='tooltip' title='Click to Approve All Requirements' onclick="requirement_request_action('Update_req','approve_all','<?php echo $id;?>','All','<?php echo $type;?>')">Approve all</a>
              <?php } else if($status=='approved'){ echo "Approved"; } else{} } ?>
        </div>
        <div class="box-body">
            <table class="table table-user-information" id="Update_req">
                <thead>
                    <tr style="display: none;">
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($details_req as $d){?>
                    <tr>
                        <td><?php echo $i.").";?></td>
                        <td class="text-info">
                                <div class="col-md-12"><strong><?php echo $d->title;?></strong></div>
                                <div class="col-md-12"> 

                                      <div class="col-md-4">Status:</div>
                                      <div class="col-md-8">
                                          <?php if($d->status=='pending'){echo "<n class='text-success'>".$d->status."</n>";} else{ echo "<n class='text-danger'>".$d->status."</n>"; }?>
                                      </div>   
                                </div>

                                <?php if($d->IsUploadable==1)
                                {?>
                                <div class="col-md-12"> 
                                      <div class="col-md-4">File Uploaded::</div>
                                      <div class="col-md-8">
                                         <?php echo $d->file;?>
                                      </div>   
                                </div>
                                <div class="col-md-12"> 

                                      <div class="col-md-4">Date Submitted:</div>
                                      <div class="col-md-8">
                                         <?php echo $d->date_submit;?>
                                      </div>   
                                </div>
                                <?php } ?>
                                <div class="col-md-12"> 

                                      <div class="col-md-4">Comment:</div>
                                      <div class="col-md-8">
                                          <?php echo $d->comment;?>
                                      </div>   
                                </div>
                                <?php if(empty($d->date_approved)){}else {?>
                                 <div class="col-md-12"> 

                                      <div class="col-md-4">Date Approved:</div>
                                      <div class="col-md-8">
                                          <?php echo $d->date_approved;?>
                                      </div>   
                                </div>
                                <?php } ?>
                                <div id="update<?php echo $d->id;?>" style='display: none;'>
                                   <div class="col-md-4"></div>
                                   <div class="col-md-8">
                                      <input type="text" id="update_comment<?php echo $d->req_id;?>" class="form-control" value="<?php echo $d->comment;?>">
                                      <input type="hidden" id="update_comment_<?php echo $d->req_id;?>">
                                    </div>
                                    <div class="col-md-12">

                                      <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Update Comment' class="text-success pull-right" onclick="requirement_request_action('Update_req','update_comment','<?php echo $id;?>','<?php echo $d->req_id;?>','<?php echo $type;?>')"><i  class="fa fa-check fa-sm  pull-left"></i></a>
                                      <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Cancel Comment' class="text-danger pull-right" onclick="requirement_request_action('Update_req','cancel_comment','<?php echo $id;?>','<?php echo $d->id;?>','<?php echo $type;?>')"><i  class="fa fa-times fa-sm  pull-left"></i></a>
                                    

                                    </div>
                                </div>
                                <?php if($d->status=='approved'){}
                                else{?>
                                <div id="original<?php echo $d->id;?>">
                              
                                    <div class="col-md-12">
                                        <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Approve Requirement' class="text-success pull-right" onclick="requirement_request_action('Update_req','approve','<?php echo $id;?>','<?php echo $d->req_id;?>','<?php echo $type;?>')"><i  class="fa fa-check fa-sm  pull-left"></i></a>
                                      <?php if(empty($d->file)){} else{?> 
                                         <a  href="<?php echo base_url(); ?>recruitment_employer/recruitment_employer_management/download_requirement/<?php echo $d->file; ?>" style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Download Requirement' class="text-success pull-right"><i  class="fa fa-download fa-sm  pull-left"></i></a>
                                      <?php } ?>
                                         <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to Write Comment About Requirement' class="text-success pull-right" 
                                         onclick="requirement_request_action('Update_req','comment','<?php echo $id;?>','<?php echo $d->id;?>','<?php echo $type;?>')"><i  class="fa fa-pencil fa-sm  pull-left"></i></a>
                                    </div>
                              </div>
                              <?php } ?>
                        </td>
                    </tr>
                   
                <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php } elseif($view_action=='view_req' AND $view_option=='view_employer_req'){?>
    
    <div class="col-md-12">
    <div class="box box-default">
        <div class="box-header with-border">
             <h3 class="box-title">Update Requirement Status</h3>
        </div>
        <div class="box-body">
          <?php $checker = $this->serttech_recruitment_setting_model->checker_if_with_req($id);
          if(empty($checker) || $checker==0){ echo "<h3 class='text-danger'>No Requirement/s required.</h3>"; } else if($checker==1){
          ?>
            <table class="table table-user-information" id="view_req">
                <thead>
                    <tr style="display: none;">
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($details_req as $d){?>
                    <tr>
                        <td><?php echo $i.").";?></td>
                        <td class="text-info">
                                <div class="col-md-12"><strong><?php echo $d->title;?></strong></div>
                                <div class="col-md-12"> 

                                      <div class="col-md-4">Status:</div>
                                      <div class="col-md-8">
                                          <?php if($d->status=='pending'){echo "<n class='text-success'>".$d->status."</n>";} else{ echo "<n class='text-danger'>".$d->status."</n>"; }?>
                                      </div>   
                                </div>

                              
                                <?php if($d->IsUploadable==1)
                                {?>
                                <div class="col-md-12"> 
                                      <div class="col-md-4">File Uploaded::</div>
                                      <div class="col-md-8">
                                         <?php echo $d->file;?>
                                      </div>   
                                </div>
                                <div class="col-md-12"> 

                                      <div class="col-md-4">Date Submitted:</div>
                                      <div class="col-md-8">
                                         <?php echo $d->date_submit;?>
                                      </div>   
                                </div>
                                <?php } ?>
                                
                                <div class="col-md-12"> 

                                      <div class="col-md-4">Comment:</div>
                                      <div class="col-md-8">
                                          <?php echo $d->comment;?>
                                      </div>   
                                </div>
                                <?php if(empty($d->date_approved)){}else {?>
                                 <div class="col-md-12"> 

                                      <div class="col-md-4">Date Approved:</div>
                                      <div class="col-md-8">
                                          <?php echo $d->date_approved;?>
                                      </div>   
                                </div>
                               <?php }?>
                        </td>
                    </tr>
                   
                <?php $i++; } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>
</div>


<?php } ?>