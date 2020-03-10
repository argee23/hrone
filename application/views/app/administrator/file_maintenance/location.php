
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$addLocation=$this->session->userdata('addLocation');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-success">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Location</strong> <a onclick="addLocation()" type="button"  class="<?php echo $addLocation;?> btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
		  </a></div>

		<?php echo $table_location;?>
		</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
