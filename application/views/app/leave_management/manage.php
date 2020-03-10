 <?php
 $company_id=$this->uri->segment("5");

 ?>
<div class="row">
<div class="col-md-12">
<div class="well">
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/leave_management/save_add/<?php echo $this->uri->segment("4")."/".$company_id;?>" >
    <div class="box-body">
          <input type="hidden" name="leave_id" value="<?php echo $this->uri->segment("4");?>">
          <input type="hidden" name="leave_type" value="<?php echo $leave_type->leave_type?>">      
 <?php
 //$company_id=$this->uri->segment("5");
 $company_name=$leave_type->company_name;
                $co_check=$leave_type->carry_over;
                $co_em=$leave_type->carry_over_expired_month;
                $co_ed=$leave_type->carry_over_expired_day;
                if($co_em>0){
                  $with_expiration="Unused Carried over credits will expire on/every ".date("F", mktime(0, 0, 0, $co_em, 10))."  $co_ed";
                }else{
                  $with_expiration="";
                }
                if($co_check==""){
                  $carry_over_choose= "note : left credits after the set Cut Off Date doesnt have setup yet.";  
                    $c_over= "Select Option";                                              
                }else if($co_check=="all"){
                   $carry_over_choose= "All left/unused credits will be carried over after the set Cut Off Date, yearly.";
                     $c_over= "All available leave";
                }else if($co_check==0){
                   $carry_over_choose= "System will reset all  left credits after the set Cut Off Date ,yearly.";           
                    $c_over= "no";                 
                }else{
                  $carry_over_choose= $co_check. "&nbsp;left credits after the set Cut Off Date will be retain ,yearly.";
                    $c_over= $co_check. "&nbsp;available leave";
                }




            ?>


<table id=""  class="table table-bordered table-striped">
    <thead>
    <tr>
      <th colspan="2">
      <?php //echo "test".$company_id=$this->uri->segment("5");?>
         <i class="fa fa-info fa-lg text-danger pull-left"  data-toggle="tooltip" data-placement="left" ></i>
         Current Setup Meaning Guide.
         <p style="font-style: italic;text-align: right;">
<?php

 if ((is_numeric($leave_type->start_value)) AND (is_numeric($leave_type->effectivity))) {
  $walapangsetup=$carry_over_choose;
?>
     Employee of classifications , employment and locations checked below has <?php echo $leave_type->start_value. "&nbsp; credits after/on ". $leave_type->effectivity ." month(s) of employment "?>

<?php
 }else{
echo "note : No automatic setup yet. Leave credits can be done manually.";
$walapangsetup="";
 }
?>
    

           </p>
         <p style="font-style: italic;text-align: right;"><?php echo $walapangsetup." <br> ".$with_expiration;?></p>
      </th>
    </tr>
      <tr>
        <th >
            <i class="fa fa-cogs fa-lg text-danger pull-left"  data-toggle="tooltip" data-placement="left" ></i>Manage <?php echo "<span class='text-info'>".$company_name."  :  ".$leave_type->leave_type."</span>";?> Settings 
        </th>
        <th colspan="2">
            <a href="<?php echo base_url()?>app/leave_management/remove_leave_condition/<?php echo $this->uri->segment("4");?>" class="btn btn-sm btn-danger pull-right" type="button" title="Remove Leave Conditions" onclick="return confirm_remove_settings();"><i class="fa fa-minus-square-o"></i>&nbsp;Remove Leave Condition Settings  &nbsp;</a>
            
                        <?php                                  
                  $check_class_setting = $this->leave_management_model->check_if_leave_type_has_assigned_class_settings($leave_type->id);
                  $check_emp_setting = $this->leave_management_model->check_if_leave_type_has_assigned_emp_settings($leave_type->id);
                  $check_loc_setting = $this->leave_management_model->check_if_leave_type_has_assigned_loc_settings($leave_type->id);

                  // if (!empty($check_class_setting) AND !empty($check_emp_setting) AND !empty($check_loc_setting) ){
                  //         echo '<a href="'. base_url().'app/leave_management/details/'.$leave_type->id. '/view" class="btn btn-sm btn-success pull-right" type="button" data-toggle="tooltip" data-placement="left" title="Click to View Details of '.$leave_type->leave_type.'" > <i class="fa fa-check-square-o"></i>Employees</a>';                    
                  // }else{
                  //         echo '<a class="btn btn-sm btn-default pull-right" type="button" data-toggle="tooltip" data-placement="left" title="'.$leave_type->leave_type.' : Settings not yet set" > <i class="fa fa-check-square-o"></i>Employees</a>';   
                  // }                
            ?>

          <!--   <a href="<?php //echo base_url()?>app/leave_management/applied_condition/<?php //echo $leave_type->id;?>" class="btn btn-sm btn-success pull-right" type="button" title="Click to view employees" ><i class="fa fa-check-square-o"></i>&nbsp;Employees</a> -->

           <!--  <a onclick="applied_condition(<?php //echo $leave_type->id ?>)" class="btn btn-sm btn-success pull-right" type="button" title="Click to view employees" ><i class="fa fa-check-square-o"></i>&nbsp;Employees</a> -->
        </th>
      </tr>
      <tr>
        <th>Classification</th>             
        <th>Employment</th>
        <th>Location</th>
      </tr>
    </thead>  
