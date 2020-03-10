
<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_employment=$this->session->userdata('add_employment');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-info">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Employment</strong> <a onclick="addEmployment()" type="button" class="<?php echo $add_employment;?> btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
		  </a></div>

		<?php echo $table_employment;?>
		</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
