<div class="col-sm-3" style="padding-top: 10px;">
  <div class="box box-solid box-default">
    <h4><center>Filtering</center></h4>
     
  <div class="col-md-12"> <div class="box box-danger" class='col-md-12'></div></div>
      <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">

      <div class="col-md-12 form-group">
          <label for="usr">Select Location:</label>
          <?php $i=0; foreach ($location as $row) { ?>
            <div class="col-md-12">  <input type="checkbox" class="location_value" id="location<?php echo $i;?>" value="<?php echo $row->location_id?>" checked>&nbsp;<?php echo $row->location_name;?> </div>
            <?php $i++;  } echo "<input type='hidden' value='".$i."' id='location_count'>"; ?>
      </div>


	    	<div class="col-md-12 form-group">
  				<label for="usr">Select Section:</label>	
  				<select class="form-control" onchange= "get_subsection(this.value);"  id="section_value">
  						<option disabled selected>Select Section</option>
  					<?php
  					foreach ($section_list as $row) { ?>
  						<option value="<?php echo $row->section_id?>"><?php echo $row->section_name;?></option>
  					<?php } ?>
  				</select>
			</div>

			<div class="col-md-12 form-group" id="subsection_list">
        
      </div>
       <input type="hidden" id="division" value="<?php echo $division_id;?>">
        <input type="hidden" id="department" value="<?php echo $department_id;?>">
        <input type="hidden" id="has_division" value="<?php echo $has_division;?>">
	</div>
  </div>
</div>

<div class='col-md-9' style="padding-top: 10px;">
   <div class="box box-solid box-default">
      <div class="box body-panel" style="height:700px;">
      		<div class="col-md-12" id="employee_list">
           <h3><center>Employee List</center></h3>
            <table class="table table-hover" id='grp'>
              <thead>
                <tr class="danger">
                  <th></th>
                  <th>Name</th>
                  <th>Location</th>
                  <th>Position</th>
                  <th>Classification</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

			</div>
	  </div>
	</div>