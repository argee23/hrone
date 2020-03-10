<div class="col-md-4">
      <div class="box box-danger">
    <div class="box-header">
<i class="fa fa-plus text-danger"></i>Add
    </div>
  <div class="box-body">
<div class="col-md-12">

<form name="f1" method="post" action="<?php echo base_url()?>app/transaction_employees/save_filer" >

          <div class="form-group">
                          <label for="years_bracket">Select Transaction Form</label>
                          <select class="form-control select2" name="form" id="t_form" onchange="active_transaction()" required>
                            <option selected="selected" value="" disabled>-Select Transaction Forms-</option>
                            <option value="all"> All </option>                          
                              <?php 
                              foreach($transactionsList as $forms){
                                echo "<option value='".$forms->identification."' >".$forms->form_name."</option>";
                              }
                              ?>
                          </select>                        
          </div>
          <div class="form-group">
                          <label for="years_bracket">Select Location</label>
                          <select class="form-control select2" name="location" id="location" onchange="active_transaction()" required>
                            <option selected="selected" value="" disabled>-Select Locations-</option>
                            <option value="all"> All </option>                          
                              <?php 
                              $loc = $this->transaction_employees_model->getLoc();
                              foreach($loc as $location){
                                echo "<option value='".$location->location_id."' >".$location->location_name."</option>";
                              }
                              ?>
                          </select>                        
          </div>
			<div class="form-group">
				<label for="classification">Select Classification</label>
				<select class="form-control select2" name="classification" id="classification" onchange="active_transaction()" required>
				<option selected="selected" value="" disabled>-Select Classification-</option>
				<option value="all" selected="selected"> All</option>                          
				<?php 
				foreach($classificationList as $class){
				echo "<option value='".$class->classification_id."' >".$class->classification."</option>";
				}
				?>
				</select>     
			</div>	
			<div class="form-group">
				<label for="department">Select Department</label>
				<select class="form-control select2" name="department" id="department_add" onchange="get_section();active_transaction()" required>
				<option value=""  selected="selected" disabled>-Select Department-</option>                          
				<option value="all">All</option>
				<?php 
				foreach($departmentList as $dpt){
				echo "<option value='".$dpt->department_id."' >".$dpt->dept_name."</option>";
				}
				?>
				</select>                        
			</div>
			<div class="form-group" id="show_section">
			</div>		
			<div class="form-group" id="show_selected_emp">
			<label for="select_assigned_filing"><a type="button" class="btn btn-success btn-xs pull-left" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;[Select Employee]</label>
			<a data-toggle="modal" data-target="#showEmployeeList"><input type="text" class="form-control" placeholder="Select Employee" ></a>
			</div><!-- 
			<div class="form-group" >
				<label for="option">Option</label>
				<select class="form-control select2" name="option" id="option_add" required>
				<option value="this_form">Apply only to this form</option>
				<option value="all">Apply to all form</option>	
				</select>
			</div> -->
				<button type="submit" class="btn btn-primary pull-right btn-md" ><i class="fa fa-save"></i> Save</>
				</button>
	</form>
<!-- here --></div>

                    
  </div>

      </div>
</div>
<!--//======================================Employee List Modal Container ==============================//-->
<div class="modal modal-primary fade" id="showEmployeeList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Select Employee</h4>
                </div>
          <div class="modal-body">
                                           
  <input onKeyUp="getEmployeeList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                        <span id="showSearchResult">                        </span>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>                          
                  </div>
                </div>
            </div><!-- /.box-body -->
<!--//====================================== End Employee List Modal Container ==============================//-->
<div class="col-md-8">
      <div class="box box-info">
    <div class="box-header">
<i class="fa fa-file-archive-o text-danger"></i>Assigned Employee For Transaction Filing
    </div>
  <div class="box-body" id="show_filing_assigned">




  </div>
  </div>
  </div>