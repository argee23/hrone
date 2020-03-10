<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $val;?> Occurence Settings</h4></ol>


<div class="col-md-12">

		<div class="col-md-12">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="col-md-12">
					<select class="form-control" name="company" id="company" onchange="setting_action('<?php echo $val;?>');">
					<option value="" disabled selected>Select Company</option>
					<?php foreach($companyList as $co){?>
						<option value="<?php echo $co->company_id;?>"><?php echo $co->company_name;?></option>
					<?php  } ?>
					</select>
				</div>
				<div class="col-md-12" style="margin-top: 10px;">
					<select class="form-control" name="option" id="option" onchange="setting_action('<?php echo $val;?>');">
					<option value="" disabled selected>Select Option</option>
					<option>Occurences</option>
					<option>Total</option>
					</select>
				</div>
				<br>
				<n class="text-danger" id="msgg" style='display:none;'><center>Fill up all fieds to continue</center></n>
			</div>
			<div class="col-md-3"></div>
		</div>

		<div class="col-md-12" id="setting_action">

		</div>

</div>