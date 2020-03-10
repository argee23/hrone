
<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_paytype/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label for="paytype" class="col-sm-2 control-label">Pay Type</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="paytype" id="paytype" placeholder="Pay Type" value="<?php echo $pay_type->pay_type_name;?>" required>
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>