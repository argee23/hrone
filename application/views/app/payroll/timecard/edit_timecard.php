<form action="<?php echo base_url()?>app/timecard_table/modify_timecard" method="post" id="modify_timecard">
	<td>
		<input type="hidden" name="timecard_id" id="timecard_id" value="<?php echo $time_card->timecard_id ?>">
		<?php echo $time_card->prefix.$time_card->timecard_id ?>
	</td>
	<td>
		<input type="text" name="timecard_desc_name" id="timecard_desc_name" class="form-control" value="<?php echo $time_card->timecard_desc_name ?>">
	</td>
	<td>
		<input type="text" name="timecard_description" id="timecard_description" class="form-control" value="<?php echo $time_card->timecard_description ?>">
	</td>
	<td>
	<a class="modify_timecard" title="Modify Timecard Details" style="cursor: pointer" data-id="<?php echo $time_card->timecard_id?>" onclick="modifyTimecard()">
	  <span class="fa-stack">
	    <i class="fa fa-square fa-stack-2x text-primary"></i>
	    <i class="fa fa-floppy-o fa-stack-1x fa-inverse"></i>
	  </span>
	</a>
	</td>
</form>