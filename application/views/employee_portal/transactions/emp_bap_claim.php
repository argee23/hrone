
<div class="panel panel-default">
  <div class="panel-body">
  <h4 class="panel-header">BURIAL ASSISTANCE PROGRAM (BAP) CLAIM FORM</h4>
  <hr>
  <?php if (count($approvers) == 0)
  { ?>



      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>

                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>

  <form class="form-horizontal" name="add_med_re" enctype="multipart/form-data" method="post" action="add_bap">

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Name of the Deceased</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="deceased_name" name="deceased_name" required>
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Birthday of the Deceased</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="deceased_bdate" name="deceased_bdate" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask" required>
    </div>
  </div>

  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Religion of the Deceased</label>
    <div class="col-sm-8">
    <select class="form-control" name="deceased_religion" id="deceased_religion">
    <?php foreach ($religionList as $rel) { ?>
    <option value="<?php echo $rel->param_id; ?>"><?php echo $rel->cValue; ?></option>
    <?php
    }?>
    </select>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Date of Death</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="death_date" name="death_date"  data-inputmask="'alias': 'yyyy-mm-dd'" data-mask" required>
    </div>
  </div>

      <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Relationship</label>
    <div class="col-sm-8">
    <select class="form-control" name="relation_to_claimant" id="relation_to_claimant" required>
    <?php foreach ($relationshipList as $rel) { ?>
    <option value="<?php echo $rel->param_id; ?>"><?php echo $rel->cValue; ?></option>
    <?php
    }?>
    </select>
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Funeral Wake Location</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="funeral_wake_place" name="funeral_wake_place">
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Interment Burial Location</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="interment_burial_place" name="interment_burial_place">
    </div>
  </div>

      <div class="form-group">
    <label class="control-label col-sm-4" for="email"> Date of Burial</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" id="burial_date" name="burial_date" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask" required>
    </div>
  </div>

  <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">


  <?php
  $required = '';
  $req = 0;
  if ($setting->attach_file == 1) { 

    if ($setting->is_attachment_required == 1)
    {
        $required = 'required';
        $req = 1;
    }
  ?> 
 
  <div class="form-group">
  <label class="control-label col-sm-4" for="email">File Attachment</label>
  <div class="col-sm-8">
  <input type="file"  id="file_attached" name="file_attached" <?php echo $required;?>>
  <div class="help-block with-errors"><span class="text-danger"> <small><i>Accepted Files: PNG, JPG, GIF, PDF | File size must not exceed 500 KB</i></small></span></div>
  </div>
  </div>
 <?php } ?>

    <input type="hidden" name="required" value="<?php echo $req; ?>">
    <input type="hidden" name="attach_file" value="<?php echo $setting->attach_file; ?>">

   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" class="btn btn-success btn-md">Submit</button>
    </div>
  </div>
</form>

  <?php } ?>
  </div>
</div>

<?php require_once(APPPATH.'views/app/application_form/footer.php');?>