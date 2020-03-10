  <div class="col-md-3">

                     <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Notifications:</label></div>
                              <div class="col-md-12">
                                     <select class="form-control" id='generate_notification' onchange="get_generate_crystal_reports(this.value);">
		                                  <?php if(empty($notifications)){ echo "<option value=''>No Notification found.</option>";}
		                                  else{ echo "<option value='' disabled selected>Select Notification</option>"; foreach($notifications as $notif){?>
		                                  <option value="<?php echo $notif->id;?>"><?php echo $notif->form_name;?></option>
		                                  <?php }} ?>
                                     </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Crystal Report:</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='generate_crystal_report'>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Status</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='status' onchange="check_status_filter(this.value,'status_view')">
                                        <option value="all">All</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                           </div>
                    </div>
                    
                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Status View</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='status_view'>
                                        <option value="all">all</option>
                                        <option value="v">viewed</option>
                                        <option value="a">acknowledge</option>
                                        <option value="nv">not yet viewed</option>
                                        <option value="na">not yet acknowledge</option>

                                    </select>
                           </div>
                    </div>
                    <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Date Range</label></div>
                            <div class="col-md-12"><input type="checkbox" onclick="disabled_date();">&nbsp;All</div>
                              <div class="col-md-12">
                                    <input type="hidden" id="date_range" value='0'>
                                    <input type="date" id="date_from" class="form-control"><br>
                                    <input type="date" id="date_to" class="form-control">
                           </div>
                    </div>
                      <div class="col-md-12" style="padding-top:10px;">
                            <div class="col-md-12"><label>Employees</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='employee' onchange="check_employee_filter(this.value);">
                                      <option value="one">By employee</option>
                                      <option value="all">All Employees</option>
                                    </select>
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;" id="one_employee">
                            <div class="col-md-12"><label>Employee Name</label></div>
                              <div class="col-md-12">
                                  <a data-toggle="modal" data-target="#search_employee_modal"><input type="text" class="form-control" id="employee_name"></a>
                                  <input type="hidden" id="employee_id">
                           </div>
                    </div>

                    <div class="col-md-12" style="padding-top:10px;display: none;" id="sdepartment" >
                            <div class="col-md-12"><label>Department</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='department' onchange="get_section(this.value);">
                                    <?php
                                    	if(empty($departments))
                                    	{
                                    		echo "<option value=''>No department found.</option>";
                                    	}
                                    	else
                                    	{
                                    		echo "<option value=''>Select Department</option>";
                                    		foreach($departments as $dp)
                                    		{
                                    			echo "<option value='".$dp->department."'>".$dp->dept_name."</option>";
                                    		}
                                    	}
                                    ?>
                                    </select>
                           </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="ssection">
                            <div class="col-md-12"><label>Section</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='section' onchange="get_subsection(this.value);">
                                    </select>
                           </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="ssubsection">
                            <div class="col-md-12"><label>Subsection</label></div>
                              <div class="col-md-12">
                                    <select class="form-control" id='subsection'>
                                    </select>
                           </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="slocation">
                            <div class="col-md-12"><label>Location</label></div>
                              <div class="col-md-12" id="location">
                                <?php if(empty($locations)){ echo "<n class='text-danger'>No location/s found.</n>";}
					               else{ $i=0; foreach($locations as $loc) { ?>  
					                 <div class="col-md-12"> <input type="checkbox" class="res_location" id="location_<?php echo $i;?>" value="<?php echo $loc->location;?>" checked> <?php echo $loc->location_name;?></div>
					            <?php $i++; } echo "<input type='hidden' value='".$i."' id='count_location'>"; }?>
                            </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="sclassification">
                            <div class="col-md-12"><label>Classification</label></div>
                              <div class="col-md-12" id="classification">
                                  <?php if(empty($classifications)){ echo "<n class='text-danger'>No classification/s found.</n>";}
					               else{ $ii=0; foreach($classifications as $class) { ?>  
					                 <div class="col-md-12"> <input type="checkbox" class="res_classification" id="classification_<?php echo $ii;?>" value="<?php echo $class->classification_id;?>" checked> <?php echo $class->classification;?></div>
					            <?php $ii++; } echo "<input type='hidden' value='".$ii."' id='count_classification'>"; }?>   
                           </div>
                    </div>

                      <div class="col-md-12" style="padding-top:10px;display: none;" id="semployment">
                            <div class="col-md-12"><label>Employment</label></div>
                              <div class="col-md-12" id="employment">
                                    <?php if(empty($employmentList)){ echo "<n class='text-danger'>No employment/s found.</n>";}
						               else{ $ii=0; foreach($employmentList as $emp) { ?>  
						                 <div class="col-md-12"> <input type="checkbox" class="res_employment" id="emp_<?php echo $ii;?>" value="<?php echo $emp->employment_id;?>" checked> <?php echo $emp->employment_name;?></div>
						            <?php $ii++; } echo "<input type='hidden' value='".$ii."' id='count_employment'>"; }?> 
                          	 </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px;">
                      <div class="col-md-12"><button class="bt btn-success form-control" onclick="filter_report();">FILTER</button></div>
                    </div>
          </div>

<div class="col-md-9" id="crystal_report_action" style="overflow: scroll;">
    <table class="col-md-12 table table-hover" id="crystal_reports">
      <thead>
           <tr class="danger">
              <th>No.</th>
              <th>Report ID</th>
              <th>Report Name</th>
              <th>Report Description</th>
              <th>Fields</th>
              <th>Action</th>
            </tr>
       </thead>
        <tbody>

       </tbody>
    </table>
</div>