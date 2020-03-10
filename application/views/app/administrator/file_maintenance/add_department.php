<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_department" >
    <div class="box-body">
      <div class="form-group">
        <div class="col-md-12">
          <h4> Add Department </h4>
          <label>Select:</label>
          <select class="form-control select2" name="select" id="select" required="required" onchange="getCompSel(this.value)">
          <option value="" selected="selected" disabled="disabled"> - Select - </option>
          <option value="0"> Companies With Division </option>
          <option value="1"> Companies Without Division </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div id="foreground"></div>
      </div>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>