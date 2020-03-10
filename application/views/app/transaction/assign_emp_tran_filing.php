
<?php 

 $location = urldecode($this->uri->segment('4')); //echo "<br>";
 $current_class = urldecode($this->uri->segment('5'));  //echo "<br>";
 $dept = urldecode($this->uri->segment('6'));// echo "<br>";
 $current_doc = urldecode($this->uri->segment('7')); //echo "<br>";

?>
<?php 
foreach($departmentList as $dept){
	echo '<div class="col-md-12">
	<div class="panel panel-info">
	<div class="panel-heading">Department:  <strong>
'.$dept->dept_name.'</strong></div><div class="panel-body">';
		$dept_id=$dept->department_id;

 $sec = $this->transaction_employees_model->getSec($dept_id);
 foreach($sec as $s){

 	$sec=$s->section_id;
 	$dep=$s->department_id;

 	echo '<div class="col-md-12">
	<div class="panel panel-danger">
	<div class="panel-heading">Section: <strong>'.$s->section_name.'</strong>
	<button type="button" class="btn btn-default pull-right btn-xs" ><i class="fa fa-sliders text-danger"> </i> </button>
	</div>

	<div class="panel-body">
	<table id="" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="20%">Employee ID</th>
					<th width="55%">Name</th>
					<th width="15%">Position</th>
					<th width="10%">Option</th>
				</tr>
			</thead><tbody>';		
	// assigned 
	$app = $this->transaction_employees_model->getFilers($dep,$sec,$current_class,$location,$current_doc );
	if(!empty($app)){
	foreach($app as $approvers){
		
		echo '<tr>'.
		'<td>'.$approvers->employee_id.'</td>'.
		'<td>'.$approvers->name.'</td>'.
		'<td>'.$approvers->position_name.'</td>'.
		'<td>'.'<i class="fa fa-remove fa-lg text-danger pull-left" class="hidden"  data-toggle="tooltip" data-placement="left" title="Click to remove approver" ></i>'.'</td>'.
		'</tr>';
	}
	}else{
		echo '<tr ><td colspan="4" class="text-danger" style="text-align:center;">-- No assigned employee yet. --</td></tr>';
	}
	// end approvers
echo '</tbody>
	</table>
	</div></div></div>';
	
 }

echo '</div></div></div>';
}

?>

