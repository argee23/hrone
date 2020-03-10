
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$addAdvance=$this->session->userdata('addAdvance');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-danger">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Advance Type</strong> <a onclick="addAdvance()" type="button" class="<?php echo $addAdvance;?> btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		  	
		  </a></div>

		<?php echo $table_advance_type;?>
		</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
