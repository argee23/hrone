
<div class="row">
  <div class="col-md-10">
    <div class="panel panel-success">
      <div class="panel-heading"><strong>Edit Announcement</strong></div>
        <div class="panel-body">
          <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/file_maintenance/update_announcement">
          <div class="form-horizontal">
            <div id="msg-alert"></div>
            <h3 class="text-primary">Announcement Information</h3>
            <hr>
            <input type="hidden" name="announcement_id" id="announcement_id" value="<?php echo $announcement_details->announcement_id; ?>">

            <div class="form-group">
              <label for="edit_title" class="col-sm-2 control-label">Title:</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="edit_title" name="edit_title" value="<?php echo $announcement_details->announcement_title; ?>">
              </div>
            </div>
            
            <div class="form-group">
              <label for="edit_date_from" class="col-sm-2 control-label">Date From:</label>
              <div class="col-md-8">
                <input type="date" class="form-control" id="edit_date_from" name="edit_date_from" value="<?php echo $announcement_details->date_from; ?>">
              </div>
            </div>
            
            <div class="form-group">
              <label for="edit_date_to" class="col-sm-2 control-label">Date To:</label>
              <div class="col-md-8">
                <input type="date" class="form-control" id="edit_date_to" name="edit_date_to" value="<?php echo $announcement_details->date_to; ?>">
              </div>
            </div>
            
            <div class="form-group" >
              <label for="edit_details" class="col-sm-2 control-label">Details:</label>
              <div class="col-md-8">
                <textarea class="form-control" rows="3" id="edit_details" name="edit_details"><?php echo $announcement_details->announcement_details; ?></textarea>
              </div>
            </div>
            
            <div class="form-group" >
              <label for="edit_attach_file" class="col-sm-2 control-label">Attach File:</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="edit_attach_file" name="edit_attach_file" value="<?php echo $announcement_details->file_name; ?>" disabled>
              </div>
            </div>
          </div>

            <hr>
            <h3 class="text-primary">Other Information</h3>
            <hr>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit_company">Company:</label>
                    <br>
                    <div class="col-md-9">All : </div>
                    <div class="col-md-1"><input type="checkbox" onclick="all_company()" class="all_company"></div><br>
                    
                    <?php
                    foreach ($companyList as $row)
                    {
                    ?>
                      <div class="col-md-9"><?php echo $row->company_name?> : </div>
                      <div class="col-md-1"><input class="company" onclick="uncheck_company()" type="checkbox" name="edit_company[]" value="<?php echo $row->company_id?>" 
                      <?php foreach($announcement_fields as $val) 
                      { 
                        if($val->id == $row->company_id && $val->table_name == 'company') 
                        { 
                          echo "checked";
                        } else{}
                      }?> ></div><br>
                    <?php
                    }
                    ?>
                </div>
              </div>

              <div class="col-md-6" id="division">
                <div class="form-group">
                  <!-- <label for="edit_division">Division:</label>
                    <br>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_division" onclick="all_division()"></div><br>
                  
                  <?php
                  foreach ($divList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->division_name?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="division" onclick="uncheck_division()" name="edit_division[]" value="<?php echo $row->division_id?>"
                      <?php foreach($announcement_fields as $val) 
                      { 
                        if($val->id == $row->division_id && $val->table_name == 'division') 
                        { 
                          echo "checked";
                        } else{}
                      }?> ></div><br>
                  <?php 
                  } 
                  ?> -->
                  <label for="division">Division:</label>
                  <br>
                  <?php foreach($announcement_fields as $val) 
                      {
                        if($val->id == 0 && $val->table_name == 'division') 
                        { ?>
                          <div class="col-md-9">No division for this company</div>
                          <div class='col-md-1'> <input type='checkbox' onclick="no_division()" class="no_division" checked disabled>
                            <input type="hidden" name="division" value="0"></div>

                       <?php }
                        elseif($val->table_name == 'division')
                        { ?>
                          <div class="col-md-9"><?php echo $val->division_name?> : </div>
                          <div class="col-md-1"><input type="checkbox" class="division" onclick="uncheck_division()" checked disabled>
                            <input type="hidden" name="division[]" value="<?php echo $val->division_id?>"></div><br>
                          <?php
                        } else{}}
                        ?>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6" id="department">
                <div class="form-group">
                 <!-- <label for="edit_department">Department:</label>
                    <br>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_department" onclick="all_department()"></div><br>
                  
                  <?php
                  foreach ($departmentList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->dept_name?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="department" onclick="uncheck_department()" name="edit_department[]" value="<?php echo $row->department_id?>"
                    <?php foreach($announcement_fields as $val) 
                      { 
                        if($val->id == $row->department_id && $val->table_name == 'department') 
                        { 
                          echo "checked";
                        } else{}
                      }?> ></div><br>
                  <?php 
                  } 
                  ?>
                </div> -->
                <label for="department">Department:</label>
                  <br>
                  <?php foreach($announcement_fields as $val) 
                      {
                        if($val->id == 0 && $val->table_name == 'department') 
                        { ?>
                          <!-- <div class="col-md-9">No division for this company</div>
                          <div class='col-md-1'> <input type='checkbox' onclick="no_division()" class="no_division" name="edit_division" value="0" checked disabled></div> -->
                          <label>No department Added.</label><br>
                          <input type="hidden" name="department" value="0">
                       <?php }
                        elseif($val->table_name == 'department')
                        { ?>
                          <div class="col-md-9"><?php echo $val->dept_name?> : </div>
                          <div class="col-md-1"><input type="checkbox" class="department" onclick="uncheck_department()" checked disabled>
                            <input type="hidden" name="department[]" value="<?php echo $val->department_id?>"></div><br>
                          <?php
                        } else{}}
                        ?>
                  </div>
              </div>

              <div class="col-md-6" id="section">
                <!-- <div class="form-group">
                  <label for="edit_section">Section:</label>
                    <br>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_section" onclick="all_section()"></div><br>
                  
                  <?php
                  foreach ($secList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->section_name?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="section" onclick="uncheck_section()" name="edit_section[]" value="<?php echo $row->section_id?>"
                    <?php foreach($announcement_fields as $val) 
                      { 
                        if($val->id == $row->section_id && $val->table_name == 'section') 
                        { 
                          echo "checked";
                        } else{}
                      }?> ></div><br>
                  <?php 
                  } 
                  ?>
                </div> -->
                <div class="form-group">
                  <label for="section">Section:</label>
                    <br>
                    <?php foreach($announcement_fields as $val) 
                      {
                        if($val->id == 0 && $val->table_name == 'section') 
                        { ?>
                          <label>No Section Added.</label><br>
                          <input type="hidden" name="section" value="0">
                       <?php }
                        elseif($val->table_name == 'section')
                        { ?>
                          <div class="col-md-9"><?php echo $val->section_name?> : </div>
                          <div class="col-md-1"><input type="checkbox" class="section" onclick="uncheck_section()" checked disabled>
                            <input type="hidden" name="section[]" value="<?php echo $val->section_id?>"></div><br>
                          <?php
                        } else{}}
                        ?>
                  </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-6" id="subsection">
                <div class="form-group">
                  <!-- <label for="edit_subsection">Subsection:</label>
                    <br>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_subsection" onclick="all_subsection()"></div><br>
                  
                  <?php
                  foreach ($subSecList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->subsection_name?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="subsection" onclick="uncheck_subsection()" name="edit_subsection[]" value="<?php echo $row->subsection_id?>"
                    <?php foreach($announcement_fields as $val) 
                      { 
                        if($val->id == $row->subsection_id && $val->table_name == 'subsection') 
                        { 
                          echo "checked";
                        } else{}
                      }?> ></div><br>
                  <?php 
                  } 
                  ?> -->
                  <label for="subsection">Subsection:</label>
                    <br>
                  <?php foreach($announcement_fields as $val) 
                      {
                        if($val->id == 0 && $val->table_name == 'subsection') 
                        { ?>
                          <label>No SubSection Added.</label>
                      <input type="hidden" name="subsection" value="0">
                       <?php }
                        elseif($val->table_name == 'subsection')
                        { ?>
                          <div class="col-md-9"><?php echo $val->subsection_name?> : </div>
                          <div class="col-md-1"><input type="checkbox" class="subsection" onclick="uncheck_subsection()" checked disabled>
                            <input type="hidden" name="subsection[]" value="<?php echo $val->subsection_id?>"></div><br>
                          <?php
                        } else{}}
                        ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <hr>
              <button type="button" class="btn btn-danger pull-right" onclick="announcement_company()">Back</button>
              <button type="submit" class="btn btn-primary pull-right">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-6" id="col_3">
    </div>
  </div>