
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_taxcode/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label for="taxcode" class="col-sm-2 control-label">Tax Code</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="taxcode" id="taxcode" placeholder="Tax Code" value="<?php echo $taxcode->taxcode;?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php echo $taxcode->description;?>">
        </div>
      </div>
          <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>