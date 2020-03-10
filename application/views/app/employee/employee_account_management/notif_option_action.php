<?php if($check_notif_com_exist=='exist') {
	//pag meron nang data si company
	$get_company_details = $this->employee_account_management_model->get_company_notif_details($company_id);
	//company notification setup
	foreach ($get_company_details as $row_1) { 
			if($row_1->action_option=='All'){?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Viewing Option:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
				    <select class="form-control" disabled>
				      <option selected disabled><?php echo $row_1->action_option?></option>
				    </select>
				</div>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' disabled value='<?php echo $row_1->days_to_view?>'>
				</div>
				<div class='col-md-12'>
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>

					<button class='btn btn-success pull-right' id='save_disable' onclick="updateform_notif_all('All',<?php echo $company_id?>,<?php echo $account_management_policy_id?>);" style='margin-left: 5px;'>UPDATE</button>	
<?php
}
?>



				</div>
			<?php } elseif($row_1->action_option=='Multi'){ 
				$multi_var = explode('-',$row_1->option_for_multicompany);
				?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Viewing Action:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
				    <select class="form-control" disabled>
				      <option selected disabled><?php echo $row_1->action_option?></option>
				    </select>
				</div>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Select Company:</label>
				</div>
				<div class="col-md-9">
					 <?php 
					 	$count = 0; 
					 	foreach($companyList as $n){?>
				          <div class='col-md-6'>
				            <input type="checkbox" class=""  value="<?php echo $n->company_id; ?>" <?php foreach ($multi_var as $v) { if($v == $n->company_id) { echo "checked";} } ?> disabled>
				          <n class='text-danger' ><?php echo $n->company_name; ?></n><br>
				          </div>
			          <?php $count = $count + 1;  } ?>
		        </div>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' disabled value='<?php echo $row_1->days_to_view?>'>
				</div>
				<div class='col-md-12'>
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>					
					<button class='btn btn-success pull-right' id='save_disable' onclick="updateform_notif_all('Multi',<?php echo $company_id?>);" style='margin-left: 5px;'>UPDATE</button>	
<?php
}
?>


				</div>
			<?php } elseif($row_1->action_option=='One_specs'){?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Viewing Action:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
				    <select class="form-control" disabled>
				      <option selected disabled>One Company by Employee Specifics</option>
				    </select>
				</div>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' disabled value='<?php echo $row_1->days_to_view?>'>
				</div>
				<div class='col-md-12'>
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>

					<button class='btn btn-success pull-right' id='save_disable' onclick="updateform_notif_all('One_specs',<?php echo $company_id?>);" style='margin-left: 5px;'>UPDATE</button>
<?php
}
?>

				</div>
			<?php } elseif($row_1->action_option=='One_emp'){
					$get_hired_id = $this->employee_account_management_model->get_emp_hired($row_1->company_id);
					
				?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Viewing Action:</label>
				</div>
				<div class="col-md-9" style="padding-bottom: 10px;">
				    <select class="form-control" disabled>
				      <option selected disabled>One Company by Employment Details</option>
				    </select>
				</div>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' disabled value='<?php echo $row_1->days_to_view?>'>
				</div>
					<input type="hidden" id='subsection_value'>
					<input type="hidden" id='section_value'>
					<input type="hidden" id='department_value'>
					<input type="hidden" id='division_value'>
				    <input type="hidden" id="company_id" value="<?php echo $company_id?>">
				    <input type="hidden" id="company_id_fetch">
				   <?php 
				   foreach ($get_hired_id as $hh) {
				   		$u_emp_notif_id = $hh->emp_hired_notif_by_designation_id;
						$u_company = $hh->company;
						$u_division = $hh->division;
						$u_department = $hh->department;
						$u_section = $hh->section;
						$u_subsection = $hh->subsection;
						$u_location = $hh->location;
						$u_employment = $hh->employment;
						$u_classification = $hh->classification;
						$u_status = $hh->status;
						$e_division = explode("-",$u_division);
						$e_department = explode("-",$u_department);
						$e_section = explode("-",$u_section);
						$e_subsection = explode("-",$u_subsection);
						$e_employment = explode("-",$u_employment);
						$e_classification = explode("-",$u_classification);
						$e_status= explode("-",$u_status);
						$e_location = explode("-",$u_location);
					?>
				  <div class="col-md-12">
				     	<div class="col-md-3" style="padding-bottom: 10px;">
                               Select Company:
                            </div>
                            <div class="col-md-9" style="padding-bottom: 10px;">
                              <select class="form-control" id='compp' onchange='fetch_company("division",this.value)' disabled>
                               <?php foreach($companyList as $row_c){?>
                               <option value="<?php echo $row_c->company_id?>" <?php if($u_company==$row_c->company_id) { echo "selected"; } else{}?>><?php echo $row_c->company_name;?></option>
                                <?php } ?>
                              </select>
                        </div>
                   </div>
                         <div class="col-md-12" id='division' style="padding-top: 15px;">
                         <?php $division = $this->employee_account_management_model->divisionList($u_company); ?>
                          <div class="col-md-3">Division :</div>
			                  <div class="col-md-9">
			                  <?php $i= 0; if(empty($division)){?>
			                       <div class='col-md-6'> <input type='checkbox' class='division' value='no_data' id='div_no_data' onclick="get_data_department('department',this.value)" <?php foreach ($e_division as $d) { if($d=='no_data') { echo "checked"; } }?> disabled>No division for this company</div>
			                  <?php } else{?>
			                  
			                  <?php foreach($division as $row){ ?>
			                 <div class='col-md-6'>  <input type='checkbox' class='division' id='div<?php echo $i?>' value='<?php echo $row->division_id?>' onclick="get_data_department('department',this.value)" <?php foreach ($e_division as $d) { if($d==$row->division_id) { echo "checked"; } }?> disabled ><?php echo $row->division_name?></div>
 
			                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_division' value='".$i."'></div>";?>
			                  
			                  </div>
                         </div>
				      
				      	<div class="col-md-12" id='department' style="padding-top: 15px;">
				      	<?php  $department = $this->employee_account_management_model->get_department('update',$u_division,$u_company);  ?>
				         <div class="col-md-3">Department :</div>
					            <div class="col-md-9">
					              <?php $i= 0; if(empty($department)){?>
					                      <label>No department Added.</label></div>
					                  <?php } else{?>
					                   
					                  <?php foreach($department as $row){ ?>
					                 <div class='col-md-6'>  <input type='checkbox' class='departments' id='div<?php echo $i?>' value='<?php echo $row->department_id?>' onclick="get_data_section('section',this.value)" <?php foreach($e_department as $dd){ if($dd==$row->department_id) { echo "checked"; } else{}} ?> disabled><?php echo $row->dept_name?></div>

					            <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_department' value='".$i."'></div>";?>
					          </div>
				     	</div>

				     	<div class="col-md-12" id='section' style="padding-top: 15px;">
				     	<?php $section = $this->employee_account_management_model->get_section('update',$u_department,$u_company,$u_division); ?>
				            <div class="col-md-3">Section :</div>
					            <div class="col-md-9">
					              <?php $i= 0; if(empty($section)){?>
					                      <label>No Section Added.</label></div>
					                  <?php } else{?>
					                  
					                  <?php foreach($section as $row){ ?>
					                 <div class='col-md-6'>  <input type='checkbox' class='sections' id='div<?php echo $i?>' value='<?php echo $row->section_id?>' onclick="get_data_subsection('subsection',this.value)" <?php foreach($e_section as $s){ if($s==$row->section_id) { echo "checked"; } else{}} ?> disabled><?php echo $row->section_name?></div>

					            <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_section' value='".$i."'></div>";?>
					          </div>
				      	</div>

				     	<div class="col-md-12" id='subsection' style="padding-top: 15px;">
				     	<?php 	
				     			$subsection = $this->employee_account_management_model->get_subsection('update',$u_section,$u_company,$u_division,$u_department); 
								$classification 	= $this->employee_account_management_model->get_company_classification($u_company);
								$employment = $this->general_model->employmentList();
								$location = 	$this->employee_account_management_model->get_company_location($u_company);?>
				         	<div class="col-md-3">SubSection :</div>
					            <div class="col-md-9">
					              <?php $i= 0; if(empty($subsection)){?>
					                      <label>No SubSection Added.</label></div>
					                  <?php } else{?>
					                  
					                  <?php foreach($subsection as $row){ ?>
					                 <div class='col-md-6'>  <input type='checkbox' class='subsections' id='div<?php echo $i?>' value='<?php echo $row->subsection_id?>' onclick="get_data_sub_val(this.value)" <?php foreach($e_subsection as $ss){ if($ss==$row->subsection_id) { echo "checked"; } else{}} ?> disabled><?php echo $row->subsection_name?></div>

					            <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_subsection' value='".$i."'></div>";?>
					          </div>
					          <br>
					        <div class="col-md-12"  style="padding-top: 15px;">
					           <div class="col-md-3" >Location :</div>
					                  <div class="col-md-9" style="padding-top: 15px;">
					                  <?php $i= 0; if(empty($location)){?>
					                         <label>No Location Found</label></div>
					                  <?php } else{?>
					                   
					                  <?php foreach($location as $row){ ?>
					                 <div class='col-md-6'>  <input type='checkbox' class='location' id='div<?php echo $i?>' value='<?php echo $row->location_id?>' <?php foreach($e_location as $l){ if($l==$row->location_id) { echo "checked"; } else{}} ?> disabled ><?php echo $row->location_name?></div>

					                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_location' value='".$i."'></div>";?>
					                  </div>
					                 </div>
					          <div>
					            <div class="col-md-12"  style="padding-top: 15px;">
					            <div class="col-md-3" >Classification :</div>
					                  <div class="col-md-9" style="padding-top: 15px;">
					                  <?php $i= 0; if(empty($classification)){?>
					                       <label>No Classification Found</label></div>
					                  <?php } else{?>
					                 
					                  <?php foreach($classification as $row){ ?>
					                 <div class='col-md-6'>  <input type='checkbox' class='classification' id='div<?php echo $i?>' value='<?php echo $row->classification_id?>' <?php foreach($e_classification as $c){ if($c==$row->classification_id) { echo "checked"; } else{}} ?> disabled><?php echo $row->classification?></div>

					                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_classification' value='".$i."'></div>";?>
					                  </div>
					                 </div>
					              </div>
					          <div>
					            <div class="col-md-12"  style="padding-top: 15px;">
					                <div class="col-md-3">Employement :</div>
					                  <div class="col-md-9" style="padding-top: 15px;">
					                  <?php $i= 0; if(empty($employment)){?>
					                       <label>No Employment Found</label></div>
					                  <?php } else{?>
					                  
					                  <?php foreach($employment as $row){ ?>
					                 <div class='col-md-6'>  <input type='checkbox' class='employment' id='div<?php echo $i?>' value='<?php echo $row->employment_id?>' <?php foreach($e_employment as $e){ if($e==$row->employment_id) { echo "checked"; } else{}} ?> disabled><?php echo $row->employment_name?></div>

					                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_employment' value='".$i."'></div>";?>
					                  </div>
					                 </div>
					              </div>
					            <div>
					              <div class="col-md-12"  style="padding-top: 15px;">
					              <div class="col-md-3" >Employee Status :</div>
					                  <div class="col-md-9" style="padding-top: 15px;">
					                 <div class='col-md-6'><input type='checkbox' class='emp_status'  value='0' <?php foreach($e_status as $st){ if($st==0) { echo "checked"; } else{}} ?> disabled>Active</div>
					                  <div class='col-md-6'><input type='checkbox' class='emp_status' value='1' <?php foreach($e_status as $st){ if($st==1) { echo "checked"; } else{}} ?> disabled>InActive</div>
					                  </div>
					                 </div>
					              </div>
					              </div>
					        <div class='col-md-12' style="padding-top: 15px;">
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>

								<button class='btn btn-success pull-right' id='save_disable' onclick="updateform_notif_all('One_emp',<?php echo $company_id?>);" style='margin-left: 5px;'>UPDATE</button>	
<?php
}
?>

							</div>
				      	</div>
				    <?php } ?>

	<!-- end of foreach -->
	<?php } } ?>
<!-- if company has no existing data -->
<?php } else{?>
			<?php  if($action=='notif_option_choices') {?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Viewing Action:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
				    <select class="form-control" id='notif_option_res' onchange='notif_action("notif_option_action",<?php echo $account_management_policy_id?>,this.value);'>
				      <option selected disabled>Select Option</option>
				        <option value="All">All</option>
				        <option value="Multi">Multiple Company</option>
				        <option value="One_emp">One Company by Employment Details</option>
				        <option value="One_specs">One Company by Employee Specifics</option>    
				    </select>
				</div>
			<?php } elseif($action=='notif_option_action') { 
				if($notif_option=='All'){
			?>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' onkeypress="return isNumberKey(this, event);" id='notif_days_view'>
				</div>
				<div class='col-md-12'>
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>
					<button class='btn btn-success pull-right' id='save_disable' onclick="save_notifdata_all('All',<?php echo $account_management_policy_id?>);" style='margin-left: 5px;'>Save</button>	
<?php
}
?>

				</div>
			<?php } elseif($notif_option=='Multi') {?>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Select Company:</label>
				</div>
				<div class="col-md-9">
					 <?php 
					 	$count = 0; 
					 	foreach($companyList as $n){?>
				          <div class='col-md-6'>
				            <input type="checkbox" class="n_company"  value="<?php echo $n->company_id; ?>" >
				          <n class='text-danger'><?php echo $n->company_name; ?></n><br>
				          </div>
			          <?php $count = $count + 1;  } echo "<input type='hidden' id='count' value='".$count."'>"; ?>
		        </div>
				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' onkeypress="return isNumberKey(this, event);" id='notif_days_view'>
				</div>
				<div class='col-md-12'>
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>

					<button class='btn btn-success pull-right' id='save_disable' onclick="save_notifdata_multi('Multi',<?php echo $account_management_policy_id?>);" style='margin-left: 5px;'>Save</button>	
<?php
}
?>

				</div>

			<?php } elseif($notif_option=='One_specs') { ?>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' onkeypress="return isNumberKey(this, event);" id='notif_days_view'>
				</div>
				<div class='col-md-12'>
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>

					<button class='btn btn-success pull-right' id='save_disable' onclick="save_notifdata_all('One_specs',<?php echo $account_management_policy_id?>);" style='margin-left: 5px;'>Save</button>	
<?php
}
?>

				</div>

			<?php } elseif($notif_option=='One_emp') { ?>

				<div class="col-md-3" style="padding-bottom: 10px;">
				    <label>Days to View Notification:</label>
				</div>

				<div class="col-md-9" style="padding-bottom: 10px;">
					<input type='text' class='form-control' onkeypress="return isNumberKey(this, event);" id='oneemp_days_view'>
				</div>
					<input type="hidden" id='subsection_value'>
					<input type="hidden" id='section_value'>
					<input type="hidden" id='department_value'>
					<input type="hidden" id='division_value'>
				    <input type="hidden" id="company_id" value="<?php echo $company_id?>">
				     <input type="hidden" id="company_id_fetch" >
				     </div>
				  <div class="col-md-12">
				     	<div class="col-md-3" style="padding-bottom: 10px;">
                                <label>Select Company:</label>
                            </div>

                            <div class="col-md-9" style="padding-bottom: 10px;">
                              <select class="form-control" id='compp' onchange='fetch_company("division",this.value)'>
                              <option selected disabled>Select Company</option>
                               <?php foreach($companyList as $row_c){?>
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
<?php
if($edit_201_settings=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>

						<button class='btn btn-success pull-right' id='save' onclick="save_notifdata_one_emp('insert','One_emp','<?php echo $account_management_policy_id?>');" style='margin-left: 5px;'>Save</button>	
<?php
}
?>

					</div>
			<?php }	}  ?>
<?php } ?>