<?php foreach($details_one as $row){?>

						<div class="col-md-12">
							<div class="col-md-3">
								<label class="pull-right">Customer Type</label>
							</div>
							<div class="col-md-7">
								<select class="form-control" id="upd_p_customer_type">
									<option value="old" <?php if($row->customer_type=='old'){ echo "selected"; }?>>Old Customer</option>
									<option value="new" <?php if($row->customer_type=='new'){ echo "selected"; }?>>New Customer</option>
								</select>
							</div>
						</div>
						<div class="col-md-12" style="margin-top: 5px;">
							<div class="col-md-3">
								<label class="pull-right">Validity</label>
							</div>
							<div class="col-md-7">
								<select class="form-control" id="upd_p_months_validity">
									<?php if(empty($details->number_months_option)){ echo "<option value=''>No data found. Please add setting to continue.</option>"; }
										else{ echo "<option value=''>Select</option>"; for($i=1;$i<=$details->number_months_option;$i++){ ?>
										<option value="<?php echo $i;?>" <?php if($row->no_of_months==$i){ echo "selected"; }?>><?php echo $i." ";?><?php if($i==1){ echo "Month"; } else{ echo "Months"; }?></option>
										<?php } }?>
								</select>
							</div>
						</div>
						<div class="col-md-12" style="margin-top:5px;">
							<div class="col-md-3">
								<label class="pull-right">Job License</label>
							</div>
							<div class="col-md-7">
								<input type="text" class="form-control" id="upd_p_job_license" value="<?php echo $row->no_of_jobs;?>">
							</div>
						</div>
						<div class="col-md-12" style="margin-top:5px;">
							<div class="col-md-3">
								<label class="pull-right">Price</label>
							</div>
							<div class="col-md-7">
								<input type="text" class="form-control" id="upd_p_price" value="<?php echo $row->orig_price;?>">
							</div>
						</div>

						<div class="col-md-12" style="margin-top:5px;">
							<div class="col-md-3">
								<label class="pull-right">Discount %</label>
							</div>
							<div class="col-md-7">
								<input type="text" class="form-control" id="upd_p_discount" value="<?php echo $row->discount_percentage;?>">
							</div>
						</div>

						<div class="col-md-12" style="margin-top:5px;">
							<div class="col-md-3">
								<label class="pull-right">VAT % </label>
							</div>
							<div class="col-md-7">
								<input type="text" class="form-control" id="upd_p_vat" value="<?php echo $row->vat_percentage;?>">
							</div>
						</div>

						<div class="col-md-12" style="margin-top:5px;">
							<div class="col-md-3">
								<label class="pull-right">Is VAT included already? </label>
							</div>
							<div class="col-md-7">
								<input type="radio" name="vat_included" onclick="action('upd_vat_already_included');" <?php if($row->is_vat_included_at_last_price=='yes'){ echo "checked"; }?>> Yes
								<input type="radio" name="vat_included" onclick="action('upd_vat_not_included');" <?php if($row->is_vat_included_at_last_price=='no'){ echo "checked"; }?>> No
								<input type="hidden" id="upd_p_vat_included" value="<?php echo $row->is_vat_included_at_last_price;?>">
							</div>
						</div>

						<div class="col-md-12" style="margin-top:5px;">
							<div class="col-md-3">
								<label class="pull-right">Settings(No. of Applicants)</label>
							</div>
							<div class="col-md-7">
								<input type="number" class="form-control" id="upd_settings_applicannt" value="<?php echo $row->setting_applicant;?>">
							</div>
						</div>

						<div class="col-md-12" style="margin-top:5px;">
							<div class="col-md-10">
								<button class="btn btn-danger pull-right" onclick="get_setting('<?php echo $type;?>');">BACK</button>
								<button class="btn btn-success pull-right" style="margin-right: 5px;" onclick="action_package_settings('<?php echo $type;?>','save_update','<?php echo $row->id;?>');">SAVE CHANGES</button>
							</div>
						</div>

<?php } ?>