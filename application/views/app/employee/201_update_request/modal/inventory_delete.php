 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Delete Inventory</center></h4>
      </div>
     
      <div class="modal-body">
      
            <?php foreach ($inventory_delete as $upd) {
              $inventory = $this->employee_emp_prof_update_request_model->inventory_data_one($upd->id,$upd->employee_id);
                foreach ($inventory as $del) {
            ?>
         <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                        <a class="text-danger"><b><?php echo $del->inventory_name?></b></a>
                      
                </strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-10">
              <dt>File:  </dt>
              <dd> <?php  echo $del->file;  ?></dd>

              <dt>Comment:  </dt>
              <dd> <?php if(empty($del->comment)){ echo "no comment"; } else{ echo $del->comment; }?></dd>

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
