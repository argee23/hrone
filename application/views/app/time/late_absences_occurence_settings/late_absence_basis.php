<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Late and Absences Basis Settings</h4></ol>


<div class="col-md-12">

		<div class="col-md-12">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="col-md-3">Select Company: </div>
				<div class="col-md-9">
					<select class="form-control" name="company" id="company" onchange="setting_action_basis(this.value)">
					<option value="" disabled selected>Select Company</option>
					<?php foreach($companyList as $co){?>
						<option value="<?php echo $co->company_id;?>"><?php echo $co->company_name;?></option>
					<?php  } ?>
					</select>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>

		<div class="col-md-12" id="setting_action">

		</div>

</div>