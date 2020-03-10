  <div class="modal-dialog">
 <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center></center></h4>
        
        <h4> <n class="text-danger"><i class="glyphicon glyphicon-certificate"></i><b>Delete Dependents</b></n></h4>
      </div>
        <div class="modal-body"><center>
        <p>Are you sure you want to delete the selected dependent record?</p>
        <form name="delete_family" method="post" action="delete_dependent">
        <input type="hidden" value="<?php echo $dependent_id?>" name="id" id="id">
        <button type="submit" class=" btn btn-warning">Yes</button>
        <button type="button" data-dismiss="modal" class="btn btn-info">No</button>
        </form>
        </center>
      </div>
         </div>
      </div>
    </div>
</div>
    
<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});


</script>