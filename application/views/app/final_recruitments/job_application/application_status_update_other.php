
<?php 
   
      $admin_comment = $this->final_recruitments_model->admin_comment($app_id,$stat_id);
?> 
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
           <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/final_recruitments/save_other_applicant_job_application/<?php echo $app_id."/".$employer_type."/".$stat_id;?>">

              <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <span class="dl-horizontal col-sm-12"> 
                    
                    <h4 class="text-danger">Admin Comment</h4>
                    <input class="form-control" name="admin_comment" value="<?php if(empty($admin_comment)){} else{ echo $admin_comment; }?>" >

                   
                  </span>
                </div>
              </div>
              </div>

        
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">SAVE</button>
            <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
          </div> 

          </form>
      </div>
    </div>
