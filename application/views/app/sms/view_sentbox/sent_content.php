<style type="text/css">
	.firsttd{
		background-color: #D6E123;
	}
	.sectd{
		background-color: #90E123;
	}
	.firstemp{
		background-color: #0CD725;
	}
	.secemp{
		background-color: #DDFE62;
	}
</style>
<div class="col-md-12">
	<div class="panel panel-success">
	<div class="panel-heading"><strong>Sent Box | <?php echo $myComp->company_name;?></strong></div>
		<div class="panel panel-body">

<?php

if(!empty($CompMessages)){
	$count_emp=0;
	foreach($CompMessages as $c){
		$count_emp++;
				if ($count_emp % 2 == 0) {
					$myEmpclass="firstemp";
				}else{
					$myEmpclass="secemp";
				}

		$name=$c->last_name." ".$c->first_name;
		$employee_id=$c->employee_id;

echo '
<button data-toggle="collapse" class="'.$myEmpclass.' btn btn-default" data-target="#demo'.$employee_id.'">'.$name.'</button>

<div id="demo'.$employee_id.'" class="collapse">
';

		$myMessages=$this->sms_model->getSentToEmployees($employee_id);
		echo '<div class="table-responsive">
			<table class="table table">
				<thead>
					<tr>
						<th>Message History ('.$name.')</th>
					</tr>
				</thead>
			<tbody>
		';

		if(!empty($myMessages)){
			$count_mess=0;
			foreach($myMessages as $m){
				$count_mess++;
				if ($count_mess % 2 == 0) {
					$myclass="firsttd";
				}else{
					$myclass="sectd";
				}
				echo '
					<tr>
						<td class="'.$myclass.'">'.nl2br($m->message).'<span class="pull-right">Sent To: '.$m->send_to.'<br>Date Sent: '.$m->date_sent.'</span></td>
						
					</tr>

				';
			}
		}else{

		}

			echo '
		</tbody>
		</table></div>
		';
	
echo '
</div>
';



	}//end foreach employees

}else{
	echo '--none yet--';
}

?>

</div>
</div>
</div>