<div class="row">
<div class="col-md-12">

<div class="box box-primary">
<div class="panel panel-default">
  <div class="panel-heading"><strong>
  	<?php
  	if(!empty($group_details)){
  		echo $group_details->group_name;
  	}else{
  		echo "notice: group missing";
  	}
  	?>


  </strong>
  

  </div>
  <div class="box-body">
  <div class="panel panel-default">




<table id="example1" class="table table-hover table-striped">
	<thead >
	<tr>
		<th colspan="5" ><i class="fa fa-clock-o"></i> <span class="text-danger">Fixed Schedules</span>
		</th>
	</tr>
		<tr>
			<th>Employee </th>
			<th>Monday</th>
			<th>Tuesday</th>
			<th>Wednesday</th>
			<th>Thursday</th>
			<th>Friday</th>
			<th>Saturday</th>
			<th>Sunday</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(!empty($fixedschedgroup_members)){
		foreach($fixedschedgroup_members as $emp){

              $company_id=$emp->company_id;
              $location=$emp->location; //location id
              $classification=$emp->classification_id; //classification id

               //echo "$company_id $location $classification <br>";
              require(APPPATH.'views/include/loc_class_restriction.php');

	          	if($allowed>0){ // check this variable at loc_class_restriction

					echo '<tr>';
						echo '<td>'.$emp->last_name.' '.$emp->first_name.'
						</td>
						<td>'.$emp->mon.'</td>
						<td>'.$emp->tue.'</td>
						<td>'.$emp->wed.'</td>
						<td>'.$emp->thu.'</td>
						<td>'.$emp->fri.'</td>
						<td>'.$emp->sat.'</td>
						<td>'.$emp->sun.'</td>';
					echo '</tr>';

				}else{

				}

		}
	}else{

	}
	?>
	</tbody>

</table>


</div>
</div>
</div>
</div>
</div>
</div>