<tbody> 
      <tr>
        <td>
            <?php 
              $company_id;
              
               $c_classificationList = $this->general_model->get_company_classifications($company_id);
              foreach($c_classificationList as $classification){
              $cl=$classification->classification_id;
               
                  $data2 = $this->leave_management_model->check_if_classification_is_applicable($cl,$leave_type->id);

                  if (!empty($data2)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }
                  echo '<input type="checkbox" value="'. $cl.'" '.$applicable.' name="classification[]" >&nbsp;'.$classification->classification. '<br>';
                  } 
            ?>
        </td>
        <td>
            <?php  foreach($employmentList as $employment){
            $cl=$employment->employment_id;
            $data2 = $this->leave_management_model->check_if_employment_is_applicable($cl,$leave_type->id);

            if (!empty($data2)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }
            echo '<input type="checkbox" value="'. $cl.'" name="employment[]"  '.$applicable.'>&nbsp;'.$employment->employment_name.'<br>';
            } 
            ?>
        </td>
        <td>
            <?php  

             $c_locationList = $this->general_model->get_company_locations($company_id);
            foreach($c_locationList as $location){
            $cl=$location->location_id;
            $data2 = $this->leave_management_model->check_if_location_is_applicable($cl,$leave_type->id);

            if (!empty($data2)){
                  $applicable="checked";
                  }else{
                  $applicable="";
                  }
            echo '<input type="checkbox" value="'. $cl.'" name="location[]"  '.$applicable.' >&nbsp;'.$location->location_name.'<br>';

            } 
            ?>
        </td>
    </tr>       
</tbody>
</table>

<div class="form-group">
    <label for="start_value" class="col-sm-2 control-label">Start Value</label>
        <div class="col-sm-10">
          <input type="number" name="start_value" class="form-control" value="<?php echo $leave_type->start_value ?>" placeholder="Enter start value" step="any">
        </div>
</div> 

<div class="form-group">
    <label for="effectivity" class="col-sm-2 control-label">Effectivity</label>
        <div class="col-sm-10">
 
          <select name="effectivity" id="effectivity_dropdown" class="form-control" onclick="disable_effectivity_datepicker()">
          <option selected="selected" value="<?php echo $leave_type->effectivity ?>">
          <?php
$effectivity_check=$leave_type->effectivity;
if($effectivity_check=="hired_date"){
  echo "On the date hired";
}else{
              $date_format = 'Y-m-d';
              $input = $effectivity_check;

              $input = trim($input);
              $time = strtotime($input);

              if(date($date_format, $time) == $input){
                  echo $effectivity_check;
              }else if($effectivity_check==""){
                  echo "Select Option";
              }else{
                  echo "after &nbsp;".$leave_type->effectivity ."&nbsp;month of date hired";
              }
}        
          ?>
         </option>
         <option value="" disabled></option>
         <option value="hired_date">On the date hired</option>
          <?php
              $effectivity = 1;
              while ( $effectivity <= 12 ) {
              echo "<option value=".$effectivity.">after &nbsp;".$effectivity."&nbsp;month of date hired </option>";
              $effectivity++;
              }
            ?>
          </select>
    </div>
</div>     

<div class="form-group">
    <label for="carry_over" class="col-sm-2 control-label">Carry Over</label>
        <div class="col-sm-10">
          <select name="carry_over" class="form-control" >  
          <option value="<?php echo $leave_type->carry_over ?>">
            <?php
                //$co_check=$leave_type->carry_over;
