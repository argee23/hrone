<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_bank" >
    <div class="box-body">

 

      <div class="form-group">
        <label for="bank_code" class="col-sm-2 control-label">Bank Code</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="bank_code" id="bank_code" placeholder="Bank Code" required>
        </div>
      </div>
      <div class="form-group">
        <label for="bank_name" class="col-sm-2 control-label">Bank Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name" required>
        </div>
      </div>
      <div class="form-group">
        <label for="account_no." class="col-sm-2 control-label">Account No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="account_no" id="account_no" placeholder="Account No." required>
        </div>
      </div>
      <div class="form-group">
        <label for="account_no." class="col-sm-2 control-label">Bank Company Code<i>(used for bankfile)</i></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="bank_company_code" id="bank_company_code" placeholder="Bank Company Code" >
        </div>
      </div>
      <div class="form-group">
        <label for="account_no." class="col-sm-2 control-label">Bank Batch Number<i>(used for bankfile)</i></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="bank_batch_number" id="bank_batch_number" placeholder="Bank Batch Number" >
        </div>
      </div>
          <button type="submit" onclick="loading()" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>