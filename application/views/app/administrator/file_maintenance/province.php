
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Provinces</strong> <a onclick="addProvinces()" type="button" class="btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
		  </a></div>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Province</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($province as $p){?>
				<tr>
					<td><?php echo $p->id;?></td>
					<td><?php echo $p->name;?></td>
					<td>
						

                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="editProvince('<?php echo $p->id;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Update Province'  ><?php echo '<i class="fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';"></i>';?></a>

                       		<?php echo $delete = anchor('app/file_maintenance/delete_province/'.$p->id.'/'.$p->name,'<i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$p->name."?')"));?>

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
