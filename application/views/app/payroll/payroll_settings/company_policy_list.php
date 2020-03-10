 <?php if(empty($policy_list) AND empty($notyet_added_policy)) { echo "<h3 class='text-danger'>No Policy Setting Added.</h3>"; } else { ?> 
 	<input type="hidden" id="policy_title">
 <ul class="nav nav-pills nav-stacked">
 <?php foreach($policy_list as $row)
 { ?>
    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;"  onclick="settings('<?php echo $row->payroll_setting_policy_id?>','<?php echo $row->payroll_main_id?>')"><i class='fa fa-folder-open'></i> <span><?php echo $row->title?> </span></a></li>     
<?php } ?>
</ul>
<ul class="nav nav-pills nav-stacked">
<?php foreach($notyet_added_policy as $rows)
{?>
		<li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;color:red;" aria-hidden='true' data-toggle='tooltip' title='Click to add the policy' onclick="add_policy('<?php echo $rows->payroll_main_id?>',)"><i class='fa fa-lock'></i> <span><?php echo $rows->title?> </span></a></li> 
<?php }?>
</ul>

<?php } ?>