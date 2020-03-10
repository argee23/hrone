              <?php 
  if($options=='division')
    {?>
              <div class="form-group">
                <label for="division">Division</label>
                  <br>
                  <?php if(empty($divisionList)){?>
                  <div class="col-md-9">No division for this company</div>
                  <div class='col-md-1'> <input type='checkbox' onclick="no_division()" class="no_division" name="division" value="0"></div>
                  <?php } else{?>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_division" onclick="all_division()"></div><br>
                  
                  <?php
                  foreach ($divisionList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->division_name?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="division" onclick="uncheck_division()" name="division[]" value="<?php echo $row->division_id?>"></div><br>
                  <?php 
                  }} 
                  ?>
              </div>
<?php }

 if($options=='department')
  { ?>
              <div class="form-group">
                <?php if($divisionList == ''){?>
                  <!-- <label>No division for this company. Please select department.</label><br> -->
                  <input type="hidden" name="division" value="0">
                  <?php } ?>
                <label for="department">Department</label>
                  <br>
                  <?php if(empty($departmentList)){?>
                      <label>No department Added.</label><br>
                      <input type="hidden" name="department" value="0">
                      <input type="hidden" name="section" value="0">
                      <input type="hidden" name="subsection" value="0">
                  <?php } else{?>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_department" onclick="all_department()"></div><br>
                  
                  <?php
                  foreach ($departmentList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->dept_name?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="department" onclick="uncheck_department()" name="department[]" value="<?php echo $row->department_id?>"></div><br>
                  <?php 
                  }}
                  ?>
              </div>
  <?php }

  else if($options=='section')
  { ?>
              <div class="form-group">
                <label for="section">Section</label>
                  <br>
                  <?php if(empty($sectionList)){?>
                      <label>No Section Added.</label><br>
                      <input type="hidden" name="section" value="0">
                      <input type="hidden" name="subsection" value="0">
                  <?php } else{?>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_section" onclick="all_section()"></div><br>
                  
                  <?php
                  foreach ($sectionList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->section_name?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="section" onclick="uncheck_section()" name="section[]" value="<?php echo $row->section_id?>"></div><br>
                  <?php 
                  }}
                  ?>
              </div>
  <?php }

  else if($options=='subsection')
    { ?>

      <div class="form-group">
                <label for="subsection">Subsection</label>
                  <br>
                  <?php if(empty($subSectionList)){?>
                      <label>No SubSection Added.</label>
                      <input type="hidden" name="subsection" value="0">
                  <?php } else{?>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_subsection" onclick="all_subsection()"></div><br>
                  
                  <?php
                  foreach ($subSectionList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->subsection_name?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="subsection" onclick="uncheck_subsection()" name="subsection[]" value="<?php echo $row->subsection_id?>"></div><br>
                  <?php 
                  }}
                  ?>
              </div>
      <?php }

    if($options=='classification')
    { ?>
      <div class="form-group">
                <label for="classification">Classification</label>
                  <br>
                  <?php if(empty($classificationList)){ 
                   ?>
                       <label>No Classification Found</label>
                       
                  <?php } else{?>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_classification" onclick="all_classification()"></div><br>
                  
                  <?php
                  foreach ($classificationList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->classification?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="classification" onclick="uncheck_classification()" name="classification[]" value="<?php echo $row->classification_id?>"></div><br>
                  <?php 
                  }}
                  ?>
              </div>
      <?php }

      if($options=='location')
    { ?> 
      <div class="form-group">
                <label for="location">Location</label>
                  <br>
                  <?php if(empty($locationList)){?>
                       <label>No Location Found</label>
                  <?php } else{?>
                  <div class="col-md-9">All : </div>
                  <div class="col-md-1"><input type="checkbox" class="all_location" onclick="all_location()"></div><br>
                  
                  <?php
                  foreach ($locationList as $row) 
                  { 
                  ?>
                    <div class="col-md-9"><?php echo $row->location_name?> : </div>
                    <div class="col-md-1"><input type="checkbox" class="location" onclick="uncheck_location()" name="location[]" value="<?php echo $row->location_id?>"></div><br>
                  <?php 
                  }}
                  ?>
              </div>
      <?php } ?>

