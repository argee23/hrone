 <div class="modal-content">
      <div class="modal-header well well-sm bg-olive" >
      <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-success" style="color: white;"><center><b><?php echo $job_details->company_name;?></center></b></h4>
        <h5><center><?php echo $job_details->job_title;?></center> </h5>
      </div>

     <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/application_forms/save_requirements_applicant/<?php echo $job_id."/".$applicant_id."/".$app_id;?>">
      
      <div class="modal-body">
          <div class="col-md-12">
          <?php if(empty($req)){ echo "<h3 class='text-danger'><center>No Requirement/s found . . </center></h3>";}
          else{?>
          <table class="col-md-12 table table-bordered">
              <thead>
                <tr class="danger"> 
                  <th>Requirement</th>
                  <th>Status</th>
                  <th>Employer Comment</th>
                  <th>File</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php $i=1; foreach ($req as $r) {
                $req_res = $this->application_forms_model->check_requirement_status($r->idd,$applicant_id,$job_id);
              
               ?>
                <tr>
                  <td><?php echo $r->title;?></td>
                  <td>
                    <?php 

                        if(!empty($req_res->status) AND $req_res->status==1)
                          { 
                              echo "approved";
                          } 

                        else
                          { 
                              echo "pending"; 
                          } 
                    ?>
                  </td>
                  <td><?php if(empty($r->comment)){ echo "no comment yet"; } else{ echo $r->comment; } ?></td>
                  <td>
                    <?php if(empty($req_res->file)) { echo "no file yet"; } else { ?>
                           <a href="<?php echo base_url(); ?>app/application_forms/download_requirements/<?php echo $req_res->file; ?>"
                           title="Download File" ><?php echo $req_res->file;?></a> 
                        <?php } ?>
                  </td>
                  <td>
                    <?php if($r->IsUploadable==1)
                    {?>
                      <input type="file" name="file<?php echo $r->id;?>" value="<?php if(!empty($req_res->file)){ echo $req_res->file; }?>" <?php if(!empty($req_res->status) AND !empty($req_res->file) AND $req_res->status==1){ echo "style='display:none';"; } ?> >
                      <?php if(!empty($req_res->status) AND $req_res->status==1){ if(!empty($req_res->file)) { echo "file uploaded is already approved";  } else{} }?>
                    <?php } else{ echo "not uploadable"; } ?>
                  </td>
                </tr>
              <?php $i++; } echo "<input type='hidden' name='req_count' value='".$i."'>"; ?>
              </tbody>
          </table>
          <?php } ?>

          </div>

          </div>

          <div class="modal-footer">
          <?php if(empty($req)){}
          else{?>
            <button type="submit" class="btn btn-success" >Submit</button>
          <?php }?>
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
          </div>
      </form>
  </div>
  
