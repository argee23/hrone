<div class="col-md-12">
      <div class="box box-danger">
    <div class="box-header">
Mass Transaction Encoding
    </div>
  <div class="box-body">
<div class="col-md-12">

<form name="f1" target="_blank" method="post" action="<?php echo base_url()?>app/transaction_employees/mass_tran_enc" >

          <div class="form-group">
                          <label for="years_bracket">Select Transaction Form</label>
                          <select class="form-control select2" name="form" id="t_form" required>
                            <option selected="selected" value="" disabled>-Select Transaction Forms-</option>                    
                              <?php 
                               $the_form=$this->transaction_employees_model->get_form_with_mass_encoding();
                              foreach($the_form as $forms){
                                echo "<option value='".$forms->identification."' >".$forms->form_name."</option>";
                              }
                              ?>
                          </select>                        
          </div>
          <div class="form-group">
                          <label for="years_bracket">Select Location</label>
                          <select class="form-control select2" name="location" id="location" required>
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
				<select class="form-control select2" name="classification" id="classification" required>
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
			<div class="form-group" id="show_section"></div>	

			<div class="form-group">
				<label for="date_from">Date From </label>
				<input type="date" name="date_from" class="form-control" required>    
			</div>
			<div class="form-group">
				<label for="date_to">Date To </label>
				<input type="date" name="date_to" class="form-control" required>    
			</div><!-- 
			<div class="form-group">
				<label for="mass_encode_option">Export to Excel </label>
				<select class="form-control select2" name="mass_encode_option" required>
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>  
			</div> -->
			
			<button type="submit" class="btn btn-danger pull-left btn-md" ><i class="fa fa-arrow-right"></i> Proceed</></button>
	</form>
<!-- here --></div>

                    
  </div>

      </div>
</div>
