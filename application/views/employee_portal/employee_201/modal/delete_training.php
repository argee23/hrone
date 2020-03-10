 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Delete Trainings and Seminar</center></h4>
      </div>
    
      <div class="modal-body">
      
       
        <div class="panel-body">
              <form name="delete_training" method="post" action="delete_training">
          <input type="hidden" value="<?php echo $training_id?>" name="id" id="id">
         <center><h4 class="text-danger">Are you sure you want to delete training id <?php echo $training_id;?>?</h4></center>
         <center> <button type="submit" class=" btn btn-warning">Yes</button>
          <button type="button" data-dismiss="modal" class="btn btn-info">No</button></center>
          </form>

        </div>
      </div>
</div>