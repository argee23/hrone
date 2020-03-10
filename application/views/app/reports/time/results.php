<?php 
  if($option=='division')
  {
$sel_report_type=$this->uri->segment('7');
if($sel_report_type=="single_pp"){ 
?>

      <div id="payroll_filtering" >

       <div class="col-md-12">
          <div class="col-md-3">Pay Type : <?php //echo $sel_report_type;?></div>
          <div class="col-md-6">
            <select class="form-control" name="pay_type" id="pay_type" required onchange="result_onchange_2('group',this.value),refresh()">
              <option selected disabled value=""> Select Pay Type</option>
               <?php foreach($pay_type as $row){
                echo "<option value='".$row->pay_type_id."'>".$row->pay_type_name."</option>";} ?>
            </select><br>
          </div>
      </div>

       <div class="col-md-12">
          <div class="col-md-3">Group Name :</div>
          <div class="col-md-6">
            <select class="form-control" name="group" id="group" required onchange="result_onchange_2('payroll_period',this.value)">
              <option selected disabled value=""> Select Group Name</option>
            </select><br>
          </div>
      </div>

       <div class="col-md-12">
          <div class="col-md-3">Payroll Period :</div>
          <div class="col-md-6">
            <select class="form-control" name="payroll_period" id="payroll_period" required>
            <option selected disabled value=""> Select Payroll Period</option>
            </select><br>
          </div>
      </div>

      </div>


<?php

}elseif($sel_report_type=="by_month"){ 

    echo '
    <div class="col-md-12">
    <div class="col-md-3">DTR Covered Month From</div>
    <div class="col-md-6">
    <select class="form-control" name="covered_month_from" id="covered_month_from" required>
    <option selected disabled value=""> Select Month From</option>';
    for($m=1; $m<=12; ++$m){
    echo '<option value="'.sprintf("%02d", $m).'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
    }
    echo '</select><br>
    </div>
    </div>';

    echo '
    <div class="col-md-12">
    <div class="col-md-3">DTR Covered Month To</div>
    <div class="col-md-6">
    <select class="form-control" name="covered_month_to" id="covered_month_to" required>
    <option selected disabled value=""> Select Month To</option>';
    for($m=1; $m<=12; ++$m){
    echo '<option value="'.sprintf("%02d", $m).'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
    }
    echo '</select><br>
    </div>
    </div>';

    echo '
    <div class="col-md-12">
    <div class="col-md-3">DTR Covered Year</div>
    <div class="col-md-6">
    <select class="form-control" name="covered_year" id="covered_year" required>
    <option selected disabled value=""> Select Year</option>';  

    if(!empty($payroll_period_year)){
    foreach($payroll_period_year as $pp){    
    echo '<option value="'.$pp->year_cover.'">'.$pp->year_cover.'</option>';
    }
  }else{}
echo '</select><br>
</div>
</div>';

}elseif($sel_report_type=="by_year"){ 

    echo '
    <div class="col-md-12">
    <div class="col-md-3">DTR Covered Year</div>
    <div class="col-md-6">
    <select class="form-control" name="covered_year" id="covered_year" required>
    <option selected disabled value=""> Select Year</option>';  

    if(!empty($payroll_period_year)){
    foreach($payroll_period_year as $pp){    
    echo '<option value="'.$pp->year_cover.'">'.$pp->year_cover.'</option>';
    }

}else{
}
echo '</select><br>
</div>
</div>';

}elseif($sel_report_type=="group_single_pp"){


?>

       <div class="col-md-12">
          <div class="col-md-3">Pay Type :<?php //echo $sel_report_type;?></div>
          <div class="col-md-6">
            <select class="form-control" name="pay_type" id="pay_type" required onchange="result_onchange_2('group',this.value),refresh()">
              <option selected disabled value=""> Select Pay Type</option>
               <?php foreach($pay_type as $row){
                echo "<option value='".$row->pay_type_id."'>".$row->pay_type_name."</option>";} ?>
            </select><br>
          </div>
      </div>

       <div class="col-md-12">
          <div class="col-md-3">Group Name :</div>
          <div class="col-md-6">
            <select class="form-control" name="group" id="group" required onchange="result_onchange_2('payroll_period',this.value)">
              <option selected disabled value=""> Select Group Name</option>
            </select><br>
          </div>
      </div>

       <div class="col-md-12">
          <div class="col-md-3">Payroll Period :</div>
          <div class="col-md-6">
            <select class="form-control" name="payroll_period" id="payroll_period" required>
            <option selected disabled value=""> Select Payroll Period</option>
            </select><br>
          </div>
      </div>

<?php
}else{

}
// ==================================


if($sel_report_type!="group_single_pp"){ 

echo "
<div class='col-md-12'>
<div class='col-md-3'>Classification :</div>
          <div class='col-md-9'>";
          $ii=0;
      foreach ($comp_class as $row) { ?>
        <input type='checkbox' checked class='classification' value='<?php echo "cc".$row->classification_id?>' ><?php echo $row->classification."<br>"?>
        <?php $ii = $ii + 1; } echo "<input type='hidden' id='c_classification' value='".$ii."'></div></div>";

echo '  <div class="col-md-12"></div>';
echo "<div class='col-md-12'><div class='col-md-3'>Location :</div>
          <div class='col-md-6' style='padding-bottom:10px;'>";
         $i=0;
      foreach ($comp_loc as $row) { ?>
        <input type='checkbox' checked class='location' value='<?php echo "ll".$row->location_id?>' onchange="result_onchange('classification',this.value)" ><?php echo $row->location_name?><br>
        <?php $i = $i + 1; }  echo "<input type='hidden' id='c_location' value='".$i."'></div></div>";
?>   


 <!--// division  -->
  <div class="col-md-12" ></div>
        <div class="col-md-12" >
          <div class="col-md-3">Division <i class="text-danger">(disregard if you do not have)</i>:</div>
          <div class="col-md-6" >
 <select class="form-control" name="division" id="division" required onchange="result_onchange('department',this.value),hide_sec_and_sub()";>
 <?php
        if(empty($results))
        { echo "<option disabled selected>Select Division</option><option value='All'>no division or not applicable</option>";}
        else{
          echo "<option value='All'>All (reports.php)</option>";
          foreach ($results as $row) { echo "<option value='".$row->division_id."'>".$row->division_name."</option>"; } 
        }
?>
</select>
          </div>
           </div>
<!-- // department -->
      <div class="col-md-12" >
          <div class="col-md-3">Department :</div>
          <div class="col-md-6">
            <select class="form-control" name="department" id="department" required onchange="result_onchange('section',this.value),hide_sub();">
              <option selected value="All"> All ( results.php )</option>
            </select><br>
          </div>
      </div>
<!-- // section -->
      <div class="col-md-12" id="hide_sec_on_div_change">
          <div class="col-md-3">Section :</div>
          <div class="col-md-6"> 
            <select class="form-control" name="section" id="section" required onchange="result_onchange('subsection',this.value),show_sub()">
              <option selected value="All"> All ( results.php )</option>
            </select><br></div>
      </div>


      <div class="col-md-12" id="aliby_sec" style="display: none;">
          <div class="col-md-3">Section :</div>
          <div class="col-md-6"> 
            <select class="form-control" name="section" id="section" required onchange="result_onchange('subsection',this.value),show_sub()">
              <option selected value="All"> All ( show muna )</option>
            </select><br></div>
      </div>

<!-- //susection -->
       <div class="col-md-12" id="hide_sub_on_dept_change">
          <div class="col-md-3">Sub-Section <i class="text-danger">(disregard if you do not have)</i>:</div>
          <div class="col-md-6">
            <select class="form-control" name="sub_section" id="subsection" required onchange="result_onchange('location',this.value)">
              <option selected disabled value="All"> All</option>
            </select><br></div>
      </div>

  <div class="col-md-12"></div>
 <?php 

    }      // end if not by_group_time_summary
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
    if(empty($results)){ 

        if($show_all_only_section=="yes"){
          echo "<option value='All'>All</option>";
        }else{
          echo "<option disabled selected>Select Section</option><option value='All'>No Section Added</option>";
        }

  }
      else{
    echo "<option disabled selected>Select Section</option><option value='All'>All</option>";
          foreach ($results as $row) { echo "<option value='".$row->section_id."'>".$row->section_name."</option>"; } }
  }

  else if($option=='subsection')
  { if(empty($results)){
        if($show_all_only_subsection=="yes"){
          echo "<option value='All'>All</option>";
        }else{
          echo "<option value='All'>no sub section or not applicable</option>";
        }
    }else{
          echo "<option disabled selected>Select Section</option><option value='All'>All </option>";
          foreach ($results as $row) { echo "<option value='".$row->subsection_id."'>".$row->subsection_name."</option>"; } 
        }
  }
// == no use class
  else if($option=='classification')
  { echo "<div class='col-md-3'>Classification :</div>
          <div class='col-md-6' style='padding-bottom:10px;'>";
          $ii=0;
      foreach ($results as $row) { ?>
        <input type='checkbox' class='classification' value='<?php echo "cc".$row->classification_id?>' ><?php echo $row->classification."<br>"?>
        <?php $ii = $ii + 1; } echo "<input type='hidden' id='c_classification' value='".$ii."'></div>";
  }
// == no use location
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