 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Delete Trainings and Seminars</center></h4>
      </div>
     
       
      <div class="modal-body">
      

       <?php foreach ($training_delete as $upd) { 
            $training = $this->employee_emp_prof_update_request_model->emptraining_data_one($upd->id,$upd->employee_id);
            foreach ($training as $del) {
            ?>
           


         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $del->training_title?></b></a></strong>

                 <?php if(empty($del->file_name)){?>
                  <button type="button" class="btn btn-danger pull-right" disabled>No Attached File</button>
                <?php } else{?>
                 <a href="<?php echo base_url(); ?>app/employee_201_profile/download_training_certificate/<?php echo $del->file_name; ?>"
                        type="button" class="btn btn-danger btn-xs pull-right" title="Download Certificate" ><i class="fa fa-download"></i> Download Certificate</a>  
                  <?php } ?>



            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

                <dt>Training Type</dt>
                <dd><?php echo $del->training_type;?></dd>

                <dt>Sub Type:</dt>
                <dd><?php echo $del->sub_type;?></dd>

                <dt>Training/Seminar Title:</dt>
                <dd><?php echo $del->sub_type;?></dd>

                 <dt>Conducted By:</dt>
                 <dd><?php echo $del->conducted_by;?></dd>

                 <dt>Conducted By Type:</dt>
                 <dd><?php echo $del->conducted_by_type;?></dd>

                 <dt>Purpose / Objective:</dt>
                 <dd><?php echo $del->purpose;?></dd>

                 <dt>Address Conducted:</dt>
                 <dd><?php echo $del->training_address;?></dd>

                  <dt>Fee Type:</dt>
                 <dd><?php echo $del->fee_type;?></dd>

                 <?php if($del->fee_type=='employee'){?>
                  <dt>Fee Amount:</dt>
                 <dd><?php echo $del->fee_amount;?></dd>

                  <dt>Payment Amount Given: </dt>
                  <dd><?php echo $del->payment_amount_given;?></dd>
                  
                  <dt>Payment Status: </dt>
                  <dd><?php echo $del->payment_status;?></dd>

                  <?php } ?>
             </span>

             <div class="col-md-12" style="margin-top: 20px;">


                 <?php 
                   $dates = $this->employee_201_profile_model->get_all_dates($del->training_seminar_id);   
                ?>
                                  <table class="table table-hover"   style="background-color:white; ">
                                      <thead>
                                          <tr class="success" style="color:black;"> 
                                              <th  >Date</th>
                                              <th>Time From</th>
                                              <th>Time To</th>
                                              <th>Hours</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      <?php foreach($dates as $updss) { ?>


                                          <tr class="text-danger">
                                              <td><?php echo $updss->date;?></td>
                                              <td><?php echo $updss->time_from;?></td>
                                              <td><?php echo $updss->time_to;?></td>
                                              <td><?php echo $updss->hours;?></td>
                                          </tr>

                                      <?php  }   ?>
                                      </tbody>
                                  </table>


             </div>

             </div>
        </div>

       
      <?php } } ?>

      

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
