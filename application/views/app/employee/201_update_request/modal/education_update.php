 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>New Educational Attainment</center></h4>
      </div>
     
       
      <div class="modal-body">
      

    <?php foreach ($educ_update as $upd) {
      if($upd->id==null){}else{  
      $employee_id = $this->employee_emp_prof_update_request_model->employee_id($upd->employee_info_id);
        $education = $this->employee_emp_prof_update_request_model->educ_data_one($upd->id,$employee_id);
            foreach ($education as $del) {
            ?>

         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $del->education_name?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>School Name:  </dt>
              <dd> <n class='text-success'>
                      <?php echo $del->school_name ?></n>
                      <br><n class='text-danger'>
                    <?php if(empty($upd->school_name)) {} else{ echo $upd->school_name; } ?></n></dd>


              <dt>School Address:  </dt>
              <dd> <n class='text-success'>
                      <?php  echo $del->school_address  ?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->school_address)) {} else{ echo $upd->school_address; } ?></n></dd>

              <dt>Date Start: </dt>
              <dd> <n class='text-success'>
                      <?php echo $del->date_start ?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->date_start)) {} else{ echo $upd->date_start; } ?></n></dd>

              <dt>Date End: </dt>
              <dd>  <?php  echo $del->date_end ?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->date_end)) {} else{ echo $upd->date_end; } ?></n></dd>

             
              <dt>Honors:</dt>
              <dd> <n class='text-success'>
                      <?php echo $del->honors ?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->honors)) {} else{ echo $upd->honors; } ?></n></dd>
              
              <?php if($del->education_type_id=='1' || $del->education_type_id==2)
                {}else{?>
                  <dt>Graduated: </dt>
                  <dd> <n class='text-success'>
                      <?php echo $del->course ?></n>
                      <br><n class='text-danger'>
                      <?php if(empty($upd->course)) {} else{ echo $upd->course; } ?></n></dd>
              <?php }?>
            
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