echo $c_over;
            ?>
          </option> 
          <option value="0">no</option>
          <option value="all">all available leave</option>
          <?php
                  $carry_over = 1;
                  while ( $carry_over <= 12 ) {
                  echo "<option value=".$carry_over.">".$carry_over."&nbsp;available leave </option>";
                  $carry_over++;
                  }
              ?>
          </select>        
        </div>
</div>
      <div class="form-group">
        <label for="carry_over_when" class="col-sm-2 control-label">Carry Over <span class="text-danger">( When will carry over take effect )</span></label>
      <div class="col-sm-10">
          <select class="form-control" name="carry_over_when" id="carry_over_when" >
          <option value="<?php echo $leave_type->carry_over_when ?>"> <?php 
          if($leave_type->carry_over_when=="no_carry_over"){
            echo "not will carry over : see above setup";
          }else if($leave_type->carry_over_when =="1"){ 
            echo "Same with cutoff date";
          }else{
            echo "Select Option";
          } 

           ?></option>
                 <option value="" disabled></option>
          <option value="1"> Same with cutoff date</option>
        <!--   <option value="0"> Every Employee Anniversary Day </option> -->
          </select>
      </div>
      </div>   
<div class="form-group">
    <label for="carry_over_expired_month" class="col-sm-2 control-label">Carry Over Credits Expiry </label>
        <div class="col-sm-10">
 
          <select name="carry_over_expired_month" id="effectivity_dropdown" class="form-control"  required>
          <option selected="selected" value="<?php echo $leave_type->carry_over_expired_month ?>">
          <?php
 if($leave_type->carry_over_when=="no_carry_over"){
            echo "not will carry over : see above setup";
          }else{
                          $coem_check=$leave_type->carry_over_expired_month;
              if($coem_check=="1"){
                  $coem_check_ext="st";
              }else if($coem_check=="2"){
                  $coem_check_ext="nd";
              }else if($coem_check=="3"){
                  $coem_check_ext="rd";
              }else{
                  $coem_check_ext="th";
              }
              if($coem_check==""){
                  echo "Select Option";
              }else if($coem_check<>"0"){
                  echo "will expire on &nbsp;".$leave_type->carry_over_expired_month .$coem_check_ext."&nbsp;month";
              }else{
                echo "no expiry";
              }
          }


          ?>
         </option>
         <option value="0">no expiry</option>
          <?php
              $coem = 1;

              while ( $coem <= 12 ) {

              if($coem=="1"){
                  $coem_ext="st";
              }else if($coem=="2"){
                  $coem_ext="nd";
              }else if($coem=="3"){
                  $coem_ext="rd";
              }else{
                  $coem_ext="th";
              }

              echo "<option value=".sprintf("%02d", $coem).">will expire on  &nbsp;".$coem.$coem_ext."&nbsp;month</option>";
              $coem++;
              }
            ?>
          </select>
   </div>
</div>   

      <div class="form-group">
        <label for="carry_over_expired_day" class="col-sm-2 control-label">Carry Over<span class="text-danger"> ( What day will expire, if with expiration )</span></label>
      <div class="col-sm-10">

       <select name="carry_over_expired_day" class="form-control" required>
        <option value="<?php echo  $leave_type->carry_over_expired_day;?>" selected="" ><?php 

if($leave_type->carry_over_when=="no_carry_over"){
            echo "not will carry over : see above setup";
}else{
      if($leave_type->carry_over_expired_month=="0"){
       echo "no expiry"; 
      }else if($leave_type->carry_over_expired_month==""){
       echo  "Select Option";
      }else{
       echo  $leave_type->carry_over_expired_day;        
      }           
}

       ?></option>
        <option value="" disabled></option>
        <option value="" >no expiry</option>
          <?php
          $D = 1;
          while ( $D <= 31 ) {
          echo "<option value=".sprintf("%02d", $D).">".sprintf("%02d", $D)."</option>";
          $D++;
          }
          ?>
        </select>   
      </div>
      </div>   

<!-- //=============================== yearly monthly increment what day?  -->
<!--       <div class="form-group">
        <label for="yearly_inc_what_day" class="col-sm-2 control-label">Monthly Increment <span class="text-danger">( What day of the month ) <i class="fa fa-arrow-down"></i> </span></label>
      <div class="col-sm-10">
       <select name="yearly_inc_what_day" class="form-control" style="float:left;width:21%;" id="yearly_inc_what_day" >
        <option value="<?php //echo  $leave_type->yearly_inc_what_day;?>" selected="" ><?php //echo  $leave_type->yearly_inc_what_day;?></option>
          <?php
          // $D = 1;
          // while ( $D <= 31 ) {
          // echo "<option value=".sprintf("%02d", $D).">".sprintf("%02d", $D)."</option>";
          // $D++;
          // }
          ?>
        </select>   
      </div>
      </div>   
 -->

