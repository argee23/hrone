<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_bank/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">

     <div class="form-group">
        <label for="bank_code" class="col-sm-2 control-label">Bank File</label>
          <div class="col-sm-10">
<?php
    if(!empty($bankFileList)){
      foreach($bankFileList as $b){
        if($b->id==$bank->bankdat_id){
          $sel="checked";
        }else{
          $sel="";
        }
        echo '<input type="radio" name="bankfile" value="'.$b->id.'" '.$sel.'>'.$b->bank_name.'  '.$b->bank_file_version.'<br>';
      }
    }else{

    }
?>
        </div>
        </div>
      </div>


      <div class="form-group">
        <label for="bank_code" class="col-sm-2 control-label">Bank Code</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="bank_code" id="bank_code" placeholder="Bank Code" value="<?php echo $bank->bank_code?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="bank_name" class="col-sm-2 control-label">Bank Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name" value="<?php echo $bank->bank_name?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="account_no." class="col-sm-2 control-label">Account No.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="account_no" id="account_no" placeholder="Account No." value="<?php echo $bank->account_no?>" required>
        </div>
      </div>

      <div class="form-group">
        <label for="account_no." class="col-sm-2 control-label">Bank Company Code<i>(used for bankfile)</i></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="bank_company_code" id="bank_company_code" placeholder="Bank Company Code" value="<?php echo $bank->bank_company_code?>">
        </div>
      </div>
      <div class="form-group">
        <label for="account_no." class="col-sm-2 control-label">Bank Batch Number<i>(used for bankfile)</i></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="bank_batch_number" id="bank_batch_number" placeholder="Bank Batch Number" value="<?php echo $bank->bank_batch_number?>">
        </div>
      </div>

          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>