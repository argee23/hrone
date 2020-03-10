<?php 
$company_id = $this->uri->segment('4');
$group_id = $this->uri->segment('5'); 
?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
			<div class="panel panel-success">

				<div class="panel-heading"><strong><?php echo $group_info->group_name; ?></strong>
				<a onclick="view_group_employee('<?php echo $this->uri->segment("5"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="View Employee list"><i class="fa fa-arrow-circle-left fa-2x text-danger pull-right"></i></a>
				</div>
			</div>
			<div class="panel panel-body">
			<form method="post" action="<?php echo base_url()?>app/time_fixed_schedule/saveGroupMember/<?php echo $group_id;?>" target="_blank">
			  	  	<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
			  	  	<input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id; ?>">	
			<?php
			if($company_isDiv=="1"){
			?>
<div class="col-md-3">
<div class="form-group">
<label >Division</label>
<select class="form-control" name="division" id="division" onchange="getDepartment(this.value); applyFilterdivision(this.value);">
<option selected="selected" value="All">All</option>
<?php 
foreach($company_division as $division ){
if($_POST['division_employee'] == $division->division_id){
$selected = "selected='selected'";
}else{
$selected = "";
}
?>
<option value="<?php echo $division->division_id;?>" <?php echo $selected;?>><?php echo $division->division_name;?></option>
<?php }?>
</select>
</div>
</div>

<div id="by_department">
<div class="col-md-3">
<div class="form-group">
<label for="company">Department</label>
<input type="text" name="department" id="department" class="form-control" placeholder="Department" disabled>
</div>
</div>

</div>


			<?php
			}else{
			?>
<input type="hidden" name="division" value="All">

<div class="col-md-3">
<div class="form-group">
<label for="department">Department</label>
<select class="form-control" name="department" id="department" onchange="getSection(this.value); applyFilterdepartment(this.value);">
<option selected="selected" value="All">All</option>
<?php 
foreach($company_department as $department){
if($_POST['department'] == $department->department_id){
$selected = "selected='selected'";
}else{
$selected = "";
}
?>
<option value="<?php echo $department->department_id;?>" <?php echo $selected;?>><?php echo $department->dept_name;?></option>
<?php }?>
</select>
</div>
</div>			
			<?php
			}
			?>

 			          <div id="by_section">
                       <div class="col-md-3">
                          <div class="form-group">
                          <label for="company">Section</label>
                          <input type="text" name="section" id="section" class="form-control" placeholder="Section" value="All">
                          </div>
                        </div>
                      </div>

                      <div id="by_subsection">
                        <div class="col-md-3">
                          <div class="form-group">
                          <label for="subsection">Subsection</label>
                        <select class="form-control" name="subsection" id="subsection">
                        <option selected="selected" value="All">All</option>
                        </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3">
                          <div class="form-group">
                              <label for="location">Location</label>
                              <select class="form-control select2" name="location" id="location" style="width: 100%;" onchange="applyFilterlocation(this.value);">
                                <option selected="selected" value="All">All</option>
                                <?php 
                                  foreach($company_locations as $location){
                                  if($_POST['location'] == $location->location_id){
                                      $selected = "selected='selected'";
                                  }else{
                                      $selected = "";
                                  }
                                  ?>
                                  <option value="<?php echo $location->location_id;?>" <?php echo $selected;?>><?php echo $location->location_name;?></option>
                                  <?php }?>
                              </select>
                          </div>
                          </div>
                      
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="classification">Classification</label>
                            <select class="form-control select2" name="classification" id="classification" style="width: 100%;" onchange="applyFilterclassification(this.value);">
                              <option selected="selected" value="All">All</option>
                              <?php 
                                foreach($company_classifications as $classification){
                                if($_POST['classification'] == $classification->classification_id){
                                    $selected = "selected='selected'";
                                }else{
                                    $selected = "";
                                }
                                ?>
                                <option value="<?php echo $classification->classification_id;?>" <?php echo $selected;?>><?php echo $classification->classification;?></option>
                                <?php }?>
                            </select>
                        </div>
                        </div>

                       <div class="col-md-3">
                        <div class="form-group">
                          <label>Employment Type</label>
                          <select class="form-control" name="employment" id="employment" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="All">All</option>
                            <?php 
                              foreach($employmentList as $employment){
                              if($_POST['employment'] == $employment->employment_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $employment->employment_id;?>" <?php echo $selected;?>><?php echo $employment->employment_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Taxcode</label>
                          <select class="form-control" name="taxcode" id="taxcode" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="All">All</option>
                            <?php 
                              foreach($taxcodeList as $taxcode){
                              if($_POST['taxcode'] == $taxcode->taxcode_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $taxcode->taxcode_id;?>" <?php echo $selected;?>><?php echo $taxcode->taxcode;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Pay type</label>
                          <select class="form-control" name="pay_type" id="pay_type" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="All">All</option>
                            <?php 
                              foreach($paytypeList as $paytype){
                              if($_POST['paytype'] == $paytype->pay_type_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $paytype->pay_type_id;?>" <?php echo $selected;?>><?php echo $paytype->pay_type_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Civil status</label>
                          <select class="form-control" name="civil_status" id="civil_status" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="All">All</option>
                            <?php 
                              foreach($civilStatusList as $civil_status){
                              if($_POST['civil_status'] == $civil_status->civil_status_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $civil_status->civil_status_id;?>" <?php echo $selected;?>><?php echo $civil_status->civil_status;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Gender</label>
                          <select class="form-control" name="gender_sex" id="gender_sex" style="width: 100%;" onchange="applyFilter()">
                            <option selected="selected" value="All">All</option>
                            <?php 
                              foreach($genderList as $gender){
                              if($_POST['gender'] == $gender->gender_id){
                                  $selected = "selected='selected'";
                              }else{
                                  $selected = "";
                              }
                              ?>
                              <option value="<?php echo $gender->gender_id;?>" <?php echo $selected;?>><?php echo $gender->gender_name;?></option>
                              <?php }?>
                          </select>
                        </div>
                      </div>


  <button type="submit" class="btn btn-success pull-right" style="margin-right: 50px;" ><i class="fa fa-filter"></i> FILTER EMPLOYEE</button>    

			</form>

			</div>


		</div>
	</div>
</div>

  
