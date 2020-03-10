<?php

$addNetwork=$this->session->userdata('addNetwork');

?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-success">
		  <!-- Default panel contents -->
		  <div class="panel-heading"><strong>Manage Network</strong> <a onclick="addNetwork()" type="button"  class="<?php echo $addNetwork;?> btn btn-default btn-xs pull-right" title="Add">
			<?php
			echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
			?>		
		  </a></div>

		<?php echo $network_display;?>
		</div>
	</div>

	<div class="col-md-6" id="col_3">
		
	</div>
</div>



