<?php 

  if($option=='division')
  {   
        if(empty($results))
        { echo "<option disabled selected>Select Division</option><option value='All'>no division in selected company</option>";}
        else{
          echo "<option disabled selected>Select Division</option><option value='All'>All</option>";
          foreach ($results as $row) { echo "<option value='".$row->division_id."'>".$row->division_name."</option>"; } 
        }
        
  }

  else if($option=='department')
  { 
     if(!empty($results)) {
    echo "<option disabled selected>Select Department</option><option value='All'>All</option>";
          foreach ($results as $row) { echo "<option value='".$row->department_id."'>".$row->dept_name."</option>"; } }
      else{ echo "<option disabled selected>Select Department</option><option value='no_val'>No Department Added</option>"; }
  }

  else if($option=='section')
  { 
    if(empty($results)){ echo "<option disabled selected>Select Section</option><option value='All'>No Section Added</option>";}
      else{
    echo "<option disabled selected>Select Section</option><option value='All'>All</option>";
          foreach ($results as $row) { echo "<option value='".$row->section_id."'>".$row->section_name."</option>"; } }
  }

  else if($option=='subsection')
  { if(empty($results)){ echo "<option disabled selected>Select Section</option><option value='All'>No Sub Section Added</option>";}
      else{
    echo "<option disabled selected>Select Section</option><option value='All'>All</option>";
          foreach ($results as $row) { echo "<option value='".$row->subsection_id."'>".$row->subsection_name."</option>"; } }
  }

  else if($option=='classification')
  { echo "<div class='col-md-3'>Classification :</div>
          <div class='col-md-6' style='padding-bottom:10px;'>";
          $ii=0;
      foreach ($results as $row) { ?>
        <input type='checkbox' class='classification' value='<?php echo "cc".$row->classification_id?>' ><?php echo $row->classification."<br>"?>
        <?php $ii = $ii + 1; } echo "<input type='hidden' id='c_classification' value='".$ii."'></div>";
  }
  else if($option=='location')
  { echo "<div class='col-md-3'>Location :</div>
          <div class='col-md-6' style='padding-bottom:10px;'>";
         $i=0;
      foreach ($results as $row) { ?>
        <input type='checkbox' class='location' value='<?php echo "ll".$row->location_id?>' onchange="result_onchange('classification',this.value)" ><?php echo $row->location_name?>&nbsp;&nbsp;
        <?php $i = $i + 1; }  echo "<input type='hidden' id='c_location' value='".$i."'></div>";
  }

  else if($option=='group')
  { if(empty($results)){ echo "<option disabled selected>Select Group Name</option><option value='All'>No Group Added</option>";}
      else{
    echo "<option disabled selected>Select Group Name</option>";
          foreach ($results as $row) { echo "<option value='".$row->payroll_period_group_id."'>".$row->group_name."</option>"; } }
  }

  
?>