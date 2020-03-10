 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Update Skill/s</center></h4>
      </div>
     
      <div class="modal-body">
      
         <?php foreach ($skills_update as $upd) { 
            $skills = $this->employee_emp_prof_update_request_model->skills_data_one($upd->id,$upd->employee_info_id);
            foreach ($skills as $orig) {
            ?>

         <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                        <a class="text-danger"><b><?php echo $orig->skill_name?></b></a>
                      
                </strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">
              
              <dt>Skill Name:  </dt>
              <dd> <n class='text-success'>
                      <?php  echo $orig->skill_name;  ?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->skill_name)) {} else{ echo $upd->skill_name; } ?></n></dd>
              
              
              <dt>Skill Description:  </dt>
              <dd> <n class='text-success'>
                      <?php  echo $orig->skill_description;  ?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->skill_description)) {} else{ echo $upd->skill_description; } ?></n></dd>
              
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