<!-- //======================================================================================================Succeeding Years -->
<hr>
<?php 
if($leave_type->isyearly_credit_fixed=="yes"){
  $yes_checked="checked";
  $no_checked="";
  $sy="fixed credit";
  $yearly_inc_what_day_default_hidden='style="display: none;"';
  $for_yearly_fixed_credit_default_hidden="";

  $addyear_button='style="display: none;"';
  $remove_all_inc_setup='style="display: none;"';
}else{
  $yes_checked="";
  $no_checked="checked";
  $sy="increment";
  $yearly_inc_what_day_default_hidden="";
  $for_yearly_fixed_credit_default_hidden='style="display: none;"';

  $addyear_button='';
  $remove_all_inc_setup='';
}
?>
<div class="form-group" >
    <label for="add_delete_year" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <i class="fa fa-clock-o fa-sm text-danger pull-left"  data-toggle="tooltip" data-placement="left" ></i><strong> Succeeding Years : <?php echo $sy;?></strong>

            <a href="<?php echo base_url()?>app/leave_management/remove_succeding_years_condition/<?php echo $this->uri->segment("4");?>" class="btn btn-sm btn-warning pull-right" type="button" title="Remove Years Condition" onclick="return confirm_remove_years_settings();" id="remove_all_inc_setup" <?php echo $remove_all_inc_setup;?>>
            <i class="fa fa-minus-square-o"></i>&nbsp;Remove Year(s) Auto Increment Settings &nbsp;</a>
        </div>
</div>

<div class="form-group">
    <label for="add_delete_year" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">

<input name="isyearly_credit_fixed" type="radio" value="yes" <?php echo $yes_checked;?> onclick="disable_inc_what_day()"> fixed credit
<input name="isyearly_credit_fixed" type="radio" value="no"  <?php echo $no_checked;?>  onclick="enable_inc_what_day()"> increment
        </div>
</div>
      <div class="form-group" id="yearly_inc_what_day" <?php echo $yearly_inc_what_day_default_hidden;?>>
        <label for="yearly_inc_what_day" class="col-sm-2 control-label">Monthly Increment <span class="text-danger">( What day of the month ) <i class="fa fa-arrow-down"></i> </span></label>
      <div class="col-sm-10">
       <select name="yearly_inc_what_day" class="form-control" id="" >
        <option value="<?php echo  $leave_type->yearly_inc_what_day;?>" selected="" ><?php echo  $leave_type->yearly_inc_what_day;?></option>
          <?php
          $D = 1;
          while ( $D <= 31 ) {
          echo "<option value=".sprintf("%02d", $D).">".sprintf("%02d", $D)."</option>";
          $D++;
          }
          ?>
        </select>   
      </div>
      </div>   

<div class="form-group" id="fc_value" <?php echo $for_yearly_fixed_credit_default_hidden;?>>
    <label for="fixed_credit_value" class="col-sm-2 control-label">Credit</label>
        <div class="col-sm-10">
          <input type="number" name="fixed_credit_value" class="form-control" value="<?php echo $leave_type->fixed_credit_value; ?>" placeholder="Enter Credit">
        </div>
