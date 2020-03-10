<?php 
//if company
if($option=='Company') { ?>
  <div class='col-md-3'>
    <label>Disable <?php echo $option?> : </label>
  </div>
  <div class="col-md-9">
          <?php $count = 0; foreach($companyList as $company){?>
          <div class='col-md-6'>
            <input type="checkbox"  class="<?php echo $option?>" value="<?php echo $company->company_id; ?>"
              <?php foreach($company_setupdisable as $cc){ if($cc->company_id==$company->company_id AND $cc->all==1){ echo "checked"; } } ?>>
           <n class='text-danger'><?php echo $company->company_name; ?></n>
          </div>
          <?php $count = $count + 1; } echo "<input type='hidden' id='count_".$option."' value='".$count."'>"; ?>
  </div>

<!-- if location  -->
<?php } elseif($option=='Location'){ ?>
     <div class='col-md-3'>
        <label>Select <?php echo $option?> : </label>
      </div>
      <div class="col-md-9">
         <select class="form-control" name="company" id="company" onchange="onchange_val('Location',this.value)" required>
            <option selected disabled>~select a company~</option>
              <?php
                  foreach($companyList as $company){
              ?>
                <option value="<?php echo $company->company_id;?>"  <?php foreach($company_setupdisable as $cc){ if($cc->company_id==$company->company_id AND $cc->all==1){ echo "disabled"; } } ?>><?php echo $company->company_name;?></option>
              <?php }?>
          </select>  
      </div>

      <div id="Location">
      </div>
<?php } elseif($option=='Division'){?>
      <div class='col-md-3'>
        <label>Select Company : </label>
      </div>
      <div class="col-md-9">
         <select class="form-control" name="company" id="company" onchange="onchange_val('Division',this.value)" required>
            <option selected disabled>~select a company~</option>
              <?php
                  foreach($companyList as $company){
              ?>
                <option value="<?php echo $company->company_id;?>" <?php foreach($company_setupdisable as $cc){ if($cc->company_id==$company->company_id AND $cc->all==1){ echo "disabled"; } } ?>><?php echo $company->company_name;?></option>
              <?php }?>
          </select>  
      </div>
      <div id="Division">
      </div>
<?php } elseif($option=='Department'){?>

  <div class='col-md-3'>
        <label>Select Company : </label>
      </div>
      <div class="col-md-9">
         <select class="form-control" name="company" id="company" onchange="onchange_val2('Division',this.value)" required>
            <option selected disabled>~select a company~</option>
              <?php
                  foreach($companyList as $company){
              ?>
                <option value="<?php echo $company->company_id;?>" <?php foreach($company_setupdisable as $cc){ if($cc->company_id==$company->company_id AND $cc->all==1){ echo "disabled"; } } ?>><?php echo $company->company_name;?></option>
              <?php }?>
          </select>  
      </div>
      <div id="Division">
      </div>
      <div id="Department">
      </div>

<?php } elseif($option=='Section'){?>

  <div class='col-md-3'>
        <label>Select Company : </label>
      </div>
      <div class="col-md-9">
         <select class="form-control" name="company" id="company" onchange="onchange_val2('company_division',this.value)" required>
            <option selected disabled>~select a company~</option>
              <?php
                  foreach($companyList as $company){
              ?>
                <option value="<?php echo $company->company_id;?>" <?php foreach($company_setupdisable as $cc){ if($cc->company_id==$company->company_id AND $cc->all==1){ echo "disabled"; } } ?>><?php echo $company->company_name;?></option>
              <?php }?>
          </select>  
      </div>
      <div id="company_division">
      </div>

      <div id="company_department">
      </div>

      <div id="Section">
      </div>

<?php } elseif($option=='SubSection'){?>

  <div class='col-md-3'>
        <label>Select Company : </label>
      </div>
      <div class="col-md-9">
         <select class="form-control" name="company" id="company" onchange="onchange_val2('company_division_sub',this.value)" required>
            <option selected disabled>~select a company~</option>
              <?php
                  foreach($companyList as $company){
              ?>
                <option value="<?php echo $company->company_id;?>" <?php foreach($company_setupdisable as $cc){ if($cc->company_id==$company->company_id AND $cc->all==1){ echo "disabled"; } } ?>><?php echo $company->company_name;?></option>
              <?php }?>
          </select>  
      </div>
      <div id="company_division_sub">
      </div>

      <div id="company_department_sub">
      </div>

      <div id="company_section_sub">
      </div>
      <div id="SubSection">
      </div>
<?php } elseif($option=='Employment') {?>
   <div class='col-md-3'>
        <label>Select Company : </label>
      </div>
      <div class="col-md-9">
         <select class="form-control" name="company" id="company"onchange="onchange_val('Employment',this.value)" required>
            <option selected disabled>~select a company~</option>
              <?php
                  foreach($companyList as $company){
              ?>
                <option value="<?php echo $company->company_id;?>" <?php foreach($company_setupdisable as $cc){ if($cc->company_id==$company->company_id AND $cc->all==1){ echo "disabled"; } } ?> ><?php echo $company->company_name;?></option>
              <?php }?>
          </select>  
      </div>
    <div id='Employment'>
   
   </div>

  <?php } elseif($option=='Classification') {?>

  <div class='col-md-3'>
        <label>Select <?php echo $option?> : </label>
      </div>
      <div class="col-md-9">
         <select class="form-control" name="company" id="company" onchange="onchange_val('Classification',this.value)" required>
            <option selected disabled>~select a company~</option>
              <?php
                  foreach($companyList as $company){
              ?>
                <option value="<?php echo $company->company_id;?>" <?php foreach($company_setupdisable as $cc){ if($cc->company_id==$company->company_id AND $cc->all==1){ echo "disabled"; } } ?>><?php echo $company->company_name;?></option>
              <?php }?>
          </select>  
      </div>

      <div id="Classification">
      </div>
 <?php } elseif($option=='Position') {?>
    <div class='col-md-3'>
        <label>Select Company : </label>
      </div>
      <div class="col-md-9">
         <select class="form-control" name="company" id="company"onchange="onchange_val('Position',this.value)" required>
            <option selected disabled>~select a company~</option>
              <?php
                  foreach($companyList as $company){
              ?>
                <option value="<?php echo $company->company_id;?>" <?php foreach($company_setupdisable as $cc){ if($cc->company_id==$company->company_id AND $cc->all==1){ echo "disabled"; } } ?>><?php echo $company->company_name;?></option>
              <?php }?>
          </select>  
      </div>
    <div id='Position'>
   
   </div>

<?php } ?>