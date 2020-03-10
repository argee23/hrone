
<table class="table table-hover table-striped">
	<?php foreach ($company_info as $company): ?>
		<tr id="<?php echo $company->company_id?>" onclick="getCompany(this.id)" class="text-center">
			<td data-dismiss="modal" style="cursor:pointer"><h4><strong><?php echo ucwords($company->company_name) ?></strong></h4></td>
		</tr>
	<?php endforeach ?>
</table>