 <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title text-success"><b><center>Upload <?php echo $details->title;?></center></b></h4>
      </div>
     <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>recruitment_employer/recruitment_employer_management/employer_requirement_save/" >
      <div class="modal-body">
      <input type="hidden" name="id"  value="<?php echo $id;?>">
      <input type="hidden" name="requirement_id"  value="<?php echo $requirement_id;?>">
      <input type="hidden" name="req_id"  value="<?php echo $req_id;?>">
      <input type="hidden" name="company_id"  value="<?php echo $company_id;?>">
      <input type="hidden" name="type"  value="<?php echo $type;?>">
         <div class="col-md-12 form-group">
            <center>  <div class="btn btn-info">
                <input type="file" name="file" id="file" required>
              </div>
              <p>Allowed file type jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc.</p>
              <p style="color:#ff0000;">Requirement file is required</p>
              </div>
            </center>
        </div>
      <div class="modal-footer">
       <button type="submit" class="btn btn-success">Submit</button>
       </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>