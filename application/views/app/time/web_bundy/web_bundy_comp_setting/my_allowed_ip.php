

<div class="well">
<table id="example1" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>IP Address</th>
			<th>Label</th>
			<th>Option</th>
		</tr>
	</thead>
	<tbody>
<?php
if(!empty($my_allowed_ip)){
	foreach($my_allowed_ip as $a){
		echo '
		<tr>
			<td>'.$a->allowed_ip_address.'</td>
			<td>'.$a->pc_name.'</td>
			<td>Delete/Disable</td>
		</tr>
		';
	}
}else{

}

?>


</tbody>
</table>

</div>


