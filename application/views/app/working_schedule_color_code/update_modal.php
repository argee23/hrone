 <div class="modal-content">
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Update Working Schedule Color Code Details</center></h4>
      </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/working_schedule_color_code/save_colorcode_update/<?php echo $id;?>" >
            
    <div class="col-sm-12">
        <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><i>All Fields are required </i></a></strong>
        </div>
        <div class="panel-body">
        <?php foreach($details as $d){?>
          <span class="dl-horizontal col-sm-11">
            <dt>Title</dt>
            <dd>
              <textarea class="form-control" rows="3" required name="title" <?php if($this->session->userdata('serttech_account')!="1"){ echo "readonly"; } ?>><?php echo $d->title;?></textarea>
            </dd><br>
            <dt>Description</dt>
            <dd>
              <textarea class="form-control" rows="3" required name="description" <?php if($this->session->userdata('serttech_account')!="1"){ echo "readonly"; } ?>><?php echo $d->details;?></textarea>
            </dd><br>
            <dt>Color Code</dt>
            <dd>
              <input type="color" name="color" id="color" value="<?php echo $d->color_code;?>" class="form-control">
            </dd>

          </span>
        <?php } ?>
        </div>
        </div>    
    </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
      </div>
      </form>
      </div>

    </div>


<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>