</div> 

        <div class="form-group" id="for_yearly_fixed_credit" <?php echo $for_yearly_fixed_credit_default_hidden;?>>
        <label for="yearly_fixed_credit_month" class="col-sm-2 control-label">Yearly Fixed Value<span class="text-danger"> ( Effectivity Date )</span>
        <?php $yfcm=$leave_type->yearly_fixed_credit_month;
        if(!empty($yfcm)){
            $yfcm_converted= date("F", mktime(0, 0, 0, $yfcm, 10));
        }else{
            $yfcm_converted="";
        }


        ?></label>
      <div class="col-sm-10">
        <select name="yearly_fixed_credit_month" class="form-control" style="float:left;width:25%;" id="yearly_fixed_credit_month" onclick="disable_anniv_checkbox()">

        <option value="<?php echo $leave_type->yearly_fixed_credit_month;?>" selected=""><?php echo $yfcm_converted;?></option>
          <?php
          for($M =1;$M<=12;$M++){
          echo "<option value='".$month_no = sprintf("%02d", $M)."'>". date("F", mktime(0, 0, 0, $M, 10)) ."</option>";
          }
          ?>
        </select> 
       <select name="yearly_fixed_credit_day" class="form-control" style="float:left;width:21%;" id="yearly_fixed_credit_day" onclick="disable_anniv_checkbox()">
        <option value="<?php echo  $leave_type->yearly_fixed_credit_day;?>" selected="" ><?php echo  $leave_type->yearly_fixed_credit_day;?></option>
          <?php
          $D = 1;
          while ( $D <= 31 ) {
          echo "<option value=".sprintf("%02d", $D).">".sprintf("%02d", $D)."</option>";
          $D++;
          }
          ?>
        </select>   

              <div class="col-sm-10">
          <input type="checkbox"  title="check if yearly fixed credit will take effect on employee anniversary date" <?php if($leave_type->yearly_fixed_credit_on_anniv_eff =="1"){ echo "checked"; }else{echo "";}?> name="yearly_fixed_credit_on_anniv_eff"; value="1" id="yearly_fixed_credit_on_anniv_eff"> on employee anniversary date?  <span class="text-danger">( will disregard month & date above upon saving if this is checked.)</span>
      </div>  

      </div>
      </div>   

