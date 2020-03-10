 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Add New Company Application Status</center></h4>
      </div>
     
      <form class="form-horizontal" method="post" action="<?php echo base_url()?>recruitment_employer/recruitment_employer_management/save_new_status_position/<?php echo $company_id."/".$type."/".$account;?>">
      <div class="modal-body">
        <span class="dl-horizontal col-sm-12">
          <div class="col-md-12">
              <div class="col-md-4">
                <label>Application Status Title</label>
              </div>
              <div class="col-md-8">
                <textarea class="form-control" rows="3" required name="title"></textarea>
              </div>
          </div>

           <div class="col-md-12" style="margin-top:10px;">
             <div class="col-md-4">
                <label>Description</label>
              </div>
              <div class="col-md-8">
                <textarea class="form-control" rows="3" required name="description"></textarea>
              </div>
          </div>

           <div class="col-md-12" style="margin-top:10px;">
             <div class="col-md-4">
                <label>Color Code</label>
              </div>
              <div class="col-md-8">
                <input type="color" class="form-control" required name="color">
              </div>
          </div>
        </span>

          <div class="modal-footer" >
               <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 20px;">Close</button>
                <button type="submit" class="btn btn-success"  style="margin-top: 20px;">Save</button>
          </div>
      </div>

      </form>

</div>

<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>
