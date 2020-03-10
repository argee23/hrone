<?php 
//if location
if($by=='Location') { ?>
    <div class='col-md-3' style="padding-top: 10px;">
    <label>Disable <?php echo $by?> : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php $count = 0; foreach($company_locations as $location){?>
          <div class='col-md-12'>
            <input type="checkbox" class="<?php echo $by?>"  value="<?php echo $location->location_id; ?>" <?php foreach($company_setupdisable as $cc){ $loc =explode("-",$cc->location);  foreach($loc as $l){ if($l == $location->location_id) { echo "checked"; }  }} ?>   >
          <n class='text-danger'><?php echo $location->location_name; ?></n><br>
          </div>
          <?php $count = $count + 1;  } echo "<input type='hidden' id='count_".$by."' value='".$count."'>"; ?>
  </div>
  </div>

<!-- if division  -->
<?php } elseif($by=='Division'){ ?>
    <div class='col-md-3' style="padding-top: 10px;">
    <label>Disable Company : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php $count = 0; if(empty($company_division)) { echo "<n class='text-danger'>No Division Found</n>";} else{ foreach($company_division as $division){?>
          <div class='col-md-6'>
            <input type="checkbox" class="<?php echo $by?>"  value="<?php echo $division->division_id; ?>" <<?php foreach($company_setupdisable as $cc){ $loc =explode("-",$cc->division);  foreach($loc as $l){ if($l == $division->division_id) { echo "checked"; }  }} ?> >
          <n class='text-danger'><?php echo $division->division_name; ?></n><br>
          </div>
            <?php  $count = $count + 1; } echo "<input type='hidden' id='count_".$by."' value='".$count."'>"; }?>
    </div>
    </div>
  <!-- if division  -->
  <?php } elseif($by=='Department'){?>
      <div class='col-md-3' style="padding-top: 10px;">
    <label>Disable Department : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php  $count = 0; if(empty($company_department)) { echo "<n class='text-danger'>No Department Found</n>";} else{ foreach($company_department as $department){?>
          <div class='col-md-6'>
            <input type="checkbox" class="<?php echo $by?>"  value="<?php echo $department->department_id; ?>" <?php foreach($company_setupdisable as $cc){ $loc =explode("-",$cc->department);  foreach($loc as $l){ if($l == $department->department_id) { echo "checked"; }  }} ?> >
          <n class='text-danger'><?php echo $department->dept_name; ?></n><br>
          </div>
          <?php $count = $count + 1; } echo "<input type='hidden' id='count_".$by."' value='".$count."'>"; }?>
  </div>
  </div>

<?php } elseif($by=='Section'){?>

 <div class='col-md-3' style="padding-top: 10px;">
    <label>Disable Section : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php $count = 0; if(empty($company_section)) { echo "<n class='text-danger'>No Section Found</n>";} else{ foreach($company_section as $section){?>
          <div class='col-md-6'>
            <input type="checkbox" class="<?php echo $by?>"  value="<?php echo $section->section_id; ?>" <?php foreach($company_setupdisable as $cc){ $loc =explode("-",$cc->section);  foreach($loc as $l){ if($l == $section->section_id) { echo "checked"; }  }} ?> >
          <n class='text-danger'><?php echo $section->section_name; ?></n><br>
          </div>
          <?php $count = $count + 1;   }   echo "<input type='hidden' id='count_".$by."' value='".$count."'>"; }?>
  </div>
  </div>

  <?php } elseif($by=='SubSection'){?>

 <div class='col-md-3' style="padding-top: 10px;">
    <label>Disable SubSection : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php $count = 0; if(empty($company_subsection)) { echo "<n class='text-danger'>No Sub Section Found</n>";} else{ foreach($company_subsection as $subsection){?>
          <div class='col-md-6'>
            <input type="checkbox" class="<?php echo $by?>"  value="<?php echo $subsection->subsection_id; ?>" <?php foreach($company_setupdisable as $cc){ $loc =explode("-",$cc->subsection);  foreach($loc as $l){ if($l == $subsection->subsection_id) { echo "checked"; }  }} ?> >
          <n class='text-danger'><?php echo $subsection->subsection_name; ?></n><br>
          </div>
          <?php $count = $count + 1;  }  echo "<input type='hidden' id='count_".$by."' value='".$count."'>"; }?>
  </div>
  </div>

   <?php  } elseif($by=='Classification'){?>

 <div class='col-md-3' style="padding-top: 10px;">
    <label>Disable Classification : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php $count = 0;  if(empty($company_classification)) { echo "<n class='text-danger'>No Sub classification Found</n>";} else{ foreach($company_classification as $classification){?>
          <div class='col-md-6'>
            <input type="checkbox" class="<?php echo $by?>"  value="<?php echo $classification->classification_id; ?>" <?php if($classification->isDisable == 1){ ?> checked <?php } ?> >
          <n class='text-danger'><?php echo $classification->classification; ?></n><br>
          </div>
          <?php  $count = $count + 1; } echo "<input type='hidden' id='count_".$by."' value='".$count."'>";  }?>
  </div>
  </div>
<?php } elseif($by=='Position'){?>
 <div class='col-md-3' style="padding-top: 10px;">
    <label>Disable Position : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php $count = 0;   foreach($company_position as $position){?>
          <div class='col-md-12'>
            <input type="checkbox" class="<?php echo $by?>"  value="<?php echo $position->position_id; ?>" <?php foreach($company_setupdisable as $cc){ $loc =explode("-",$cc->position);  foreach($loc as $l){ if($l == $position->position_id) { echo "checked"; }  }} ?> >
          <n class='text-danger'><?php echo $position->position_name; ?></n><br>
          </div>
          <?php $count = $count + 1;  } echo "<input type='hidden' id='count_".$by."' value='".$count."'>"; ?>
  </div>
<?php } elseif($by=='Employment'){?>
<div class='col-md-3' style="padding-top: 10px;">
    <label>Disable Employment : </label>
  </div> 
  <div class="col-md-9"  style="padding-top: 10px;">
          <?php  $count = 0; foreach($company_employment as $employment){?>
          <div class='col-md-12'>
            <input type="checkbox" class="<?php echo $by?>"  value="<?php echo $employment->employment_id; ?>" <?php foreach($company_setupdisable as $cc){ $loc =explode("-",$cc->employment);  foreach($loc as $l){ if($l == $employment->employment_id) { echo "checked"; }  }} ?> >
          <n class='text-danger'><?php echo $employment->employment_name; ?></n><br>
          </div>
          <?php $count = $count + 1;  }   echo "<input type='hidden' id='count_".$by."' value='".$count."'>"; ?>
  </div>
  </div>
  <?php } ?>
