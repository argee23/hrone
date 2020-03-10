<?php
/*
-----------------------------------
start : user role restriction access checking.
-----------------------------------
*/
$add_gender=$this->session->userdata('add_gender');
/*
-----------------------------------
end : user role restriction access checking.
-----------------------------------
*/

?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-warning">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Gender</strong> <a onclick="addGender()" type="button"  class="<?php echo $add_gender;?> btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
		  </a></div>

		<?php echo $table_gender;?>
		</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>
