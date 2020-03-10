 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Update Working Experience</center></h4>
      </div>
     
       
      <div class="modal-body">
      

        <?php foreach ($work_update as $upd) {
              if($upd->id==null){}else{ 
              $work = $this->employee_emp_prof_update_request_model->empwork_data_one($upd->id,$upd->employee_info_id);
                  foreach ($work as $orig) {
            ?>

         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $orig->company_name?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

               <dt>Company Name:  </dt>
               <dd> <n class='text-success'>
                      <?php echo $orig->company_name ?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->company_name)) {} else{ echo $upd->company_name; } ?></n></dd>

             
              <dt>Company Address:  </dt>
              <dd><n class='text-success'>
                      <?php echo $orig->company_address ?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->company_address)) {} else{ echo $upd->company_address; } ?></n></dd>

              <dt>Company Contact:  </dt>
              <dd> <n class='text-success'>
                      <?php echo $orig->company_contact ?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->company_contact)) {} else{ echo $upd->company_contact; } ?></n></dd>

              <dt>Reason of Leaving:  </dt>
              <dd> <n class='text-success'>
                      <?php  echo $orig->reason_for_leaving?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->reason_for_leaving)) {} else{ echo $upd->reason_for_leaving; } ?></n></dd>

              <dt>Job Description:  </dt>
              <dd><n class='text-success'>
                      <?php echo $orig->job_description ?>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->job_description)) {} else{ echo $upd->job_description; } ?></n></dd>

              <dt>Work Duration:  </dt>
              <dd><n class='text-success'>
                      <?php if($orig->isPresentWork==0){ echo $orig->date_start." to ".$orig->date_end; } else{ echo $orig->date_start." to Present"; } ?></n>
                    <?php if($upd->isPresentWork==0){ echo $upd->date_start." to ".$upd->date_end; } else{ echo $upd->date_start." to Present"; } ?></n></dd>

              <dt>Salary:  </dt>
              <dd><n class='text-success'>
                      <?php echo number_format($orig->salary,2) ?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->salary)) {} else{ echo number_format($upd->salary,2); } ?></n></dd>


             </span>
             </div>
        </div>

       
       <?php } } }?>  

      

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
