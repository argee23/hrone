 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>New Dependents</center></h4>
      </div>
     
       
      <div class="modal-body">
      

       <?php foreach ($dependents_add as $add) { 
            $relationship= $this->employee_emp_prof_update_request_model->Relationship($add->relationship); 
            $gender= $this->employee_emp_prof_update_request_model->gender_civil('gender',$add->gender,'gender_id','gender_name');
            $civil= $this->employee_emp_prof_update_request_model->gender_civil('civil_status',$add->civil_status,'civil_status_id','civil_status');
            ?>


         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $add->first_name." ".$add->last_name?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>First Name:   </dt>
              <dd><?php  echo $add->first_name;  ?></dd>

              <dt>Middle Name:  </dt>
              <dd><?php echo $add->middle_name; ?></dd>

              <dt>Last Name:  </dt>
              <dd> <?php  echo $add->last_name; ?></dd>

              <dt>Name Extension:  </dt>
              <dd>  <?php  echo $add->name_ext;  ?></dd>

              <dt>Gender:  </dt>
              <dd>  <?php  echo $gender; ?></dd>

              <dt>Civil Status: </dt>
              <dd><?php  echo $civil; ?></dd>

              <dt>Relationship:  </dt>
              <dd> <?php  echo $relationship; ?></dd>


             </span>
             </div>
        </div>

       
      <?php } ?>

      

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
