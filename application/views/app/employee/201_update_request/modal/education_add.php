 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>New Educational Attainment</center></h4>
      </div>
     
       
      <div class="modal-body">
      

        <?php foreach ($educ_add as $add) { 
          $education_type = $this->employee_emp_prof_update_request_model->education_type($add->education_type_id); 
        ?>
           


         <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a class="text-danger"><b><?php echo $education_type?></b></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>School Name:  </dt>
              <dd> <?php echo $add->school_name ?></dd>


              <dt>School Address:  </dt>
              <dd> <?php  echo $add->school_address  ?></dd>

              <dt>Date Start: </dt>
              <dd>  <?php echo $add->date_start ?></dd>

              <dt>Date End: </dt>
              <dd> <?php  echo $add->date_end ?></dd>

             
              <dt>Honors:</dt>
              <dd> <?php echo $add->honors ?></dd>
              
              <?php if($add->education_type_id=='1' || $add->education_type_id==2)
                {}else{?>
                  <dt>Graduated: </dt>
                  <dd> <?php if($add->isGraduated==1){ echo 'No'; } else{ echo 'Yes';}?></dd>
              <?php }?>
            
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
