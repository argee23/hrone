<div class="col-md-12" style="margin-top: 20px">
		<div class="panel panel-danger">
			<div class="panel-heading"><strong>Currently Enrolled Employees</u></strong></div>
			<div class="panel-body">

<table class="table">
<thead>
	<tr>
		<th>Name</th>
	</tr>
</thead>
<tbody>
	
							<?php
							if(!empty($already_enrolled_list)){
								foreach($already_enrolled_list as $e){
echo '
	<tr>
		<td>'.$e->last_name.' '.$e->first_name.'</td>
	</tr>
';

									
								}
							}else{

							}		


							?>
</tbody>

</table>



			</div>
		</div>
</div>