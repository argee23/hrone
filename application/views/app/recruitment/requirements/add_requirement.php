<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/save_requirement" >
    <div class="box-body">
      <div class="form-group">
        <label for="item_name" class="col-sm-2 control-label">Item Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Item Name" required>
        </div>
      </div>

      <div class="form-group">
        <label for="IsUploadable" class="col-sm-2 control-label">Allow File Upload?</label>
        <div class="col-sm-10">
            <input type="radio" name="IsUploadable" value="1" required> Yes &nbsp;
            <input type="radio" name="IsUploadable" value="0"> No<br>
        </div>
      </div>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>
