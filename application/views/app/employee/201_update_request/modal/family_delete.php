 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Delete Family Data</center></h4>
      </div>
     
      <?php foreach ($family_delete as $upd) { 
            $family = $this->employee_emp_prof_update_request_model->fam_data_one($upd->id);
            foreach ($family as $org) {
           $relationship = $this->employee_emp_prof_update_request_model->Relationship($org->relationship); 
       ?>

      <div class="modal-body">
         <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><b><?php echo $org->name?></b></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-10">
            
              <dt>Name: </dt>
              <dd> <?php if(empty($upd->name)) {} else{ echo $upd->name; } ?></dd>


              <dt>Occupation: </dt>
              <dd>  <?php  echo $org->occupation;  ?></dd>

              <dt>Age: </dt>
              <dd> <?php  echo $org->age;  ?></dd>

              <dt>Contact Number: </dt>
              <dd> <?php  echo $org->contact_no;  ?></dd>

              <?php if($org->relationship==72){?>
              <dt>Date of Marriage:</dt>
              <dd>  <?php echo $org->date_of_marriage;  ?></dd>
              <?php } ?>

              <dt>Relationship: </dt>
              <dd> <?php  echo $relationship;  ?></dd>


          </span>
        </div>
        </div>

    <?php }  }?> 
    
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
      </div>
      </div>

</div>
  
<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>