<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>
<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header">AUTHORITY TO DEDUCT FORM</h4>
  <hr>
  <?php  if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
          <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>

          <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
       </div>

  <?php } else { ?>

      <form class="form-horizontal" name="add_med_re" method="post"  enctype="multipart/form-data" action="add_authority_to_deduct" onsubmit="document.getElementById('smbt').disabled=true;">

          <div class="form-group">
        <label class="control-label col-sm-4" for="email"> Advance Type</label>
        <div class="col-sm-8">
        <select class="form-control" name="type_of_advance" id="type_of_advance" required>
        <?php foreach ($advanceTypes as $type)
        { ?>
          <option value="<?php echo $type->id; ?>"><?php echo ucwords($type->advance_type); ?></option>
        <?php } ?>
        </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-4" for="email"> Advance Amount</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="amount_of_advance" name="amount_of_advance" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false" required>
        </div>
      </div>

        <div class="form-group">
        <label class="control-label col-sm-4" for="email"> Monthly Amortization</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="monthly_amortization" name="monthly_amortization" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false" required>
        </div>
      </div>

        <div class="form-group">
        <label class="control-label col-sm-4" for="email"> Deduction Start Date</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="deduction_start" name="deduction_start"  required>
        </div>
      </div>


       <div class="form-group">
        <label class="control-label col-sm-4" for="email"> Deduction Every</label>
        <div class="col-sm-8">
        
        <select class="form-control" name="deduction_type" id="deduction_type">
            <?php if(empty($pay_type)){ echo "<option value=''>No paytype found. Please add to continue.</option>";} else{ foreach($cut_off_typeList as $c){
              if($pay_type==1 || $pay_type==2){
            ?>
                <option value="<?php echo $c->cDesc;?>"><?php echo $c->cValue;?></option>
            <?php } elseif($pay_type=='3') {
              if($c->cDesc==1 || $c->cDesc==2 || $c->cDesc==6){
            ?>
             <option value="<?php echo $c->cDesc;?>"><?php echo $c->cValue;?></option>
            <?php } } elseif($pay_type=='4'){   if($c->cDesc==6){?>
             <option value="<?php echo $c->cDesc;?>"><?php echo $c->cValue;?></option>

            <?php } }else {    } } }?>
        </select>
        </div>
      </div>


          <div class="form-group">
        <label class="control-label col-sm-4" for="email"> Deduction Amount</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="deduction_amount" name="deduction_amount" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': false" required>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-4" for="email"> Reason</label>
        <div class="col-sm-8">
        <textarea class="form-control" id="reason" name="reason"  required>
        </textarea>
        </div>
      </div>
      

      <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">


  <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">


  
  <?php
  $required = '';
  $req = 0;
  if ($setting_attachment == 1) { 

    if ($setting_required == 1)
    {
        $required = 'required';
        $req = 1;
    }
  ?> 
    <div class="col-md-12">
    <div class='col-md-1'></div>
    <div class="col-md-10">
         <div class="form-group">
          <label class="control-label col-sm-4" for="email"><center>File Attachment</center></label>
          <div class="col-sm-8">
              <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
              <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span>
          </div>
        </div>
    </div>
    </div>
 <?php } ?>

  <input type="hidden" name="required" value="<?php echo $setting_required;?> ">
  <input type="hidden" name="attach_file" value="<?php echo $setting_attachment;?>">
  



       <div class="form-group">
        <label class="control-label col-sm-4" for="email"></label>
        <div class="col-sm-8">
        <button type="submit" class="btn btn-success btn-md" id="smbt">Submit</button>
        </div>
      </div>
    </form>

  <?php } ?>
  </div>
</div>

<?php require_once(APPPATH.'views/app/application_form/footer.php');?>
<script type="text/javascript">
$(document).ready(function()
{
  $('#deduction_start').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false });
  $.material.init()
});
</script>