<div class="form-group">
    <label for="add_delete_year" class="col-sm-2 control-label"></label>
        <div class="col-sm-12">
            <?php
              $data2 = $this->leave_management_model->check_leave_years($leave_type->id);

              if (!empty($data2)){
              foreach ($data2 as $here){
              $rawyear=$here->year;
              $year_if_not_null=$here->year+1;

echo '<a onclick="addYear()" class="btn btn-sm btn-warning pull-left" type="button" title="Add Year" '.$addyear_button.' id="addyear_button"><i class="fa fa-plus"></i>&nbsp;add year</a>
<a onclick="delYear()" class="btn btn-sm btn-danger pull-left" type="button" title="Delete Year" '.$addyear_button.' id="delyear_button"><i class="fa fa-times"></i>&nbsp;delete year</a>
<input type="hidden" id="counter" value="'.$year_if_not_null.'" name="loop_counter">';

$getYear= $this->leave_management_model->get_leave_years($leave_type->id);

              foreach ($getYear as $Year){
              if ($Year->replenish==1){
              $final_replenish="YES";
              }else{
              $final_replenish="NO";
              }
              if($Year->year==1){$extension="st";}
              else if($Year->year==2){$extension="nd";}
              else if($Year->year==3){$extension="rd";}
              else{$extension="th";}

              $edit = "<i class='fa fa-pencil-square-o fa-lg text-danger pull-right' class='hidden' data-toggle='tooltip' data-placement='left' title='Edit ".$Year->year.$extension."&nbsp;Year Auto Increment' onclick='editYearCondition(".$Year->id.")'></i>"; 

if($Year->isyearly_setup==1){
  $is_ys="<span class='text-danger'> (this is a yearly setup)</span>";
}else{
  $is_ys='';
}

     $delete_year_inc_setup='       <a href="'.base_url().'app/leave_management/delete_year_inc_setup/'.$Year->leave_type_id.'/'.$Year->year.'" class="pull-right" title="Remove this setup?" onclick="return confirm_remove_settings();"><i class="fa fa-remove"></i>&nbsp;Remove  &nbsp;</a>';

  echo 
  "<table id='myTable'  class='table table-bordered table-striped'>
  </table >
  <div class='col-md-12' id='myTable_content'>
    <div class='panel panel-info'>
      <div class='panel-heading'><strong>". $Year->year.$extension. "&nbsp;Year Auto Increment
".$is_ys."
      </strong>".$edit. $delete_year_inc_setup."</div>
        <div class='panel-body'>     

          <div class='form-group'>
            <label class='col-sm-2 control-label'>Increment</label>
            <div class='col-sm-10'>
              <input type='hidden' name='increment".$Year->year."' value='".$Year->increment."'><input readonly type='text' class='form-control' value='every " .$Year->increment. "&nbsp;month' >
            </div>
          </div>          

          <div class='form-group'>
            <label class='col-sm-2 control-label'>Credit</label>
              <div class='col-sm-10'>
                <input readonly type='text' class='form-control' name='leave_balance".$Year->year."' value='" .$Year->add_leave_bal. "' >
              </div>
          </div>        

          <div class='form-group'>
            <label class='col-sm-2 control-label'>Max</label>
              <div class='col-sm-10'>
                <input readonly type='text' class='form-control' name='max".$Year->year."' value='" .$Year->max. "' >
              </div>
          </div>     ";   

 
?> 
  <!--         <div class='form-group'>
            <label class='col-sm-2 control-label'>Carry Over</label>
              <div class='col-sm-10'>
                <input type='hidden' name='replenish".$Year->year."' value='".$Year->replenish."'><input readonly type='text' class='form-control' value='" .$final_replenish. "' >
              </div>
          </div>"; 
 -->

<div class='form-group'>
<label class='col-sm-2 control-label'>Carry Over</label>
<div class='col-sm-10'>
          <select name="carry_over" class="form-control" disabled>  
          <option value="<?php echo $leave_type->carry_over ?>">
            <?php
echo $c_over;
            ?>
          </option> 
          </select>   
          </div>  
        </div> 
     <div class="form-group">
        <label for="carry_over_when" class="col-sm-2 control-label">Carry Over <span class="text-danger">( When will carry over take effect )</span></label>
      <div class="col-sm-10">
          <select class="form-control" name="carry_over_when" id="carry_over_when" disabled>
          <option value="<?php echo $leave_type->carry_over_when ?>"> <?php 
          if($leave_type->carry_over_when =="0"){
            echo " Every Employee Anniversary Day";
          }else if($leave_type->carry_over_when=="no_carry_over"){
            echo "not will carry over : see above setup";
          }else{ 
            echo "Same with cutoff date";
          }  ?></option>
          </select>
      </div>
      </div>   
<div class="form-group">
    <label for="carry_over_expired_month" class="col-sm-2 control-label">Carry Over Credits Expiry </label>
        <div class="col-sm-10">
 
          <select name="carry_over_expired_month" id="effectivity_dropdown" class="form-control"  disabled>
          <option selected="selected" value="<?php echo $leave_type->carry_over_expired_month ?>">
          <?php
 if($leave_type->carry_over_when=="no_carry_over"){
            echo "not will carry over : see above setup";
          }else{
                          $coem_check=$leave_type->carry_over_expired_month;
              if($coem_check=="1"){
                  $coem_check_ext="st";
              }else if($coem_check=="2"){
                  $coem_check_ext="nd";
              }else if($coem_check=="3"){
                  $coem_check_ext="rd";
              }else{
                  $coem_check_ext="th";
              }
              if($coem_check==""){
                  echo "Select Carry Over Credits Expiry";
              }else if($coem_check<>"0"){
                  echo "will expire on &nbsp;".$leave_type->carry_over_expired_month .$coem_check_ext."&nbsp;month";
              }else{
                echo "no expiry";
              }
          }


          ?>
         </option>
          </select>
   </div>
</div>   

      <div class="form-group">
        <label for="carry_over_expired_day" class="col-sm-2 control-label">Carry Over<span class="text-danger"> ( What day will expire, if with expiration )</span></label>
      <div class="col-sm-10">

       <select name="carry_over_expired_day" class="form-control" disabled>
        <option value="<?php echo  $leave_type->carry_over_expired_day;?>" selected="" ><?php 

 if($leave_type->carry_over_when=="no_carry_over"){
            echo "not will carry over : see above setup";
          }else{
 if($leave_type->carry_over_expired_month=="0"){ echo "no expiry"; }else{ echo  $leave_type->carry_over_expired_day;}           
          }
       ?></option>
        </select>   
      </div>
      </div>   










<?php

   echo     "</div>
     </div>
  </div>";
            }
          }
        }else{
            $year_if_not_null=1;
            echo '<a onclick="addYear()" class="btn btn-sm btn-warning pull-left" type="button" title="Add Year" '.$addyear_button.' id="addyear_button"><i class="fa fa-plus"></i>&nbsp;add year</a>
            <a onclick="delYear()" class="btn btn-sm btn-danger pull-left" type="button" title="Delete Year" '.$addyear_button.' id="delyear_button"><i class="fa fa-times"></i>&nbsp;delete year</a>
            <input type="hidden" id="counter" value="1" name="loop_counter"><table id="myTable"  class="table table-bordered table-striped">
            </table >';
              }
?>
          </div>
</div>

          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div>
  </form>
</div>
</div>



</div>  














