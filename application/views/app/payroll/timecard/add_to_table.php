<table class="table table-bordered table-responsive table-hover" >
<tr class="success">
	<td colspan="3"><strong>Pay Type: </strong><?php echo $pt->pay_type_name ?></td>
	<td colspan="3" align="right"><strong>Employment: </strong><?php echo $e->employment_name ?></td>
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
	<td class="info"><?php echo $ti->prefix.$ti->timecard_id ?></td>
	<td class="info"><?php echo $ti->timecard_desc_name ?></td>
	<td><input type="text" class="form-control" name="reg_wnd" id="reg_wnd" value="0.00" onkeypress="return isNumberKey(event)"></td>
	<td><input type="text" class="form-control" name="reg_nd" id="reg_nd" value="0.00" onkeypress="return isNumberKey(event)"></td>
	<td><input type="text" class="form-control" name="ot_wnd" id="ot_wnd" value="0.00" onkeypress="return isNumberKey(event)"></td>
	<td><input type="text" class="form-control" name="ot_nd" id="ot_nd" value="0.00" onkeypress="return isNumberKey(event)"></td>
</tr>
</table>