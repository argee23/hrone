
	<div class="col-md-12" id="general_page">


<!--  -->
<div class="container" >
  <h2><strong><?php echo $ratee->fullname?></strong> Appraisal</h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Employee Info</a></li>
    <li><a data-toggle="tab" href="#menu1">
    	<strong><i class="fa fa-arrow-right"></i><span style="color:#ff0000;"> Form Format</span>
    			<i class="fa fa-arrow-left"></i>
    	</strong></a>
    </li>
    <li><a data-toggle="tab" href="#menu2">Evaluation<br> Result</a></li>
    <li><a data-toggle="tab" href="#menu3">Approval<br> Result</a></li>
    <li><a data-toggle="tab" href="#menu4">Appraisal<br> Result</a></li>
  </ul>

  <div class="tab-content">
  <!-- //========================================== Employee Info -->
    <div id="home" class="tab-pane fade in active" >
      <h3>Employee Information</h3>

      <p>Location/Branch <i class="fa fa-arrow-right"></i> <strong><?php echo $ratee->location_name?></strong></p>
      <p>Division <i class="fa fa-arrow-right"></i> <strong><?php echo $ratee->division_name?></strong></p>
      <p>Department <i class="fa fa-arrow-right"></i> <strong><?php echo $ratee->dept_name?></strong></p>
      <p>Section <i class="fa fa-arrow-right"></i> <strong><?php echo $ratee->section_name?></strong></p>
      <p>Sub-Section <i class="fa fa-arrow-right"></i> <strong><?php echo $ratee->subsection_name?></strong></p>
      <p>Classification <i class="fa fa-arrow-right"></i> <strong><?php echo $ratee->classification_name?></strong></p>

    </div>
  <!-- //========================================== Form Format -->

    <div id="menu1" class="tab-pane fade">
      <h3>Step 1 : Set Appraisal Period</h3>

      <div class="table-responsive">
		<form method="POST" action="<?php echo base_url()?>employee_portal/pms_employee/saveAppraisalPeriod/<?php echo $employee_id;?>" >

		      	<table class="table" style="width: 50%">
		      		<thead>
		      		<tr>
		      			<th>Date From</th>
		      			<th><input type="date" class="form-control" name="date_from" required> </th>
		      			<th>Date To</th>
		      			<th><input type="date" class="form-control" name="date_to" required> </th>
		      		</tr>
		      		<tr>
		      			<th colspan="4">
			<button  type="submit" class="btn btn-danger">Save Appraisal Period
			</button>      				

		      			</th>
		      		</tr>
		      		</thead>
		      	</table>

		</form>

<table class="table" style="width: 50%">
	<thead>
		<tr>
			<th>Appraisal Period</th>
			<th>Status</th>
			<th>Step 2 : Manage Scorecard Format</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(!empty($AppraisalPer)){
		foreach($AppraisalPer as $p){
			$appraisal_status=$p->status;

			if($appraisal_status!="approved"){
				$manageScorecard='
<a href="'.base_url().'employee_portal/pms_employee/viewGeneralForms/'.$p->id.'/'.$ratee->employee_id.'/'.$ratee->position_id.'" target="_blank">
<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" data-toggle="tooltip" data-placement="left" title="Click to Manage Form/Scorecard Format" style="color:'.$system_defined_icons->icon_edit_color.'"></i></a>
				';
			}else{
				$manageScorecard="not allowed as appraisal is already approved.";
			}
			echo '
				<tr>
					<td><a title="Document No: '.$p->doc_no.'">'.$p->duration_from.' to '.$p->duration_to.'</a></td>
					<td>'.$p->status.'</td>
					<td>'.$manageScorecard.'</td>
				</tr>

			';
		}
	}else{

	}
	?>

	</tbody>
	
</table>


     

      <h3>Step 2: Manage Scorecard Format</h3>

    
      	<table class="table" style="width: 50%;">
      		<thead>
      <!-- 			<tr>
      				<th>General Appraisal Format<i>(Created by Admin)</i></th>
      			</tr> -->
      			<tr>
      				<th>Part Number</th>
      				<th>Form Name</th>
      				<th>Form Weight</th>
      				<th>Action</th>
      			</tr>
      		</thead>
      		<tbody>
      			<?php
      			if(!empty($general_forms)){
      				foreach($general_forms as $g){
      					echo '
			      			<tr>
			      				<td>'.$g->part_number.'</td>
			      				<td>'.$g->part_name.'</td>
			      				<td>'.$g->form_weight.'</td>
			      				<td>';
if(!empty($checkAppraisalPer)){

			      		?>
<a href="<?=base_url()?>employee_portal/pms_employee/viewGeneralForms/<?php echo $g->id;?>/<?php echo $ratee->employee_id;?>/<?php echo $ratee->position_id;?>" target="_blank">
<i class="fa fa-<?=$system_defined_icons->icon_view?> fa-<?=$system_defined_icons->icon_size?>x" data-toggle="tooltip" data-placement="left" title="Click to View Form Details" style="color:<?=$system_defined_icons->icon_view_color?>;"></i></a>
			      		<?php
}else{

?>	
Create Appraisal Period First <i>(See Step 1)</i><i class="fa fa-arrow-up"></i>
<?php
}





			      		echo '</td>
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


























    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
    <div id="menu4" class="tab-pane fade">
      <h3>Menu 4</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>
<!--  -->




	</div>