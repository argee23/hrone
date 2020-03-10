<?php 
  if($options=='division')
    {?>
   <div class="col-md-3">Division :</div>
                  <div class="col-md-9">
                  <?php $i= 0; if(empty($division)){?>
                       <div class='col-md-6'> <input type='checkbox' class='division' value='no_data' id='div_no_data' onclick="get_data_department('department',this.value)" >No division for this company</div>
                  <?php } else{?>
                  
                  <?php foreach($division as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='division' id='div<?php echo $i?>' value='<?php echo $row->division_id?>' onclick="get_data_department('department',this.value)" ><?php echo $row->division_name?></div>

                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_division' value='".$i."'></div>";?>
                  
                  </div>
  <?php }
  
 else if($options=='department')
  { ?>
       
          <div class="col-md-3">Department :</div>
            <div class="col-md-9">
              <?php $i= 0; if(empty($department)){?>
                      <label>No department Added.</label></div>
                  <?php } else{?>
                   
                  <?php foreach($department as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='departments' id='div<?php echo $i?>' value='<?php echo $row->department_id?>' onclick="get_data_section('section',this.value)" ><?php echo $row->dept_name?></div>

            <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_department' value='".$i."'></div>";?>
          </div>
  <?php } 

  else if($options=='section')
  { ?>
 
          <div class="col-md-3">Section :</div>
            <div class="col-md-9">
              <?php $i= 0; if(empty($section)){?>
                      <label>No Section Added.</label></div>
                  <?php } else{?>
                  
                  <?php foreach($section as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='sections' id='div<?php echo $i?>' value='<?php echo $row->section_id?>' onclick="get_data_subsection('subsection',this.value)" ><?php echo $row->section_name?></div>

            <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_section' value='".$i."'></div>";?>
          </div>
  <?php }

  else if($options=='subsection')
    { ?>
 
          <div class="col-md-3">SubSection :</div>
            <div class="col-md-9">
              <?php $i= 0; if(empty($subsection)){?>
                      <label>No SubSection Added.</label></div>
                  <?php } else{?>
                  
                  <?php foreach($subsection as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='subsections' id='div<?php echo $i?>' value='<?php echo $row->subsection_id?>' onclick="get_data_sub_val(this.value)"><?php echo $row->subsection_name?></div>

            <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_subsection' value='".$i."'></div>";?>
          </div>
          <br>
           <div class="col-md-3" style="padding-top: 15px;" >Location :</div>
                  <div class="col-md-9" style="padding-top: 15px;">
                  <?php $i= 0; if(empty($location)){?>
                         <label>No Location Found</label></div>
                  <?php } else{?>
                   
                  <?php foreach($location as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='location' id='div<?php echo $i?>' value='<?php echo $row->location_id?>' checked><?php echo $row->location_name?></div>

                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_location' value='".$i."'></div>";?>
                  </div>
                 </div>
          <br>
            <div class="col-md-3" style="padding-top: 15px;">Classification :</div>
                  <div class="col-md-9" style="padding-top: 15px;">
                  <?php $i= 0; if(empty($classification)){?>
                       <label>No Classification Found</label></div>
                  <?php } else{?>
                 
                  <?php foreach($classification as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='classification' id='div<?php echo $i?>' value='<?php echo $row->classification_id?>' checked><?php echo $row->classification?></div>

                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_classification' value='".$i."'></div>";?>
                  </div>
                 </div>
              </div>
          <br>
                <div class="col-md-3" style="padding-top: 15px;">Employement :</div>
                  <div class="col-md-9" style="padding-top: 15px;">
                  <?php $i= 0; if(empty($employment)){?>
                       <label>No Employment Found</label></div>
                  <?php } else{?>
                  
                  <?php foreach($employment as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='employment' id='div<?php echo $i?>' value='<?php echo $row->employment_id?>' checked><?php echo $row->employment_name?></div>

                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_employment' value='".$i."'></div>";?>
                  </div>
                 </div>
              </div>
              <div class="col-md-3" style="padding-top: 15px;">Employee Status :</div>
                  <div class="col-md-9" style="padding-top: 15px;">
                 <div class='col-md-6'><input type='checkbox' class='emp_status'  value='0' checked>Active</div>
                  <div class='col-md-6'><input type='checkbox' class='emp_status' value='1' checked>InActive</div>
                  </div>
                 </div>
              </div>


  <?php }
    else if($options=='update_division')
    {?>
   <div class="col-md-3">Division :</div>
                  <div class="col-md-9">
                  <?php $i= 0; if(empty($division)){?>
                       <div class='col-md-6'> <input type='checkbox' class='division' value='no_data' id='div_no_data' onclick="get_data_department('update_department',this.value)" >No division for this company</div>
                  <?php } else{?>
                  
                  <?php foreach($division as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='division' id='div<?php echo $i?>' value='<?php echo $row->division_id?>' onclick="get_data_department('update_department',this.value)" ><?php echo $row->division_name?></div>

                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_division' value='".$i."'></div>";?>
                  
                  </div>
  <?php }
  
 else if($options=='update_department')
  { ?>
       
          <div class="col-md-3">Department :</div>
            <div class="col-md-9">
              <?php $i= 0; if(empty($department)){?>
                      <label>No department Added.</label></div>
                  <?php } else{?>
                   
                  <?php foreach($department as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='departments' id='div<?php echo $i?>' value='<?php echo $row->department_id?>' onclick="get_data_section('update_section',this.value)" ><?php echo $row->dept_name?></div>

            <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_department' value='".$i."'></div>";?>
          </div>
  <?php } 

  else if($options=='update_section')
  { ?>
 
          <div class="col-md-3">Section :</div>
            <div class="col-md-9">
              <?php $i= 0; if(empty($section)){?>
                      <label>No Section Added.</label></div>
                  <?php } else{?>
                  
                  <?php foreach($section as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='sections' id='div<?php echo $i?>' value='<?php echo $row->section_id?>' onclick="get_data_subsection('update_subsection',this.value)" ><?php echo $row->section_name?></div>

            <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_section' value='".$i."'></div>";?>
          </div>
  <?php }

  else if($options=='update_subsection')
    { ?>
 
          <div class="col-md-3">SubSection :</div>
            <div class="col-md-9">
              <?php $i= 0; if(empty($subsection)){?>
                      <label>No SubSection Added.</label></div>
                  <?php } else{?>
                  
                  <?php foreach($subsection as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='subsections' id='div<?php echo $i?>' value='<?php echo $row->subsection_id?>' onclick="get_data_sub_val(this.value)"><?php echo $row->subsection_name?></div>

            <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_subsection' value='".$i."'></div>";?>
          </div>
          <br>
           <div class="col-md-3" style="padding-top: 15px;" >Location :</div>
                  <div class="col-md-9" style="padding-top: 15px;">
                  <?php $i= 0; if(empty($location)){?>
                         <label>No Location Found</label></div>
                  <?php } else{?>
                   
                  <?php foreach($location as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='location' id='div<?php echo $i?>' value='<?php echo $row->location_id?>' checked><?php echo $row->location_name?></div>

                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_location' value='".$i."'></div>";?>
                  </div>
                 </div>
          <br>
            <div class="col-md-3" style="padding-top: 15px;">Classification :</div>
                  <div class="col-md-9" style="padding-top: 15px;">
                  <?php $i= 0; if(empty($classification)){?>
                       <label>No Classification Found</label></div>
                  <?php } else{?>
                 
                  <?php foreach($classification as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='classification' id='div<?php echo $i?>' value='<?php echo $row->classification_id?>' checked><?php echo $row->classification?></div>

                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_classification' value='".$i."'></div>";?>
                  </div>
                 </div>
              </div>
          <br>
                <div class="col-md-3" style="padding-top: 15px;">Employement :</div>
                  <div class="col-md-9" style="padding-top: 15px;">
                  <?php $i= 0; if(empty($employment)){?>
                       <label>No Employment Found</label></div>
                  <?php } else{?>
                  
                  <?php foreach($employment as $row){ ?>
                 <div class='col-md-6'>  <input type='checkbox' class='employment' id='div<?php echo $i?>' value='<?php echo $row->employment_id?>' checked><?php echo $row->employment_name?></div>

                  <?php $i = $i + 1; } }  echo "<input type='hidden' id='c_employment' value='".$i."'></div>";?>
                  </div>
                 </div>
              </div>
              <div class="col-md-3" style="padding-top: 15px;">Employee Status :</div>
                  <div class="col-md-9" style="padding-top: 15px;">
                 <div class='col-md-6'><input type='checkbox' class='emp_status'  value='0' checked>Active</div>
                  <div class='col-md-6'><input type='checkbox' class='emp_status' value='1' checked>InActive</div>
                  </div>
                 </div>
              </div>


  <?php }
  else 
  { 
  }

  
?>