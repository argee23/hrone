<h5 class="text-success"><center><u>Update <?php echo $company_title?> Notification Details setting</u></center></h5><br>
<?php
$get_company_details = $this->employee_account_management_model->get_company_notif_details($company_id);
foreach ($get_company_details as $row_1) { 
			if($row_1->action_option=='All'){?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Select Viewing Action:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
				    <select class="form-control" id='notif_option_res' onchange='notif_action("notif_option_action",<?php echo $account_management_policy_id?>,this.value);' disabled>
				      <option >Select Option</option>
				        <option value="All" selected>All</option>
				        <option value="Multi">Multiple Company</option>
				        <option value="One_emp">One Company by Employment Details</option>
				        <option value="One_specs">One Company by Employee Specifics</option> 
				    </select>
				</div>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' onkeypress="return isNumberKey(this, event);" id='notif_days_view_update' value='<?php echo $row_1->days_to_view?>'>
				</div>

				<div class='col-md-12'>
				<button class='btn btn-danger pull-right' id='save_disable' onclick="delete_notif('All',<?php echo $company_id?>,<?php echo $account_management_policy_id?>);" style='margin-left: 5px;'>UPDATE VIEWING OPTION</button>
					<button class='btn btn-success pull-right' id='save_disable' onclick="updatesave_notif_all('All',<?php echo $company_id?>,<?php echo $account_management_policy_id?>);" style='margin-left: 5px;'>SAVE CHANGES</button>	
				</div>
<?php } elseif ($row_1->action_option=='Multi') {
		$multi_var = explode('-',$row_1->option_for_multicompany); ?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Select Viewing Action:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
				    <select class="form-control" disabled>
				     <option >Select Option</option>
				        <option value="All" >All</option>
				        <option value="Multi" selected>Multiple Company</option>
				        <option value="One_emp">One Company by Employment Details</option>
				        <option value="One_specs">One Company by Employee Specifics</option>  
				    </select>
				</div>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Select Company:</label>
				</div>
				<div class="col-md-9">
					 <?php 
					 	$count = 0; 
					 	foreach($company_details as $n){?>
				          <div class='col-md-6'>
				            <input type="checkbox" class="n_company_update"  value="<?php echo $n->company_id; ?>" <?php foreach ($multi_var as $v) { if($v == $n->company_id) { echo "checked";} } ?> >
				          <n class='text-danger' ><?php echo $n->company_name; ?></n><br>
				          </div>
			          <?php $count = $count + 1;  } echo "<input type='hidden' id='count_update' value='".$count."'>"; ?>
		        </div>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' id='notif_days_view_update' value='<?php echo $row_1->days_to_view?>'>
				</div>
				<div class='col-md-12'>
				<button class='btn btn-danger pull-right' id='save_disable' onclick="delete_notif('All',<?php echo $company_id?>,<?php echo $row_1->account_management_policy_id?>);" style='margin-left: 5px;'>UPDATE VIEWING OPTION</button>
					<button class='btn btn-success pull-right' id='save_disable' onclick="updatesave_notif_all('Multi','<?php echo $company_id?>','<?php echo $row_1->account_management_policy_id?>');" style='margin-left: 5px;'>SAVE CHANGES</button>	
					
				</div>
<?php } elseif ($row_1->action_option=='One_specs') { ?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Select Viewing Action:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
				    <select class="form-control" id='notif_option_res' onchange='notif_action("notif_option_action",<?php echo $account_management_policy_id?>,this.value);' disabled>
				      <option selected disabled>Select Option</option>
				        <option value="All" selected>All</option>
				        <option value="Multi">Multiple Company</option>
				        <option value="One_emp">One Company by Employment Details</option>
				        <option value="One_specs">One Company by Employee Specifics</option>    
				    </select>
				</div>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' onkeypress="return isNumberKey(this, event);" id='notif_days_view_update' value='<?php echo $row_1->days_to_view?>'>
				</div>

				<div class='col-md-12'>
				<button class='btn btn-danger pull-right' id='save_disable' onclick="delete_notif('All',<?php echo $company_id?>,<?php echo $row_1->account_management_policy_id?>);" style='margin-left: 5px;'>UPDATE VIEWING OPTION</button>
					<button class='btn btn-success pull-right' id='save_disable' onclick="updatesave_notif_all('One_specs','<?php echo $company_id?>','<?php echo $row_1->account_management_policy_id?>');" style='margin-left: 5px;'>SAVE CHANGES</button>	
				</div>
	<?php } elseif($row_1->action_option=='One_emp') {?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Select Viewing Action:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
				    <select class="form-control" id='notif_option_res' onchange='notif_action("notif_option_action",<?php echo $account_management_policy_id?>,this.value);' disabled>
				      <option selected disabled>Select Option</option>
				        <option value="All" >All</option>
				        <option value="Multi">Multiple Company</option>
				        <option value="One_emp" selected>One Company by Employment Details</option>
				        <option value="One_specs">One Company by Employee Specifics</option>    
				    </select>
				</div>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' onkeypress="return isNumberKey(this, event);" id='oneemp_days_view' value='<?php echo $row_1->days_to_view?>'>
				</div>
					<input type="hidden" id='subsection_value'>
					<input type="hidden" id='section_value'>
					<input type="hidden" id='department_value'>
					<input type="hidden" id='division_value'>
				    <input type="hidden" id="company_id" value="<?php echo $company_id?>">
				     <input type="hidden" id="company_id_fetch" >
				     <input type="hidden"  id="notif_company_id" value="<?php echo $company_id?>" >
				     </div>
				  <div class="col-md-12">
				     	<div class="col-md-3" style="padding-bottom: 10px;">
                                <label>Select Company:</label>
                            </div>

                            <div class="col-md-9" style="padding-bottom: 10px;">
                              <select class="form-control" id='compp' onchange='fetch_company("division",this.value)'>
                              <option selected disabled>Select Company</option>
                               <?php foreach($company_details as $row_c){?>
                               <option value="<?php echo $row_c->company_id?>"><?php echo $row_c->company_name;?></option>
                                <?php } ?>
                              </select>
                        </div>
                   </div>
                         <div class="col-md-12" id='division' style="padding-top: 15px;">
                         </div>
				      
				      	<div class="col-md-12" id='department' style="padding-top: 15px;">
				         
				     	</div>

				     	<div class="col-md-12" id='section' style="padding-top: 15px;">
				          
				      	</div>

				     	<div class="col-md-12" id='subsection' style="padding-top: 15px;">
				         
				      	</div>

					<div class='col-md-12'>
					<button class='btn btn-danger pull-right' id='save_disable' onclick="delete_notif('All',<?php echo $company_id?>,<?php echo $row_1->account_management_policy_id?>);" style='margin-left: 5px;'>UPDATE VIEWING OPTION</button>
						<button class='btn btn-success pull-right' id='save' onclick="save_notifdata_one_emp('update','One_emp','<?php echo $row_1->account_management_policy_id?>');" style='margin-left: 5px;'>SAVE CHANGES</button>	
					</div>
		<?php } }?>
