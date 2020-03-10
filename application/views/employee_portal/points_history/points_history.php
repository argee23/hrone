<div class="col-md-12" >
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success">
        <div class="panel-heading"><h4 class="text-danger"><?php echo $details->title;?></h4></div>
   			<div class="panel-body" style="height:440px;">
     	
     			<table class="table table-hover" id="points_history">
					<thead>
						<tr class="danger">
							<th>Job Position</th>
							<th>Applicant</th>
							<th>Points</th>
							<th>Date Added</th>
							<th>Admin Status</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($get_details as $gt){?>
						<tr>
							<td><?php echo $gt->job_title;?></td>
							<td><?php echo $gt->fullname;?></td>
							<td><?php echo $details->points;?></td>
							<td><?php echo $gt->date_added;?></td>
							<td></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
         
    		</div>
     	</div>
    </div>
  </div>
</div>
