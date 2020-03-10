<ol class="breadcrumb" style="margin-top: 5px;">
	<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Training and Seminar Requests History
	<a class="btn btn-success btn-xs pull-right" data-toggle='collapse' data-target='#demo'>Filter History</a>
	</h4>
</ol>
<div class="col-md-12">
            
	<div class="col-md-12 collapse in" id="demo">

	<div class="col-md-2"></div>
	<div class="col-md-4">
		<div class="col-md-12">
			<select class="form-control" id="response_status" onchange="filter_history(this.value);">
				<option value="all" disabled selected>Select Request Reponse</option>
				<option value="all">All</option>
				<option value="1">Approved Request</option>
				<option value="0">Declined Request</option>
				<option value="no_reponse">No Response</option>
			</select>
		</div>
		<div class="col-md-12" style="margin-top: 10px;">
			<select class="form-control"  id="training_status" onchange="filter_history(this.value);">
				<option value="all">Select Training/Seminar Status</option>
				<option value="all">All</option>
				<option value="finished">Finished</option>
				<option value="unfinished">Unfinished</option>
				<option value="ongoing">Ongoing</option>
			</select>
		</div>

		<div class="col-md-12" style="margin-top: 10px;">
			<input type="date" class="form-control" id="date_from" onchange="filter_history(this.value);">
			<center><n class="text-danger"><i>Training Request Date From</i></n></center>
		</div>


	</div>
	<div class="col-md-4">
		<div class="col-md-12" >
			<select class="form-control" id="option" onchange="filter_history(this.value);">
				<option value="all" disabled selected>Select Option</option>
				<option value="all">All</option>
				<option value="1">Added in official employee trainings and seminars</option>
				<option value="0">Not yet added in employee trainings and seminars</option>
			</select>
		</div>
		<div class="col-md-12" style="margin-top: 10px;">
			<select class="form-control" id="training_type" onchange="filter_history(this.value);">
				<option value="all">Training Fee Type</option>
				<option value="all">All</option>
				<option value="company">Company</option>
				<option value="employee">Employee</option>
				<option value="free">Free</option>
			</select>
		</div>
		<div class="col-md-12" style="margin-top: 10px;">
			<input type="date" class="form-control" id="date_to" onchange="filter_history(this.value);">
			<center><n class="text-danger"><i>Training Request Date To</i></n></center>
		</div>

	</div>		
	<div class="col-md-2"></div>
	<br><br><br><br><br><br><br><br>
   	<div class="box box-danger" class='col-md-12'></div>
	</div>

	<div class="col-md-12" style="margin-top: 30px;" id="filter_history_result">
		<table class="table table-hover" id="history">
			<thead>
				<tr class="success">
					<th>Training Type</th>
					<th>Training Sub Type</th>
					<th>Training Title</th>
					<th>Training Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
    </div>

</div>
                   