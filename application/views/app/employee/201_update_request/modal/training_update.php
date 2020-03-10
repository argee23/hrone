 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Update Trainings and Seminar</center></h4>
      </div>
     
       
      <div class="modal-body">
      

       <?php foreach ($training_update as $upd) { 
        if($upd->id==null){}else{ 
          $employee_id = $this->employee_emp_prof_update_request_model->employee_id($upd->employee_info_id);
          $training = $this->employee_emp_prof_update_request_model->emptraining_data_one($upd->id,$employee_id);
            foreach ($training as $orig) {
            ?>


         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $orig->training_title?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

            
                <dt>Training Type</dt>
                <dd><n class='text-success'>
                      <?php echo $orig->training_type?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->training_type)) {} else{ echo $upd->training_type; } ?></n></dd>

                <dt>Sub Type:</dt>
                <dd><n class='text-success'>
                      <?php echo $orig->sub_type?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->sub_type)) {} else{ echo $upd->sub_type; } ?></n></dd>

                <dt>Training/Seminar Title:</dt>
                <dd><n class='text-success'>
                      <?php echo $orig->training_title?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->training_title)) {} else{ echo $upd->training_title; } ?></n></dd>

                 <dt>Conducted By:</dt>
                 <dd><n class='text-success'>
                      <?php  echo $orig->conducted_by?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->conducted_by)) {} else{ echo $upd->conducted_by; } ?></n></dd>

                 <dt>Conducted By Type:</dt>
                 <dd><n class='text-success'>
                      <?php  echo $orig->conducted_by_type?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->conducted_by_type)) {} else{ echo $upd->conducted_by_type; } ?></n></dd>

                 <dt>Purpose / Objective:</dt>
                 <dd><n class='text-success'>
                      <?php echo $orig->purpose?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->purpose)) {} else{ echo $upd->purpose; } ?></n></dd>

                 <dt>Address Conducted:</dt>
                 <dd><n class='text-success'>
                      <?php echo $orig->training_address?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->training_address)) {} else{ echo $upd->training_address; } ?></n></dd>

                  <dt>Fee Type:</dt>
                 <dd><n class='text-success'>
                      <?php echo $orig->fee_type ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->fee_type)) {} else{ echo $upd->fee_type; } ?></n></dd>

                
                  <dt>Fee Amount:</dt>
                 <dd><n class='text-success'>
                      <?php if(empty($orig->fee_amount)){} else { echo number_format($orig->fee_amount,2); }  ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->fee_amount)) {} else{ echo number_format($upd->fee_amount,2); } ?></n></dd>

                 
                  <dt>Payment Status: </dt>
                  <dd><n class='text-success'>
                      <?php echo $orig->payment_status ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->payment_status)) {} else{ echo $upd->payment_status; } ?></n></dd>

                  

                  <dt>File Attachment: </dt>
                  <dd><n class='text-success'> <?php echo $orig->file_name ?></n>
                        <br><n class='text-danger'>

                        <?php if(empty($orig->file_name)){ echo "No attached file"; } else{  ?>  <a href="<?php echo base_url(); ?>app/employee_201_profile/download_training_certificate/<?php echo $orig->file_name; ?>"
              type="button" class="btn btn-success btn-xs" title="Download Certificate" ><i class="fa fa-download"></i> Download Original Certificate</a>  <?php } ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->file_name)) {} else{ if(empty($upd->file_name)) { echo "No updated attached file"; } else{ ?>
                           <a href="<?php echo base_url(); ?>app/employee_201_profile/download_training_certificate/<?php echo $upd->file_name; ?>"
                          type="button" class="btn btn-success btn-xs" title="Download Certificate"  style='margin-top: 5px;'><i class="fa fa-download"></i> Download Updated Certificate</a>
                        <?php  }} ?></n>
                  </dd>
             </span>

              <?php if($orig->fee_type=='company')
                {?>

               <span class="dl-horizontal col-sm-10">
                      <div class="col-md-12">
                            <div class="col-md-9" ><label>Required length of service to be totally shouldered by the company </label></div>
                            <div class="col-md-3">
                            <n class='text-success'> 
                             <?php if(empty($orig->monthsRequired) || $orig->monthsRequired==0){ echo "No Months required"; } else { echo  $orig->monthsRequired." Months"; } ?>
                            </n>
                            <n class='text-danger'> 
                             <?php if(empty($upd->monthsRequired)){} else{ if($upd->monthsRequired==0){ echo "No Months required"; }  else{  echo  $upd->monthsRequired." Months"; } }?>
                             </n>
                            </div>
                        </div>
               </span>

              <?php } 
              else { ?>

                <span class="dl-horizontal col-sm-10">
                      <div class="col-md-12">
                            <div class="col-md-9" ><label>Required length of service to be totally shouldered by the company </label></div>
                            <div class="col-md-3">
                            <n class='text-danger'> 
                             <?php if(empty($upd->monthsRequired)){} else{ if($upd->monthsRequired==0){ echo "No Months required"; }  else{  echo  $upd->monthsRequired." Months"; } }?>
                             </n>
                            </div>
                        </div>
               </span>

              <?php } ?>



             <div class="col-sm-12" style="margin-top: 20px;">
              <?php 
                   $dates = $this->employee_201_profile_model->get_all_dates($upd->id);  
                   $dates_upd = $this->employee_201_model->get_date_upd($upd->id);  
                ?>
                                  <table class="table table-hover"   style="background-color:white;">
                                      <thead>
                                          <tr class="success" style="color:black;"> 
                                              <th  >Date</th>
                                              <th>Time From</th>
                                              <th>Time To</th>
                                              <th>Hours</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      
                                      <?php if(!empty($dates_upd))
                                      { foreach($dates_upd as $upds) {
                                      ?>

                                          <tr class="text-danger">
                                              <td><?php echo $upds->date;?></td>
                                              <td><?php echo $upds->time_from;?></td>
                                              <td><?php echo $upds->time_to;?></td>
                                              <td><?php echo $upds->hours;?></td>
                                          </tr>


                                      <?php }  } else { foreach($dates as $updss) { ?>


                                          <tr class="text-danger">
                                              <td><?php echo $updss->date;?></td>
                                              <td><?php echo $updss->time_from;?></td>
                                              <td><?php echo $updss->time_to;?></td>
                                              <td><?php echo $updss->hours;?></td>
                                          </tr>

                                      <?php  } }  ?>
                                      </tbody>
                                  </table>
            </div>
             </div>
        </div>

       
       <?php }  }}?>  

      

        <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>



</div>

<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>
