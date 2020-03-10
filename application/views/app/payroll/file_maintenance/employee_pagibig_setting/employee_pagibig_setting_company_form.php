<?php 
$check = false;
foreach($payroll_employee_pagibig as $employee_pagibig){?>

<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/employee_pagibig_setting_edit_save/<?php echo $this->uri->segment("4");?>" >

<div class="col-md-12">
<div class="form-group">
<label for="company">Amount</label>
	<input type="number" name="amount" class="form-control" placeholder="00.00" step="any" value="<?php echo $employee_pagibig->amount; ?>" required>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label>Pay Type</label>

          <select name="pay_type" class="form-control" id="pay_type"  required onchange="fetch_cutoff_types();"> 
          <option disabled selected="">Select Pay Type</option>
          <?php
           foreach($paytypeList_dtr as $pay_type){

      echo '<option value="'.$pay_type->pay_type_id.'">'.$pay_type->pay_type_name.'</option>';
          }
          ?>

          </select>

</div>
</div>


<div class="col-md-12">
<div class="form-group">
<label>Deduction (cut-off)</label>
    <select class="form-control" name="cutoff" id="cutoff" required>
        <option selected="selected" value="<?php echo $employee_pagibig->cut_off_id; ?>" ><?php 
if($employee_pagibig->cut_off_id=="0"){
    echo 'per payday';
}else{
    if($employee_pagibig->cut_off_id=="1"){
      $extension="st";
    }elseif($employee_pagibig->cut_off_id=="2"){
      $extension="nd";
    }elseif($employee_pagibig->cut_off_id=="3"){
      $extension="rd";
    }elseif($employee_pagibig->cut_off_id=="4" OR $employee_pagibig->cut_off_id=="5" ){
      $extension="th";
    }else{
      $extension="";
    }
    echo $employee_pagibig->cut_off_id.$extension.' cutoff'; 
}
        ?> 

        </option>

        <?php
          // foreach($pagibig_setting_cutoff as $cutoff){
          //   if($_POST['cutoff'] == $cutoff->param_id){
          //     $selected = "selected='selected'";
          //   }else{
          //     $selected = "";
          //   }
          ?>
         <!--  <option value="<?php //echo $cutoff->param_id;?>" <?php //echo $selected;?>><?php //echo $cutoff->cValue;?></option> -->
        <?php //}?>
    </select>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label>Type</label>
    <select class="form-control" name="pagibig_type" id="pagibig_type" required>
        <option selected="selected" value="<?php echo $employee_pagibig->pagibig_type_id; ?>"><?php echo $employee_pagibig->pagibig_type_name; ?></option>
        <?php
          foreach($pagibig_setting_type as $type){
            if($_POST['type'] == $type->param_id){
              $selected = "selected='selected'";
            }else{
              $selected = "";
            }
          ?>
          <option value="<?php echo $type->param_id;?>" <?php echo $selected;?>><?php echo $type->cValue;?></option>
        <?php }?>
    </select>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
  <button type="submit" class="form-control btn btn-success"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
</div>
</div>

</form>

<?php $check = true;
 } ?>

 <?php if($check === false){?>

<form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/employee_pagibig_setting_add_save/<?php echo $this->uri->segment("4");?>" >

<div class="col-md-12">
<div class="form-group">
<label for="company">Amount</label>
	<input type="number" name="amount_add" class="form-control" placeholder="00.00" step="any" value="" required>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label>Deduction (cut-off)</label>
    <select class="form-control" name="cutoff_add" id="cutoff_add" required>
        <option selected="selected" value="" disabled>~select a deduction~</option>
        <?php
          foreach($pagibig_setting_cutoff as $cutoff){
            if($_POST['cutoff'] == $cutoff->param_id){
              $selected = "selected='selected'";
            }else{
              $selected = "";
            }
          ?>
          <option value="<?php echo $cutoff->param_id;?>" <?php echo $selected;?>><?php echo $cutoff->cValue;?></option>
        <?php }?>
    </select>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label>Type</label>
    <select class="form-control" name="pagibig_type_add" id="pagibibg_type_add" required>
        <option selected="selected" value="" disabled>~select a type~</option>
        <?php
          foreach($pagibig_setting_type as $type){
            if($_POST['type'] == $type->param_id){
              $selected = "selected='selected'";
            }else{
              $selected = "";
            }
          ?>
          <option value="<?php echo $type->param_id;?>" <?php echo $selected;?>><?php echo $type->cValue;?></option>
        <?php }?>
    </select>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
  <button type="submit" class="form-control btn btn-success"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
</div>
</div>

</form>

 <?php } ?>



