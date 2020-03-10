



<?php 	

	if($type=='SD1') {

			

?>

			<ol class="col-md-12 breadcrumb">
				<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $setting_details->policy_title;?> <a class='btn btn-success btn-xs pull-right' style="margin-right: 5px;" onclick="action('add_new_package')">Add New</a>
				</h4>
			</ol>
			<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"><center>
			<?php 
			
			if($this->session->flashdata('success_add') AND $action=='add')
            { 
              echo 'New Package is Successfully Added.';
            } 
          
            else if($this->session->flashdata('success_delete') AND $action=='delete')
            { 
              echo 'Package '.$id.' is Successfully Deleted.';
            }
            else if($this->session->flashdata('success_save_update') AND $action=='save_update')
            { 
              echo 'Package  '.$id.' is Successfully Updated.';
            }
            else if($this->session->flashdata('success_enable') AND $action=='enable')
            { 
              echo 'Package  '.$id.' is Successfully enabled.';
            }
             else if($this->session->flashdata('success_disable') AND $action=='disable')
            { 
              echo 'Package  '.$id.' is Successfully disabled.';
            }
            else
            { 
              
            }
            ?>
            </center></n></div>
			<div class="col-md-12" style="padding-top: 20px;display: none;" id="update_new_package">
				
			</div>

			<div class="col-md-12" style="padding-top: 20px;display: none;" id="add_new_package">
				<div class="col-md-12">
					<div class="col-md-3">
						<label class="pull-right">Customer Type</label>
					</div>
					<div class="col-md-7">
						<select class="form-control" id="p_customer_type">
							<option value="old">Old Customer</option>
							<option value="new">New Customer</option>
						</select>
					</div>
				</div>
				<div class="col-md-12" style="margin-top: 5px;">
					<div class="col-md-3">
						<label class="pull-right">Validity</label>
					</div>
					<div class="col-md-7">
						<select class="form-control" id="p_months_validity">
							<?php if(empty($details->number_months_option)){ echo "<option value=''>No data found. Please add setting to continue.</option>"; }
								else{ echo "<option value=''>Select</option>"; for($i=1;$i<=$details->number_months_option;$i++){ ?>
								<option value="<?php echo $i;?>"><?php echo $i." ";?><?php if($i==1){ echo "Month"; } else{ echo "Months"; }?></option>
								<?php } }?>
						</select>
					</div>
				</div>
				<div class="col-md-12" style="margin-top:5px;">
					<div class="col-md-3">
						<label class="pull-right">Job License</label>
					</div>
					<div class="col-md-7">
						<input type="text" class="form-control" id="p_job_license">
					</div>
				</div>
				<div class="col-md-12" style="margin-top:5px;">
					<div class="col-md-3">
						<label class="pull-right">Price</label>
					</div>
					<div class="col-md-7">
						<input type="text" class="form-control" id="p_price">
					</div>
				</div>

				<div class="col-md-12" style="margin-top:5px;">
					<div class="col-md-3">
						<label class="pull-right">Discount %</label>
					</div>
					<div class="col-md-7">
						<input type="text" class="form-control" id="p_discount">
					</div>
				</div>

				<div class="col-md-12" style="margin-top:5px;">
					<div class="col-md-3">
						<label class="pull-right">VAT % </label>
					</div>
					<div class="col-md-7">
						<input type="text" class="form-control" id="p_vat">
					</div>
				</div>

				<div class="col-md-12" style="margin-top:5px;">
					<div class="col-md-3">
						<label class="pull-right">Is VAT included already? </label>
					</div>
					<div class="col-md-7">
						<input type="radio" name="vat_included" onclick="action('vat_already_included');"> Yes
						<input type="radio" name="vat_included" onclick="action('vat_not_included');"> No
						<input type="hidden" id="p_vat_included">
					</div>
				</div>
				<div class="col-md-12" style="margin-top:5px;">
					<div class="col-md-3">
						<label class="pull-right">Settings(No. of Applicants)</label>
					</div>
					<div class="col-md-7">
						<input type="number" class="form-control" id="settings_applicannt">
					</div>
				</div>

				<div class="col-md-12" style="margin-top:5px;">
					<div class="col-md-10">
						<button class="btn btn-danger pull-right" onclick="get_setting('<?php echo $type;?>');">BACK</button>
						<button class="btn btn-success pull-right" style="margin-right: 5px;" onclick="action_package_settings('<?php echo $type;?>','add','add');">SAVE</button>
					</div>
				</div>

			</div>
			<div class="col-md-12" style="padding-top: 20px;" id="package_view">
				<table id="SD1" class="table table-bordered table-striped" style="height: 10%;overflow: scroll;">
				<thead>
				  <tr>
				    <th>Customer Type</th>
				    <th>Validity</th>
				    <th>Jobs License</th>
				    <th>Orig Price</th>
				    <th>Discount %</th>
				    <th>Discounted Price</th>
				    <th>Vat Included already</th>
				    <th>Vat Percentage</th>
				    <th>Amount of Vat</th>
				    <th>Gross</th>
				    <th>Setting Applicant</th>
				    <th>Option</th>
				  </tr>
				</thead>
				<tbody>
				<?php
				foreach($rec_employer_bill_setting_mng as $bill_offers){

				$customer=$bill_offers->customer_type;
				$num_months=$bill_offers->no_of_months;
				$num_jobs=$bill_offers->no_of_jobs;
				$orig_price=$bill_offers->orig_price;
				$disc_percent=$bill_offers->discount_percentage;

				$vat_per=$bill_offers->vat_percentage;
				$is_vat_included_at_last_price=$bill_offers->is_vat_included_at_last_price;

				$less_amount = ($disc_percent / 100) * $orig_price;
				$discounted_amount = $orig_price-$less_amount;
				$vat_amount= ($vat_per / 100) * $discounted_amount;

				if($is_vat_included_at_last_price=="no"){
				  $gross=$discounted_amount+$vat_amount;
				}else{
				  $gross=$discounted_amount-$vat_amount;
				}
				if ($bill_offers->InActive=="0" || $bill_offers->InActive=="" ){
				  $color="text-danger";
				  $todo="disable_bill";
				  $bg="";

				}elseif($bill_offers->InActive=="1"){
				  $color="text-success";
				  $todo="enable_bill";
				$bg="class='text-danger'";
				}else{
					$bg="";
				}

				echo 
				'<tr '.$bg.'>
					<td>'.$customer.' customers</td>
					<td>'.$num_months.' months</td>
					<td>'.$num_jobs.'</td>
					<td>'.$orig_price.'</td>
					<td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>
					<td>'.$discounted_amount.'</td>
					<td>'.$is_vat_included_at_last_price.'</td>
					<td>'.$vat_per.'%</td>
					<td>'.number_format($vat_amount,2).'</td>
					<td>'.number_format($gross,2).'</td>
					<td>'.$bill_offers->setting_applicant.'</td>';?>
					<td>
						 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Edit Package setting' onclick="action_package_settings('<?php echo $type;?>','edit','<?php echo $bill_offers->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
		                 <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete Package setting' onclick="action_package_settings('<?php echo $type;?>','delete','<?php echo $bill_offers->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>
		                   
						 <?php 
						 	if($bill_offers->InActive==1){?> 
		                     	<a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable Package setting' onclick="action_package_settings('<?php echo $type;?>','enable','<?php echo $bill_offers->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>
		                   <?php } else { ?>
		                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable Package setting' onclick="action_package_settings('<?php echo $type;?>','disable','<?php echo $bill_offers->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
		                    <?php } ?>
		                   
					</td>

				<?php echo '</tr>';
				}
				?>
				</tbody>
				</table>
			</div>


	<?php } elseif($type=='SD2'){?>


			<ol class="col-md-12 breadcrumb">
				<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $setting_details->policy_title;?></h4>
			</ol>

			<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;"><center>
			<?php 
		
			if($this->session->flashdata('success_save_update') AND $type=='SD2')
            { 
              echo 'Free Trial Select Option is Successfully Updated.';
            } 
            else
            { 
              
            }
            ?>
            </center></n></div>

			<div class="col-md-12" style="margin-top: 20px;">
				<div class="col-md-12">
					<div class="col-md-3"><label class="pull-right">Free Trial Validity</label></div>
					<div class="col-md-7">
							<select class="form-control" id="months_trial">
							<?php if(empty($details->number_months_option)){ echo "<option value=''>No data found. Please add setting to continue.</option>"; }
								else{ for($i=1;$i<=$details->number_months_option;$i++){ ?>
								<option value="<?php echo $i;?>" <?php if($i==$details->free_trial_months_can_post){ echo "selected"; }?>><?php echo $i." ";?><?php if($i==1){ echo "Month"; } else{ echo "Months"; }?></option>
								<?php } }?>
							</select>
					</div>
				</div>
				<div class="col-md-12" style="margin-top: 10px;">
					<div class="col-md-3"><label class="pull-right">No. of Jobs Can post</label></div>
					<div class="col-md-7">
						<input type="text" class="form-control" id="post_trial" value="<?php echo $details->free_trial_jobs_can_post;?>">
					</div>
				</div>	
				
					
				<div class="col-md-12" style="margin-top: 10px;">
					<div class="col-md-10">
						<button class="btn btn-success pull-right" onclick="save_free_trial('<?php echo $type;?>','<?php echo $details->id;?>');">Save Changes</button>
					</div>
				</div>				
			</div>



	<?php } elseif($type=='SD3' || $type=='SD12'){
		if($type=='SD3'){ $d= 'Package'; $typee='SD3'; } else{ $d='Free';  $typee='SD12'; }

		echo $this->session->flashdata('success_add');
		?>


			<ol class="col-md-12 breadcrumb">
				<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $setting_details->policy_title;?></h4>
			</ol>

			

			<div class="col-md-12">
				<div class="col-md-12">
					<div class="col-md-12">
						<div class="col-md-3"><label class="pull-right">Title</label></div>
						<div class="col-md-7">
								<input type="text" class="form-control" id="title">
								<input type="hidden" class="form-control" id="title_">
						</div>
					</div>
					<div class="col-md-12" style="margin-top: 5px;">
						<div class="col-md-3"><label class="pull-right">Description</label></div>
						<div class="col-md-7">
								<input type="text" class="form-control" id="desc">
								<input type="hidden" class="form-control" id="desc_">
						</div>
					</div>
					<div class="col-md-12" style="margin-top: 5px;">
						<div class="col-md-3"><label class="pull-right">Is file Uplodable:</label></div>
						<div class="col-md-7">
						<input type="radio" name="file_uploadable" onclick="action_file_uploaded('final_file_uploaded','1');" checked> Yes
						<input type="radio" name="file_uploadable" onclick="action_file_uploaded('final_file_uploaded','0');"> No
						<input type="hidden" id="final_file_uploaded" value='1'>
						</div>
					</div>

					<div class="col-md-12" style="margin-top: 5px;">
						<div class="col-md-3"><label class="pull-right">Note:</label></div>
						<div class="col-md-7">
								<input type="text" class="form-control" id="note">
								<input type="hidden" class="form-control" id="note_">
						</div>
						<div class="col-md-1"><button class="btn btn-success" onclick="requirements_action('<?php echo $type?>','add','add')">SAVE</button></div>
					</div>
					<br><br><br><br><br><br><br><br><br>
				 	<div class="box box-danger" class='col-md-12'></div>
				</div>

				<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;margin-bottom: 10px;"><center>
					<?php 
					if($this->session->flashdata('success_add') AND $type==$typee)
		            { 
		              echo 'New '.$d.' Requirement is Successfully Added.';
		            } 
		          
		            else if($this->session->flashdata('success_delete') AND $type==$typee)
		            { 
		              echo ''.$d.' Requirement ID - '.$id.' is Successfully Deleted.';
		            }
		            else if($this->session->flashdata('success_save_update') AND $type==$typee)
		            { 
		              echo ''.$d.' Requirement ID is Successfully Updated.';
		            }
		            else if($this->session->flashdata('success_enable') AND $type==$typee)
		            { 
		              echo ''.$d.' Requirement ID - '.$id.'  is Successfully enabled.';
		            }
		             else if($this->session->flashdata('success_disable') AND $type==$typee)
		            { 
		              echo ''.$d.' Requirement ID - '.$id.'  is Successfully disabled.';
		            }
		            else
		            { 
		              
		            }
		            ?>
		            </center></n></div>

				<table class="table table-hover" id="<?php echo $type;?>">
					<thead>
						<tr class="success">
							<th>ID</th>
							<th>Title</th>
							<th>Description</th>
							<th>Notes</th>
							<th>Uploadable?</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($details as $row){?>
						<tr>
							<td><?php echo $row->id;?></td>
							<td>
								<div id="o_title<?php echo $row->id;?>"><?php echo $row->title;?></div>
								<div id="u_title<?php echo $row->id;?>" style="display: none;">
										<input type="text" class="form-control" id="upd_title<?php echo $row->id;?>" value="<?php echo $row->title;?>">
										<input type="hidden" id="upd_title_<?php echo $row->id;?>">
								</div>
							</td>
							<td>
								<div id="o_desc<?php echo $row->id;?>"><?php echo $row->description;?></div>
								<div id="u_desc<?php echo $row->id;?>" style="display: none;">
										<input type="text" class="form-control" id="upd_desc<?php echo $row->id;?>" value="<?php echo $row->description;?>">
										<input type="hidden" id="upd_desc_<?php echo $row->id;?>">
								</div>
							</td>
							<td>
								<div id="o_note<?php echo $row->id;?>"><?php echo $row->note;?></div>
								<div id="u_note<?php echo $row->id;?>" style="display: none;">
										<input type="text" class="form-control" id="upd_note<?php echo $row->id;?>" value="<?php echo $row->note;?>">
										<input type="hidden" id="upd_note_<?php echo $row->id;?>">
								</div>
							</td>
							<td>
								<div id="o_uploadable<?php echo $row->id;?>"><?php if($row->uploadable==1){ echo "Yes"; } else{ echo "No"; } ?></div>
								<div id="u_uploadable<?php echo $row->id;?>" style="display: none;">
										<input type="radio" name="updfile_uploadable<?php echo $row->id;?>" onclick="action_file_uploaded('upd_final_file_uploaded','1');" <?php if($row->uploadable==1){ echo "checked"; }?>> Yes
										<input type="radio" name="updfile_uploadable<?php echo $row->id;?>" onclick="action_file_uploaded('upd_final_file_uploaded','0');"  <?php if($row->uploadable==0){ echo "checked"; }?>> No
										<input type="hidden" id="upd_final_file_uploaded" value='<?php echo $row->uploadable;?>'>
								</div>

								

							</td>
							<td>
								 <div id="o<?php echo $row->id;?>">
		                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update details' onclick="requirements_action('<?php echo $type?>','edit','<?php echo $row->id?>')" ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> 

		                           <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete requirement' onclick="requirements_action('<?php echo $type?>','delete','<?php echo $row->id?>')"><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

		                        <?php if($row->InActive==1){?> 
		                    
		                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable requirement' onclick="requirements_action('<?php echo $type?>','enable','<?php echo $row->id?>')"><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>

		                        <?php } else { ?>
		                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable requirement' onclick="requirements_action('<?php echo $type?>','disable','<?php echo $row->id?>')"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
		                        <?php } ?>
		                        </div>
		                        <div id="u<?php echo $row->id;?>" style="display: none;">

		                        <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="requirements_action('<?php echo $type?>','save_update','<?php echo $row->id?>')"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

		                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update' onclick="requirements_action('<?php echo $type?>','cancel','<?php echo $row->id?>')"><i  class="fa fa-times fa-lg  pull-left"></i></a>
		                        </div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
	<?php } elseif($type=='view_all_settings')
	{?>

			<ol class="col-md-12 breadcrumb">
				<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Setting/s List</h4>
			</ol>

			<div class="col-md-12">
					<table class="table table-hover" id="view_all_settings">
					<thead>
						<tr class="success">
							<th>ID</th>
							<th>Setting Title</th>
							<th>Code</th>
							<th>Note</th>
							<th>Is Default</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($details as $row){?>
						<tr>
							<td><?php echo $row->id;?></td>
							<td>
								<div id="o_title<?php echo $row->id;?>"><?php echo $row->policy_title;?></div>
								<div id="u_title<?php echo $row->id;?>" style="display: none;">
										<input type="text" class="form-control" id="s_upd_title<?php echo $row->id?>" value="<?php echo $row->policy_title;?>">
										<input type="hidden" id="s_upd_title_<?php echo $row->id?>">
								</div>
							</td>
							<td>
								<?php echo $row->code;?>
							</td>
							<td>
								<div id="o_note<?php echo $row->id;?>"><?php echo $row->note;?></div>
								<div id="u_note<?php echo $row->id;?>" style="display: none;">
										<input type="text" class="form-control" id="s_upd_note<?php echo $row->id?>" value="<?php echo $row->note;?>">
										<input type="hidden" id="s_upd_note_<?php echo $row->id?>">
								</div>
							</td>
							<td>
								<?php if($row->IsDefault==1){ echo "yes"; } else { echo "no"; }?>
							</td>
							<td>
							
								 <div id="osettings<?php echo $row->id;?>">
		                            <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Update details' onclick="action_settings('<?php echo $type;?>','update','<?php echo $row->id;?>');" ><i  class="fa fa-<?php echo $system_defined_icons->icon_edit;?> fa-lg pull-left"></i></a> 

		                        <?php  if($row->IsDefault==1){ } else{ ?>
		                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Delete requirement' onclick="action_settings('<?php echo $type;?>','delete','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>

		                         <?php if($row->InActive==1){?> 
		                    
		                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_disable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Enable requirement' onclick="action_settings('<?php echo $type;?>','enable','<?php echo $row->id;?>');" ><i  class="fa fa-<?php  echo $system_defined_icons->icon_disable;?> fa-lg  pull-left"></i></a>

		                        <?php } else { ?>
		                         <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_enable_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to Disable requirement' onclick="action_settings('<?php echo $type;?>','disable','<?php echo $row->id;?>');"><i  class="fa fa-<?php  echo $system_defined_icons->icon_enable;?> fa-lg  pull-left"></i></a>
		                        <?php } }?>
		                        </div>
		                        <div id="usettings<?php echo $row->id;?>" style="display: none;">
			                        <a style='cursor:pointer;'  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick="action_settings('<?php echo $type;?>','save_update','<?php echo $row->id;?>');"><i  class="fa fa-check fa-lg  pull-left text-success"></i></a>

			                        <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>'  aria-hidden='true' data-toggle='tooltip' title='Click to cancel update' onclick="action_settings('<?php echo $type;?>','cancel','<?php echo $row->id;?>');" ><i  class="fa fa-times fa-lg  pull-left"></i></a>
		                        </div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>




	<?php } elseif($type=='add_new_settings'){?>


			<ol class="col-md-12 breadcrumb">
				<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Add New Setting/s</h4>
			</ol>

			<div class="col-md-12">

					<div class="col-md-12">
						<div class="col-md-3">
							<label class="pull-right">Choices</label>
						</div>
						<div class="col-md-8">
							<select class="form-control" onchange="add_new_settings('<?php echo $type;?>','choices',this.value);" id="s_choices">
								<option value="" disabled selected>Select</option>
								<?php foreach($details as $row){
									$exist = $this->serttech_recruitment_setting_model->checker_recruitment_settings_list($row->code);
									if($exist > 0){} else{
								?>
								<option value='<?php echo $row->code;?>'><?php echo $row->title;?></option>
								<?php } }?>
								<option value='single_field'>Add New Single Field Setting</option>
							</select>
						</div>
					</div>

					<div class="col-md-12" style="padding-top: 5px;">
						<div class="col-md-3">
							<label class="pull-right">Setting Title</label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="s_title">
							<input type="hidden" class="form-control" id="s_title_">
						</div>
					</div>

					<div class="col-md-12" style="padding-top: 5px;">
						<div class="col-md-3">
							<label class="pull-right">Setting Note</label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="s_note">
							<input type="hidden" class="form-control" id="s_note_">
						</div>
					</div>
					<div class="col-md-12" style="padding-top: 5px;">
						<div class="col-md-3">
							<label class="pull-right">Code/Identification</label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="s_code">
							<input type="hidden" class="form-control" id="s_code_">
						</div>
					</div>

					<div class="col-md-12" style="padding-top: 5px;display: none;" id="for_single_data">
						<div class="col-md-3">
							<label class="pull-right">Field Details</label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="s_field_name">
							<input type="hidden" class="form-control" id="s_field_name_">
						</div>
						<div class="col-md-3" style="padding-top: 5px;"></div>
						<div class="col-md-4" style="padding-top: 5px;">
							<select class="form-control" id="s_format1" onchange="add_new_settings('<?php echo $type;?>','format1',this.value)">
									<option value="" disabled selected>Select Format</option>
									<option>text</option>
						            <option>dropdown</option>
						            <option>datepicker</option>
							</select>
						</div>
						<div class="col-md-4" style="padding-top: 5px;">
							<select class="form-control" id="s_format2">
								<option disabled selected>Select Format Option</option>
							</select>
							<select class="form-control" id="s_format2text" style="display: none;" onchange="add_new_settings('<?php echo $type;?>','text',this.value)">
								<option value="" disabled selected>Select</option>
								<option value="Numbers">Numbers Only</option>
								<option value="Alphanumerics">Alphanumerics</option>
							</select>
							<textarea id="s_format2dropdown" style="display: none;" onchange="add_new_settings('<?php echo $type;?>','dropdown',this.value)"></textarea>


							<select class="form-control" id="s_format2datepicker" style="display: none;" onchange="add_new_settings('<?php echo $type;?>','datepicker',this.value)">
									<option disabled selected value="">Select Date Type</option>
							     	<option value='date'>Date</option>
							        <option value='datetime-local'>Datetime </option>
							        <option value='month'>Month and year </option>
							        <option value='week'>Week and year </option>
							        <option value='time'>Time</option>
							</select>
							<input type="hidden" id="s_format2_final">
							<input type="hidden" id="s_format2_final_">
						</div>
					</div>
				<div class="col-md-12" style="margin-top: 10px;">
					<div class="col-md-11">
						<button class="btn btn-success pull-right" onclick="add_new_settings('<?php echo $type;?>','save','save')">Save Changes</button>
					</div>
				</div>	

			</div>

	<?php } elseif($type=='SD4') {?>

					<ol class="col-md-12 breadcrumb">
						<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $setting_details->policy_title;?></h4>
					</ol>
					<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;margin-bottom: 10px;"><center>
					<?php 
					
					if($this->session->flashdata('success_save_update') AND $type=='SD4')
		            { 
		              echo ''.$setting_details->policy_title.' is Successfully Updated.';
		            } 
		          	
		            else
		            { 
		              
		            }
		            ?>
		            </center></n></div>

					<div class="col-md-12" style="padding-top: 70px;">
							<div class="col-md-3">
								<label class="pull-right">Number of Months</label>
							</div>
							<div class="col-md-7">
							<input type="number" class="form-control" value="<?php echo $details->number_months_option_validity_package;?>" id="package">
							</div>
							<div class="col-md-1"><button class="btn btn-success" onclick="save_months_setting('<?php echo $type;?>','<?php echo $details->id;?>','package','number_months_option_validity_package');">SAVE CHANGES</button></div>
					</div>

	<?php } elseif ($type=='SD5') {?>
		
					<ol class="col-md-12 breadcrumb">
						<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $setting_details->policy_title;?></h4>
					</ol>

					<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;margin-bottom: 10px;"><center>
					<?php 
					
					if($this->session->flashdata('success_save_update') AND $type=='SD5')
		            { 
		              echo ''.$setting_details->policy_title.' is Successfully Updated.';
		            } 
		          	
		            else
		            { 
		              
		            }
		            ?>
		            </center></n></div>

					<div class="col-md-12" style="padding-top: 70px;">
							<div class="col-md-3">
								<label class="pull-right">Number of Months</label>
							</div>
							<div class="col-md-7">
								<input type="number" class="form-control" value="<?php echo $details->number_months_option;?>" id="trial">
							</div>
							<div class="col-md-1"><button class="btn btn-success" onclick="save_months_setting('<?php echo $type;?>','<?php echo $details->id;?>','trial','number_months_option');">SAVE CHANGES</button></div>
					</div>


	<?php } elseif($type=='SD6'){?>


					<ol class="col-md-12 breadcrumb">
						<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $setting_details->policy_title;?></h4>
					</ol>

					<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;margin-bottom: 20px;"><center>
					<?php 
					
					if($this->session->flashdata('success_save') AND $type=='SD6')
		            { 
		              echo ''.$setting_details->policy_title.' is Successfully Added.';
		            } 
		          	else if($this->session->flashdata('success_save_update') AND $type=='SD6')
		            { 
		              echo ''.$setting_details->policy_title.' is Successfully Updated.';
		            } 
		            else
		            { 
		              
		            }
		            ?>
		            </center></n><br></div>

					<div class="col-md-12">
						<div class="col-md-2"></div>
						<div class="col-md-8">
						<table id="SD1" class="col-md-10 table table-bordered table-striped" style="height: 10%;overflow: scroll;">
							<thead>
							  	<tr class="danger"><th colspan="2"><center>Emails Details <?php if(empty($details)){ echo "(no existing data please add)"; }else{}?></center></th></tr>
							</thead>
							<tbody>
							<?php if(empty($details)){?>
							<tr style="text-align: center;">
									<td>SMTP HOST</td>
									<td>
											<input type="text" class="form-control" id="smtp_host" value="">
											<input type="hidden" id="smtp_host_">
										
									</td>
								</tr>
								<tr style="text-align: center;">
									<td>SMTP PORT</td>
									<td>
											<input type="text" class="form-control" id="smtp_port" value="">
											<input type="hidden" id="smtp_port_">
									</td>
								</tr>
								<tr style="text-align: center;">
									<td>USERNAME</td>
									<td>
										
											<input type="text" class="form-control" id="username" value="">
											<input type="hidden" id="username_">
									</td>
								</tr>
								<tr style="text-align: center;">
									<td>PASSWORD</td>
									<td>
										
											<input type="text" class="form-control" id="password" value="">
											<input type="hidden" id="password_">
										
									</td>
								</tr>
								<tr style="text-align: center;">
									<td>SEND MAIL FROM</td>
									<td>
											<input type="text" class="form-control" id="send_mail_from" value="">
											<input type="hidden" id="send_mail_from_">
										
									</td>
								</tr>

								<tr style="text-align: center;">
									<td>SECURITY TYPE</td>
									<td>
											<input type="text" class="form-control" id="security_type" value="">
											<input type="hidden" id="security_type_">
										
									</td>
								</tr>

							<?php } else{ foreach($details as $row){?>
								<tr style="text-align: center;">
									<td>SMTP HOST</td>
									<td>
										<div id="o_host"><?php echo $row->smtp_host;?></div>
										<div id="u_host" style="display: none;">
											<input type="text" class="form-control" id="smtp_host" value="<?php echo $row->smtp_host;?>">
											<input type="hidden" id="smtp_host_">
										</div>
									</td>
								</tr>
								<tr style="text-align: center;">
									<td>SMTP PORT</td>
									<td>
										<div id="o_port"><?php echo $row->smtp_port;?></div>
										<div id="u_port" style="display: none;">
											<input type="text" class="form-control" id="smtp_port" value="<?php echo $row->smtp_port;?>">
											<input type="hidden" id="smtp_port_">
										</div>
									</td>
								</tr>
								<tr style="text-align: center;">
									<td>USERNAME</td>
									<td>
										<div id="o_username"><?php echo $row->username;?></div>
										<div id="u_username" style="display: none;">
											<input type="text" class="form-control" id="username" value="<?php echo $row->username;?>">
											<input type="hidden" id="username_">
										</div>
									</td>
								</tr>
								<tr style="text-align: center;">
									<td>PASSWORD</td>
									<td>
										<div id="o_password"><?php echo $row->password;?></div>
										<div id="u_password" style="display: none;">
											<input type="text" class="form-control" id="password" value="<?php echo $row->password;?>">
											<input type="hidden" id="password_">
										</div>
									</td>
								</tr>
								<tr style="text-align: center;">
									<td>SEND MAIL FROM</td>
									<td>
										<div id="o_mail_from"><?php echo $row->send_mail_from;?></div>
										<div id="u_mail_from" style="display: none;">
										<input type="text" class="form-control" id="send_mail_from" value="<?php echo $row->send_mail_from;?>">
											<input type="hidden" id="send_mail_from_">
										</div>
									</td>
								</tr>
								<tr style="text-align: center;">
									<td>Security Type</td>
									<td>
										<div id="o_security_type"><?php echo $row->security_type;?></div>
										<div id="u_security_type" style="display: none;">
										<input type="text" class="form-control" id="security_type" value="<?php echo $row->security_type;?>">
											<input type="hidden" id="security_type_">
										</div>
									</td>
								</tr>
							<?php } } ?>
							</tbody>
							</table>
						</div>
						<div class="col-md-2"></div>

						<div class="col-md-10" style="padding-top: 20px;">
						<?php if(empty($details)){?>
							<button class="btn btn-success pull-right" onclick="email_settings('<?php echo $type;?>','save','save','serttech_host')" id="email_update">SAVE</button>
						<?php }
						else{?>
							<button class="btn btn-success pull-right" onclick="email_settings('<?php echo $type;?>','<?php echo $row->id;?>','update')" id="email_update">UPDATE</button>
							<button class="btn btn-danger pull-right" onclick="email_settings('<?php echo $type;?>','<?php echo $row->id;?>','cancel')" id="email_cancel" style='display: none;'>CANCEL</button>
							<button class="btn btn-success pull-right" onclick="email_settings('<?php echo $type;?>','<?php echo $row->id;?>','save_update','serttech_host')" id="email_save" style='display: none;margin-right: 10px;'>SAVE CHANGES</button>
						<?php } ?>
						</div>
					</div>

	<?php } elseif($type=='SD18' || $type=='SD19'){ 
		foreach($details as $row){
	?>

	<ol class="col-md-12 breadcrumb">
		<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"><?php echo $row->policy_title;?></i></h4>
	</ol>
	<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;margin-bottom: 10px;">
		<center>
					<?php echo $msg;
					echo $this->session->flashdata('success_save');
					if($this->session->flashdata('success_save') AND  $row->code==$type)
		            { 
		              echo ''.$row->policy_title.' data is Successfully Updated.';
		            } 
		          
		            else
		            { 
		              
		            }
		            ?>
		</center>
	</div>

	<div class="col-md-12">
		<form class="form-horizontal" method="post" action="<?php echo base_url()?>serttech/recruitment_setting/save_ed8_settings/<?php echo $row->idd."/".$type."/".$row->format_1."/".'save';?>">

		<textarea class="form-control" name="content"><?php echo $row->data;?></textarea>

		<button type="submit" class="col-md-3 btn btn-success pull-right" style="margin-top:10px;">SAVE</button>

		</form>
	</div>


	<?php } } else{ ?>

			<?php foreach ($details as $row) {
			?>
				<ol class="col-md-12 breadcrumb">
					<h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $row->policy_title;?></h4>
				</ol>
				<div id="flashdata_result"> <n class="text-danger" style="font-weight:bold;margin-bottom: 10px;"><center>
					<?php 
					
					if($this->session->flashdata('success_save') AND  $row->code==$type)
		            { 
		              echo ''.$row->policy_title.' data is Successfully Updated.';
		            } 
		          
		            else
		            { 
		              
		            }
		            ?>
		            </center></n></div>
				<div class="col-md-12">

				<div class="col-md-12" style="padding-top:70px;">
						<div class="col-md-3">
							<label class="pull-right"><?php echo $row->field_title;?> </label>
						</div>
						<?php if($row->format_1=='text'){ ?>

							<div class="col-md-6">
								<input type="<?php if($row->format_2=='text'){ echo "text"; } else{ echo "number"; }?>" class="form-control" id="text_<?php echo $row->idd;?>" value="<?php echo $row->data;?>">
							</div>

						<?php } elseif($row->format_1=='dropdown'){
								$data = $row->format_2;
								$var=explode('-',$data); 
							?>

							<div class="col-md-6">
								<select class="form-control" id="dropdown_<?php echo $row->idd;?>">
								<option disabled selected value="">Select</option>
								<?php foreach($var as $v){?>
									<option value="<?php echo $v;?>" <?php  if($row->data==$v){ echo "selected"; }?>><?php echo $v;?></option>
								<?php } ?>
								</select>
							</div>

						<?php } elseif($row->format_1=='datepicker'){ ?>

							<div class="col-md-6">
								<input type="<?php echo $row->format_2;?>" class="form-control"  id="datepicker_<?php echo $row->idd;?>" value="<?php echo $row->data;?>">
							</div>

						<?php } ?>	

						<div class="col-md-1"><button class="btn btn-success" onclick="single_field_data('<?php echo $type;?>','<?php echo $row->format_1;?>','<?php echo $row->idd;?>','save');">SAVE</button></div>
					</div>
					<input type="hidden" id="final_data_single">
				</div>

			<?php } ?>

	<?php } 

	if(empty($setting_details->note)){}else { ?>
<div class="col-md-12" style="padding-top: 20px;">
	<h4 class="text-warning"><i><b>Note:</b><?php echo $setting_details->note;?></i></h4>
</div>
<?php } ?>