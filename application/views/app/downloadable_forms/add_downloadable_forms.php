 <div class="modal-content">
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Add New Downloadable Form</center></h4>
      </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/downloadable_forms/save_downloadable_forms/<?php echo $company;?>" >
            

             <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><i>Accepted Files:jpg,jpeg,png,gif,pdf,xls,xlsx,docx,txt,doc,ppt,pptx </i></a></strong>
        </div>
        <div class="panel-body">
          <span class="dl-horizontal col-sm-11">
            <dt>File Title</dt>
            <dd>
              <textarea class="form-control" rows="3" required name="title"></textarea>
            </dd><br>
            <dt>File Description</dt>
            <dd>
              <textarea class="form-control" rows="3" required name="description"></textarea>
            </dd><br>
            <dt>Upload File</dt>
            <dd>
             <input type="file" name="file" id="file" required>
            </dd>

          </span>
        </div>
        </div>    

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
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