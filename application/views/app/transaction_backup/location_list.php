
<label>Location</label><br>
<div class="col-md-12">
<?php if(empty($location))
{ echo "<n class='text-danger'>No location list added. Please add to continue.</n>"; }
else{
	$i=0;
	foreach ($location as $loc) {?>
		
		
		<div class="col-md-4"><input type="checkbox" class="location" id="location" value='<?php echo $loc->location_id?>' checked><?php echo $loc->location_name?></div>

<?php	$i++; } } echo "<input type='hidden' id='location_count' value='".$i."'>"; ?>

<input type="hidden" name="location_val" id="location_val">
</div>
