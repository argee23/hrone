 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Update Dependents</center></h4>
      </div>
     
       
      <div class="modal-body">
      

      <?php foreach ($dependents_update as $upd) { 
            $dependents = $this->employee_emp_prof_update_request_model->empdependents_one($upd->id,$upd->employee_id);
                foreach ($dependents as $orig) {
                $relationship= $this->employee_emp_prof_update_request_model->Relationship($orig->relationship); 
                $gender= $this->employee_emp_prof_update_request_model->gender_civil('gender',$orig->gender,'gender_id','gender_name');
                $civil= $this->employee_emp_prof_update_request_model->gender_civil('civil_status',$orig->civil_status,'civil_status_id','gender_name');

                $urelationship= $this->employee_emp_prof_update_request_model->Relationship($upd->relationship); 
                $ugender= $this->employee_emp_prof_update_request_model->gender_civil('gender',$upd->gender,'gender_id','gender_name');
                $ucivil= $this->employee_emp_prof_update_request_model->gender_civil('civil_status',$upd->civil_status,'civil_status_id','gender_name');

            ?>

         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $orig->first_name." ".$orig->last_name?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>First Name:   </dt>
              <dd><n class='text-success'>
                      <?php  echo $orig->first_name; ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->first_name)) {} else{ echo $upd->first_name; } ?></n></dd>

              <dt>Middle Name:  </dt>
              <dd><n class='text-success'>
                      <?php echo $orig->middle_name; ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->middle_name)) {} else{ echo $upd->middle_name; } ?></n></dd>

              <dt>Last Name:  </dt>
              <dd> <n class='text-success'>
                      <?php  echo $orig->last_name; ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->last_name)) {} else{ echo $upd->last_name; } ?></n></dd>

              <dt>Name Extension:  </dt>
              <dd> <n class='text-success'>
                      <?php  echo $orig->name_ext;  ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->name_ext)) {} else{ echo $upd->name_ext; } ?></n></dd>

              <dt>Gender:  </dt>
              <dd> <n class='text-success'>
                      <?php  echo $gender; ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($ugender)) {} else{ echo $ugender; } ?></n></dd>

              <dt>Civil Status: </dt>
              <dd><n class='text-success'>
                       <?php  echo $civil; ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($ucivil)) {} else{ echo $ucivil; } ?></n></dd>

              <dt>Relationship:  </dt>
              <dd><n class='text-success'>
                      <?php  echo $relationship; ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($urelationship)) {} else{ echo $urelationship; } ?></n></dd>


             </span>
             </div>
        </div>

         <?php }  }?> 

      

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
