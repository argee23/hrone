 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>New Family Data</center></h4>
      </div>
     
       
      <div class="modal-body">
      

        <?php 
            foreach ($family_add as $upd) { 
            $relationship_upd= $this->employee_emp_prof_update_request_model->Relationship($upd->relationship); 
        ?>


         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $upd->name?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>Name: </dt>
              <dd> <?php  echo $upd->name;  ?></dd>


              <dt>Occupation: </dt>
              <dd>  <?php  echo $upd->occupation;  ?></dd>

              <dt>Age: </dt>
              <dd> <?php  echo $upd->age;  ?></dd>

              <dt>Contact Number: </dt>
              <dd> <?php  echo $upd->contact_no;  ?></dd>

              <?php if($upd->relationship==72){?>
              <dt>Date of Marriage:</dt>
              <dd>  <?php echo $upd->date_of_marriage;  ?></dd>
              <?php } ?>

              <dt>Relationship: </dt>
              <dd> <?php  echo $relationship_upd;  ?></dd>

            
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
