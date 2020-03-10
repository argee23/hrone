 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Delete Educational Attainment</center></h4>
      </div>
     
       
      <div class="modal-body">
      

       <?php foreach ($educ_delete as $upd) { 
            $education = $this->employee_emp_prof_update_request_model->educ_data_one($upd->id,$upd->employee_id);
            foreach ($education as $del) {
            
            ?>
           


         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $del->education_name?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>School Name:  </dt>
              <dd> <?php echo $del->school_name ?></dd>


              <dt>School Address:  </dt>
              <dd> <?php  echo $del->school_address  ?></dd>

              <dt>Date Start: </dt>
              <dd>  <?php echo $del->date_start ?></dd>

              <dt>Date End: </dt>
              <dd> <?php  echo $del->date_end ?></dd>

             
              <dt>Honors:</dt>
              <dd> <?php echo $del->honors ?></dd>
              
              <?php if($del->education_type_id=='1' || $del->education_type_id==2)
                {}else{?>
                  <dt>Graduated: </dt>
                  <dd> <?php if($del->isGraduated==1){ echo 'No'; } else{ echo 'Yes';}?></dd>
              <?php }?>
            
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
