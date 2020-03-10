 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Update Inventory</center></h4>
      </div>
     
      <div class="modal-body">
      
            <?php foreach ($inventory_update as $upd) {
                  $inventory = $this->employee_emp_prof_update_request_model->inventory_data_one($upd->id,$upd->employee_id);
                    foreach ($inventory as $orig) {
            ?>
         <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                        <a class="text-danger"><b><?php echo $orig->inventory_name?></b></a>
                      
                </strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">

              <dt>Inventory Name:  </dt>
              <dd><n class='text-success'>
                      <?php  echo $orig->file;  ?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->inventory_name)) {} else{ echo $upd->inventory_name; } ?></n></dd>

              <dt>File:  </dt>
              <dd> <n class='text-success'>
                      <?php  echo $orig->file;  ?></n>
                       <br><n class='text-danger'>
                      <?php if(empty($upd->file)) {} else{ echo $upd->file; } ?></n></dd>

              <dt>Comment:  </dt>
              <dd> <n class='text-success'>
                      <?php echo $orig->comment; ?></n>
                        <br><n class='text-danger'>
                      <?php if(empty($upd->comment)) {} else{ echo $upd->comment; } ?></n></dd>

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
