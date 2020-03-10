     

<form action="<?php echo base_url()?>app/payroll_hold_employee/updateHoldPayrollReason" method="post">
<input type="hidden" name="company_id" value="<?php echo $reasonInfo->company_id;?>">
<input type="hidden" name="id" value="<?php echo $reasonInfo->id;?>">

	<div class="form-group">
	<label for="leave_type" class="col-sm-4 control-label">Reason To Hold</label>
	<div class="col-sm-8">
	<input type="text"  class="form-control" name="reason" id="reason" placeholder="Reason to Hold Payroll" required value="<?php echo $reasonInfo->reason?>">
	</div>
	</div>    

	<div class="form-group">
	<label for="leave_type" class="col-sm-4 control-label">&nbsp;</label>
	<div class="col-sm-8">
	
	<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> Update</button>

	</div>
	</div>

 </form>

 <br><br>