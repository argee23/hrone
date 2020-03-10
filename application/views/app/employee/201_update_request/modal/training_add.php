 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>New Trainings and Seminars</center></h4>
      </div>
     
       <?php foreach ($training_add as $add) { 
            ?>
      <div class="modal-body">
      
         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><?php echo $add->training_title?> details</i></a>

         <?php if(empty($add->file_name)){?>
           <a type="button" class="btn btn-danger btn-xs pull-right" title="Download Certificate" disabled><i class="fa fa-download"></i>No Attached File</a> 

      <?php } else{?>
       <a href="<?php echo base_url(); ?>app/employee_201_profile/download_training_certificate/<?php echo $add->file_name; ?>"
              type="button" class="btn btn-danger btn-xs pull-right" title="Download Certificate" ><i class="fa fa-download"></i> Download Certificate</a>  
        <?php } ?>

        </strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">

           
                <div class="col-md-12">
                    <div class="col-md-6"><label>Training Type</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php echo $add->training_type ?></n>
                    </div>
                </div>

                 <div class="col-md-12">
                    <div class="col-md-6"><label>Sub Type</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php echo $add->sub_type ?></n>
                    </div>
                </div>

                 <div class="col-md-12">
                    <div class="col-md-6"><label>Title / Topic</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php echo $add->training_title ?></n>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="col-md-6"><label>Conducted By</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php echo $add->conducted_by ?></n>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="col-md-6"><label>Conducted_by_type</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php echo $add->conducted_by_type ?></n>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="col-md-6"><label>Purpose / Objective</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php echo $add->purpose;?></n>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="col-md-6"><label>Address</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php echo $add->training_address ?></n>
                    </div>
                </div>
                
                 <div class="col-md-12">
                    <div class="col-md-6"><label>Fee Type</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php echo $add->fee_type ?></n>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="col-md-6"><label>Fee Amount</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php if(empty($add->fee_amount)){} else{  echo number_format($add->fee_amount,2); } ?></n>
                    </div>
                </div>
               
                 <div class="col-md-12">
                    <div class="col-md-6"><label>Payment Status</label></div>
                    <div class="col-md-6"><n class='text-success'>
                     <?php echo $add->payment_status ?></n>
                    </div>
                </div>

               
                  
           </span>

            <?php if($add->fee_type=='company')
            {?>

           <span class="dl-horizontal col-sm-10">
                  <div class="col-md-12">
                        <div class="col-md-9" ><label>Required length of service to be totally shouldered by the company </label></div>
                        <div class="col-md-3"><n class='text-success'> 
                         <?php if(empty($add->monthsRequired) || $add->monthsRequired==0){ echo "No Months required"; } else { echo  $add->monthsRequired." Months"; } ?></n>
                        </div>
                    </div>
           </span>

           <?php } ?>


          <div class="col-md-12">
            <?php 

                    $dates = $this->employee_201_model->get_all_dates_updated($add->update_id);?>
              
                    <table class="table table-hover" style="background-color: white;">
                        <thead>
                            <tr class="danger">
                                <th>Date</th>
                                <th>Time From</th>
                                <th>Time In</th>
                                <th>Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(empty($dates)){?>

                            <tr>
                                <td colspan="3"><n class="text-danger"><center>No dates found.</center></n></td>
                               
                            </tr>

                        <?php } else{ foreach($dates as $d){?>

                            <tr>
                                <td><?php echo $d->date;?></td>
                                <td><?php echo $d->time_from;?></td>
                                <td><?php echo $d->time_to;?></td>
                                <td><?php echo $d->hours;?></td>
                            </tr>
                        <?php }}  ?>

                          <tr>
                              <td colspan="4"><n class="text-danger pull-right">Total Hours : <b><?php echo $add->total_hours;?></b></n></td>
                          </tr>
                        </tbody>
                    </table>

            </div>
        </div>
        </div>

      </div>
    

      <?php } ?>
     

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
      </div>

</div>
  
