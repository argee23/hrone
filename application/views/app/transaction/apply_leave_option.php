<div class="col-md-14">
      <div class="box box-info">
        <form name="f1" method="post" action="<?php echo base_url()?>app/transaction_employees/save_app_leave_pay_opt/" >  
    <div class="box-header">
Employee Apply Leave Options
 <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save?</button>
    </div>
  <div class="box-body">
  		<div class="form-group"   >
			<label for="leave_application" class="col-sm-2 control-label">Leave Application</label>
		<div class="col-sm-10" >
			<select name="leave_pay_option" class="form-control select2" required>
			<option value="with_pay">always with pay when there is available leave balanaces</option>
			<option value="without_pay">allow without pay option</option>	
			</select>	
		</div>
	</div>     



  </div>
</form>
      </div>
</div>