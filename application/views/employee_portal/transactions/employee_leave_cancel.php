
<div class="panel panel-default" ng-init='clear()' ngcloak>

  <div class="panel-body">
  <h4 class="panel-header">Apply Cancellation of Leave <small>Employee Cancellation of Leave Form</small></h4>
  <hr>
  <?php if (count($approvers) == 0)
  { ?>

 			<div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>

                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>
  <form class="form-horizontal" name="add_med_re"  method="post"  enctype="multipart/form-data"  action="<?php echo base_url();?>employee_portal/employee_transactions/add_leave_cancel" onsubmit="document.getElementById('submit').disabled=true;">
  <div class="form-group">
   <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
    <label class="control-label col-sm-4" for="email">Leave Document Number</label> 
     
    <div class="col-sm-8">
       <select class="form-control" id="doc_no" name="doc_no" required  onchange="onpage_getform(this.value)" >
        <option value="0" disabled selected>Select</option>
         <?php foreach($get_leave as $leave){
          $leave_dates = $this->transaction_employees_model->get_leave_dates($form->doc_no);?>
            <option value='<?php echo $leave->doc_no?>'
              title="&#013;Doc Number : <?php echo $leave->doc_no;?>&#013;&#013;Leave Type : <?php echo $leave->leave_type;?>&#013;&#013;With Pay Option:<?php if($leave->with_pay==1){ echo "with pay"; } else{  echo "without pay"; } ?>&#013;&#013;Date Filed: <?php echo $leave->date_created;?>&#013;&#013;Leave Dates:<?php $leave_dates = $this->transaction_employees_model->get_leave_dates($leave->doc_no); $i=1; foreach($leave_dates as $d){ if($i==count($leave_dates)){ echo $d->the_date; } else{ echo $d->the_date.' , '; }  $i++; } ?>"  data-toggle="popover" data-trigger="hover" ><?php echo $leave->leave_type.'( '; $leave_dates = $this->transaction_employees_model->get_leave_dates($leave->doc_no); $i=1; foreach($leave_dates as $d){ if($i==count($leave_dates)){ echo $d->the_date; } else{ echo $d->the_date.' , '; }  $i++; } echo' )';  ?></option>
         <?php } ?> 
	   </select> 
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
      <div class="splash" ng-cloak="">
          <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
          </div>
      </div>
      <div ng-cloak>
        
      </div>
       <div class="help-block with-errors"><span class="text-danger" id="errors"></span></div>
    </div>
  </div>
  <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">

	<div class="form-group">
	<label class="control-label col-sm-4" for="email">Reason</label>
	<div class="col-sm-8">
	<textarea class="form-control" rows="2" name="reason" id="comment"></textarea>
	</div>
	</div>
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
    <button type="submit" id="submit" class="btn btn-success btn-md">Submit</button>
    </div>
  </div>
</form>


  <?php } ?>
  </div>
</div>

<input type="hidden" id="baseurl" value="<?php echo base_url();?>employee_portal/">  
<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>
<script type="text/javascript">
  function onpage_getform(doc_no)
  {
      var base_url = document.getElementById('baseurl').value;
      var location_href =base_url + "employee_transactions/view/" +doc_no+"/employee_leave/HR002";
      window.open(location_href);        
      
  }
</script>