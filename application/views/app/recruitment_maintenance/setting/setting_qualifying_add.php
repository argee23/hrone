 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Add New Company Application Status</center></h4>
      </div>
     
      <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment_hris/ED2_save_new_status_position/<?php echo $company_id;?>">
      <div class="modal-body">
        <span class="dl-horizontal col-sm-12">
            

                                  <div class="col-md-12">
                                      <div class="col-md-4">
                                        <label class="pull-right">Question</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" id="qquestion" class="form-control" placeholder="Question">
                                          <input type="hidden" id="qquestion_">
                                      </div>
                                  </div>

                                  <div class="col-md-12" style="margin-top: 5px;">
                                      <div class="col-md-4">
                                        <label class="pull-right">Correct Answer?</label>
                                      </div>
                                      <div class="col-md-6">
                                        <input type="radio" value="1" name="qquestion" onclick="allow_upload('1','qquestion_ans','qquestion')" checked> Yes
                                        <input type="radio" value="0"  name="qquestion" value="0" onclick="allow_upload('0','qquestion_ans','qquestion')">  No
                                        <input type="hidden" id="qquestion_ans" value='1' name="qquestion_ans">
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
