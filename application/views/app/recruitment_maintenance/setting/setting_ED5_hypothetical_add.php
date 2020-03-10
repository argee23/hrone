 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Add New Hypothetical Question</center></h4>
      </div>
     
      <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/ED5_save_hypothetical/<?php echo $company_id;?>">
      <div class="modal-body">
        <span class="dl-horizontal col-sm-12">
                  <div class="col-md-2">
                     <label class="pull-right">Question</label>
                  </div>
                  <div class="col-md-10">
                    <input type="text" name="type" id="type" value="<?php echo $type;?>">
                    <textarea  id="hquestion" name="hquestion" class="form-control" placeholder="Question" required>

                    </textarea>
                  </div>
        </span>

          <div class="modal-footer" >
            <div class="col-md-12"> 
               <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: 20px;">Close</button>
                <button type="submit" class="btn btn-success"  style="margin-top: 20px;">Save</button>
            </div>
          </div>
      </div>

      </form>

</div>

<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});


</script>
