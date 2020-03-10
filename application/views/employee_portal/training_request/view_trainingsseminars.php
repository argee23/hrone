
<ol class="breadcrumb" style="margin-top: 5px;">
	<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Training and Seminar Details
	<button class="btn btn-success btn-xs pull-right" onclick="incoming_history();"><i class="fa fa-arrow-left"></i>Back</button>
	</h4>
</ol>

<div class="col-md-12">
<?php foreach($details as $d){?>
	
	 <div class="panel panel-success panel-heading"  id='action_trans' style="height:480px;overflow-y: scroll;">
        <div class="panel-heading">
            <h4><i class="fa fa-clipboard"></i><?php echo strtoupper($d->training_title);?></h4>   
         </div>

			<div class="col-md-8" style="margin-top: 20px;">

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Training Type</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->training_type;?>	
				</div>
			</div>


			<div class="col-md-12">
				<div class="col-md-5">
					<label>Training Sub Type</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->sub_type;?>	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Training Title / Topic</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->training_title;?>	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Conducted By Type</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->conducted_by_type;?>	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Conducted By</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->conducted_by;?>	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Purpose / Objective</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->purpose;?>	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Address Conducted</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->training_address;?>	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Required Months</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->monthsRequired;?>	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Attachment</label>
				</div>
				<div class="col-md-7">
					<?php echo substr($d->file_name,0,30);?> ...	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Fee Amount</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->fee_amount;?>	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Date From</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->datefrom;?>	
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-md-5">
					<label>Date Teqeqwo</label>
				</div>
				<div class="col-md-7">
					<?php echo $d->dateto;?>	
				</div>
			</div>

	</div>
	
	<div class="datagrid" style="margin-top: 20px;">
			<table>
					<thead>
						<tr>
							<th>Date</th>
							<th>Time</th>
							<th>Hours</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($dates as $d){?>
                        <tr>
                          <td>
                            <?php 
                              $month=substr($d->date, 5,2);
                              $day=substr($d->date, 8,2);
                              $year=substr($d->date, 0,4);

                              echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                            ?>
                          </td>
                          <td><?php echo $d->time_from." to ".$d->time_to;?></td>
                          <td><?php echo $d->hours;?></td>
                        </tr>
                    <?php } ?>
                    <tr class="alt">
                    	<td></td>
                    	<td></td>
                    	<td></td>
                    </tr>
					</tbody>
			</table>
		</div>
	</div>
	<?php } ?>

</div>
