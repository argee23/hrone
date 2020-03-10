 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Delete Character Reference</center></h4>
      </div>
     
       
      <div class="modal-body">
      

        <?php foreach ($character_delete as $upd) { 
                $training = $this->employee_emp_prof_update_request_model->empcharacter_data_one($upd->id,$upd->employee_id);
                foreach ($training as $del) {
            ?>


         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $del->reference_name?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>Reference Company:  </dt>
              <dd>  <?php echo $del->reference_company?></dd>

              <dt>Reference Position:  </dt>
              <dd> <?php  echo $del->reference_position?></dd>

              <dt>Reference Address </dt>
              <dd> <?php echo $del->reference_address ?></dd>

              <dt>Reference Email:  </dt>
              <dd>  <?php echo $del->reference_email ?>></dd>

              <dt>Reference Contact:  </dt>
              <dd> <?php echo $del->reference_contact; ?></dd>

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
