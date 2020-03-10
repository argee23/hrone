
		<table class="table table-hover" id="history">
			<thead>
				<tr class="success">
					<th>No.</th>
					<th>Training Type</th>
					<th>Training Sub Type</th>
					<th>Training Title</th>
					<th>Training Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php $i=1; foreach($details as $d){?>
				<tr>
					<td><?php echo $i.".";?></td>
					<td><?php echo $d->training_type;?></td>
					<td><?php echo $d->sub_type;?></td>
					<td><?php echo $d->training_title;?></td>
					<td>
						<?php 
							if($d->datefrom==$d->dateto){ echo $d->datefrom; }
							else{ echo $d->datefrom." to ".$d->dateto;  }
						?>
					</td>
					<td>
						 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="view_trainingsseminars('<?php echo $d->training_seminar_id;?>');" aria-hidden='true' data-toggle='tooltip' title='View Settings'><i class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

					</td>
				</tr>
			<?php $i++; } ?>
			</tbody>
		</table>