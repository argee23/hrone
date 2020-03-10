<div class="jumbotron" style="height: 450px;">
  	<div class="col-sm-4">
      <div class="box box-solid box-success">
    <h4 class='text-danger' style="font-weight: bold;"><u><center>Update Group Details</center></u></h4>
      <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
      		<div class="col-md-12 form-group">
  				<label for="usr">Group Name:</label>	
  				<input type="text" class="form-control" name="usr" id="group_name" value="<?php echo $group?>">
			</div>
	    	<div class="col-md-12 form-group">
  				<label for="usr">Select Section:</label>	
  				<select class="form-control" id="section_list">
  						  <?php foreach ($section_list as $section) {?>
                  <option value="<?php echo $section->section_id?>" selected><?php echo $section->section_name?></option>
                <?php } ?>
  				</select>
			</div>

			<div class="col-md-12 form-group" >
  				<label for="usr">Select Subsection:</label>
  				<select class="form-control" id="subsection_list">
             <?php foreach ($subsection_list as $subsection) {?>
                  <option value="<?php echo $subsection->subsection_id?>" selected><?php echo $subsection->subsection_name?></option>
                <?php } ?>
          </select>
			</div>
		</div>
      </div>
	</div>

<div class='col-md-8'>
   <div class="box box-solid box-default">
      <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
      		<div class="col-md-12" id="employee_list">
              <?php if(!empty($employee_list) AND  $employee_list!='no_setting' ){?>
              <h3 class="text-danger"><center><u>Select Atleast one member to continue.</u></center></h3>
              <br>
              <table class="table table-hover" id='mimimi'>
              <thead>
                <tr class="danger">
                  <th><input type="checkbox" onclick="checkbox_stat();" id="checkbox_stat"></th>
                  <th>Name</th>
                  <th>Location</th>
                  <th>Position</th>
                  <th>Classification</th>
                </tr>
              </thead>
              <tbody>
             <?php $i=0; foreach ($employee_list as $row) {?>
              <tr>
                <td><input type="checkbox" value="<?php echo $row->employee_id?>" class="employee_list" id='employee_id<?php echo $i?>' 
                <?php foreach($employee_list_selected as $selected){ if($selected->employee_id==$row->employee_id){ echo "checked"; } else{}   } ?>></td>
                <td><?php echo $row->fullname?></td>
                <td><?php echo $row->location_name?></td>
                <td><?php echo $row->position_name?></td>
                <td><?php echo $row->cname?></td>
              </tr>
            <?php $i = $i+1;} echo "<input type='hidden' id='employeecount' value='".$i."'>"; ?>
              </tbody>
              </table>
              <div class="pull-right">
                <button type="button" class="btn btn-success" onclick="save_updated_group('<?php echo $group_id; ?>','<?php echo $has_division; ?>','<?php echo $division; ?>','<?php echo $department; ?>');">Save Changes</button>
               <a href="<?php echo base_url().'employee_portal/section_mngr_management/groups/' . $has_division . '/' . $division . '/' . $department; ?>" class="btn btn-danger" data-dismiss="modal">Back</a>
              </div>
              <?php } else{ ?>
              <br><br>
                <h3 class="text-danger"><center>No Results Found.</center></h3>
                <a href="<?php echo base_url().'employee_portal/section_mngr_management/groups/' . $has_division . '/' . $division->division . '/' . $dept->department; ?>" class="btn btn-danger" data-dismiss="modal">Back</a>
              <?php } ?>
              			    </div>
              	     </div>
              	</div>
</div>

</div>