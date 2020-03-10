<?php 
if($by=='Division'){ ?>
    <div class='col-md-3' style="padding-top: 10px;">
    <label>Select Division : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          
          <select class='form-control' onchange="onchange_val('Department',this.value)" id='f_division'>
            <option>Select Division</option>
             <?php if(empty($company_division)){ echo "<option value='0'>No Division in this company.</option>"; } else{}?>
          <?php foreach($company_division as $division){?>
                <option value="<?php echo $division->division_id?>"><?php echo $division->division_name?></option>
          <?php }?>
          </select>
  </div>
  </div>
<?php } elseif($by=='company_division'){ ?>
    <div class='col-md-3' style="padding-top: 10px;">
    <label>Select Division : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          
          <select class='form-control' onchange="onchange_val2('company_department',this.value)" id='f_division'>
            <option>Select Division</option>
             <?php if(empty($company_division)){ echo "<option value='0'>No Division in this company.</option>"; } else{}?>
          <?php foreach($company_division as $division){?>
                <option value="<?php echo $division->division_id?>"><?php echo $division->division_name?></option>
          <?php }?>
          </select>
         
  </div>
  </div>
<?php }  elseif($by=='company_department'){ ?>
    <div class='col-md-3' style="padding-top: 10px;">
    <label>Select Department : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php if(empty($company_department)) { echo "<n class='text-danger'>No Department Found</n>";} else{ ?>
          <select class='form-control' onchange="onchange_val('Section',this.value)" id='f_dept'>
            <option>Select Department</option>
          <?php foreach($company_department as $department){?>
                <option value="<?php echo $department->department_id?>"><?php echo $department->dept_name?></option>
          <?php }?>
          </select>
          <?php }?>
  </div>
  </div>
<?php } elseif($by=='company_division_sub') { ?>

 <div class='col-md-3' style="padding-top: 10px;">
    <label>Select Division : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
         
          <select class='form-control' onchange="onchange_val2('company_department_sub',this.value)" id='f_division'>
            <option>Select Division</option>
             <?php if(empty($company_division)){ echo "<option value='0'>No Division in this company.</option>"; } else{}?>
          <?php foreach($company_division as $division){?>
                <option value="<?php echo $division->division_id?>"><?php echo $division->division_name?></option>
          <?php }?>
          </select>
  </div>
  </div>

<?php }  elseif($by=='company_department_sub'){ ?>
    <div class='col-md-3' style="padding-top: 10px;">
    <label>Select Department : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php if(empty($company_department)) { echo "<n class='text-danger'>No Department Found</n>";} else{ ?>
          <select class='form-control' onchange="onchange_val2('company_section_sub',this.value)" id='f_dept'>
            <option>Select Department</option>
          <?php foreach($company_department as $department){?>
                <option value="<?php echo $department->department_id?>"><?php echo $department->dept_name?></option>
          <?php }?>
          </select>
          <?php }?>
  </div>
  </div>
<?php }  elseif($by=='company_section_sub'){ ?>
    <div class='col-md-3' style="padding-top: 10px;">
    <label>Select Section : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php if(empty($company_section)) { echo "<n class='text-danger'>No Section Found</n>";} else{ ?>
          <select class='form-control' onchange="onchange_val('SubSection',this.value)" id='f_section'>
            <option>Select Section</option>
          <?php foreach($company_section as $section){?>
                <option value="<?php echo $section->section_id?>"><?php echo $section->section_name?></option>
          <?php }?>
          </select>
          <?php }?>
  </div>
  </div>
<?php }
