     

<form action="<?php echo base_url()?>app/payroll_hold_employee/AddHoldPayrollReason" method="post">
<input type="hidden" name="company_id" value="<?php echo $company_id;?>">

	<div class="form-group">
	<label for="leave_type" class="col-sm-4 control-label">Reason To Hold</label>
	<div class="col-sm-8">
	<input type="text"  class="form-control" name="reason" id="reason" placeholder="Reason to Hold Payroll" required>
	</div>
	</div>    

	<div class="form-group">
	<label for="leave_type" class="col-sm-4 control-label">&nbsp;</label>
	<div class="col-sm-8">
	
	<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> Save</button>

	</div>
	</div>

 </form>
  <br><br>