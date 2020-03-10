<?php if(!empty($employee_list) AND  $employee_list!='no_setting' ){?>
<h3 class="text-danger"><center><u>Select Atleast one member to continue.</u></center></h3>
<br>
<table class="table table-hover" id='employee_list_table'>
<thead>
	<tr class="danger">
		<th><input type="checkbox" onclick="checkbox_stat();" id="checkbox_stat"></th>
	 	<th>Name</th>
		<th>Location</th>
		<th>Position</th>
		<th>Classification</th>
	</tr>
</thead>
<tbody>
<?php $i=0; foreach ($employee_list as $row) {?>
	<tr>
		<td><input type="checkbox" value="<?php echo $row->employee_id?>" class="employee_list" id='employee_id<?php echo $i?>'></td>
		<td><?php echo $row->fullname?></td>
		<td><?php echo $row->location_name?></td>
		<td><?php echo $row->position_name?></td>
		<td><?php echo $row->cname?></td>
	</tr>
<?php $i = $i+1;} echo "<input type='hidden' id='employeecount' value='".$i."'>"; ?>
</tbody>
</table>
<div class="pull-right">
	<button type="button" class="btn btn-success" onclick="save_group();">Save</button>
	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
<?php } else { ?>
<br><br>
	<h3 class="text-danger"><center>No Results Found.</center></h3>
<?php } ?>