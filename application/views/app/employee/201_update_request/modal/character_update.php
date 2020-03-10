 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Update Character Reference</center></h4>
      </div>
     
       
      <div class="modal-body">
      

         <?php foreach ($character_update as $upd) { 
           $character = $this->employee_emp_prof_update_request_model->empcharacter_data_one($upd->id,$upd->employee_info_id);
                foreach ($character as $orig) {
            ?>


         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $orig->reference_name?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>Reference Name:  </dt>
              <dd><n class='text-success'>
                      <?php echo $orig->reference_name?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->reference_name)) {} else{ echo $upd->reference_name; } ?></n></dd>

              <dt>Reference Company:  </dt>
              <dd><n class='text-success'>
                      <?php echo $orig->reference_company?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->reference_company)) {} else{ echo $upd->reference_company; } ?></n></dd>

              <dt>Reference Position:  </dt>
              <dd> <n class='text-success'>
                      <?php  echo $orig->reference_position?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->reference_position)) {} else{ echo $upd->reference_position; } ?></n></dd>

              <dt>Reference Address </dt>
              <dd> <n class='text-success'>
                      <?php echo $orig->reference_address ?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->reference_address)) {} else{ echo $upd->reference_position; } ?></n></dd>

              <dt>Reference Email:  </dt>
              <dd>  <n class='text-success'>
                     <?php echo $orig->reference_email ?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->reference_email)) {} else{ echo $upd->reference_email; } ?></n></dd>

              <dt>Reference Contact:  </dt>
              <dd><n class='text-success'>
                      <?php echo $orig->reference_contact; ?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->reference_contact)) {} else{ echo $upd->reference_contact; } ?></n></dd>

             </span>
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
