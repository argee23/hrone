
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Job Specialization</strong> <a onclick="addSpecialization()" type="button" class="btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
		  </a></div>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Specialization</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($specialization as $sp){?>
				<tr>
					<td><?php echo $sp->param_id;?></td>
					<td><?php echo $sp->cValue;?></td>
					<td><?php if(empty($sp->cDesc)){ echo "No Description found"; } else{ echo $sp->cDesc; } ?></td>
					<td>
						

                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="edit_specialization('<?php echo $sp->param_id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Update Job Specialization'  ><?php echo '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';"></i>';?></a>

                       		<?php echo $delete = anchor('app/file_maintenance/delete_specialization/'.$sp->param_id.'/'.$sp->cValue,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$sp->cValue."?')"));?>

					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>

		</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
