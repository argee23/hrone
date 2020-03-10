
<input type="hidden" name="id" id="id" value="<?php echo $timecard_data->tc_table_id ?>">

<table class="table table-bordered table-responsive table-hover" >
<tr class="success">
	<td colspan="2"><strong>Salary Rate: </strong><?php echo $timecard_data->salary_rate_name ?></td>
	<td colspan="2" align="center"><strong>Pay Type: </strong><?php echo $timecard_data->pay_type_name ?></td>
	<td colspan="2" align="right"><strong>Employment: </strong><?php echo $timecard_data->employment_name ?></td>
</tr>
<tr align="center">
  <td class="warning" rowspan="2"><strong>Code</strong></td>
  <td class="warning" rowspan="2"><strong>Description</strong></td>
  <td class="danger" colspan="2"><strong>Regular</strong></td>
  <td class="info" colspan="2"><strong>Overtime</strong></td>
</tr>
<tr align="center">
  <td><strong>without ND</strong></td>
  <td><strong>with ND</strong></td>
  <td><strong>without ND</strong></td>
  <td><strong>with ND</strong></td>
</tr>
<tr>
	<td class="info"><?php echo $timecard_data->prefix.$timecard_data->timecard_id ?></td>
	<td class="info"><?php echo $timecard_data->timecard_desc_name ?></td>
	<td><input type="text" class="form-control" name="reg_wnd" id="reg_wnd" value="<?php echo $timecard_data->reg_wnd ?>" onkeypress="return isNumberKey(event)"></td>
	<td><input type="text" class="form-control" name="reg_nd" id="reg_nd" value="<?php echo $timecard_data->reg_nd ?>" onkeypress="return isNumberKey(event)"></td>
	<td><input type="text" class="form-control" name="ot_wnd" id="ot_wnd" value="<?php echo $timecard_data->ot_wnd ?>" onkeypress="return isNumberKey(event)"></td>
	<td><input type="text" class="form-control" name="ot_nd" id="ot_nd" value="<?php echo $timecard_data->ot_nd ?>" onkeypress="return isNumberKey(event)"></td>
</tr>
</table>

<input type="hidden" name="company" id="company" value="<?php echo $company ?>">