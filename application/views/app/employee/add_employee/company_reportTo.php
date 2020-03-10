<div class="col-md-6">
<div class="form-group">
<label for="reportTo" >Report to</label>
<select class="form-control" name="report_to">
  <option selected="selected" disabled=disabled value="">~select report to~</option>
  <?php 
     foreach($company_reportTo as $reportTo_emp ){
    if($_POST['reportTo_employee'] == $reportTo_emp ->employee_id){
        $selected = "selected='selected'";
    }else{
        $selected = "";
    }
    ?>
    <option value="<?php echo $reportTo_emp->employee_id;?>" <?php echo $selected;?>><?php echo $reportTo_emp->fullname;?></option>
    <?php }?>
</select>
</div>
</div>
  