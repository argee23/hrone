<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/sms/save_sync_setting" >

      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Gateway Table Name of Attendance</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="table_name" id="table_name" placeholder="Gateway Table Name" required value="<?php
echo $sync_setting->table_name?>">
        </div>
      </div>

      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Synchronizer Timer</label>
        <div class="col-sm-10">
          <select class="form-control" name="timer" id="timer" required>
          <option disabled selected>Select</option>
          <?php
          for($a=5;$a<=60;$a+=5){
            if($a==$sync_setting->timer){
              $sel="selected";
            }else{
              $sel="";
            }
            echo '
              <option value="'.$a.'" '.$sel.'>'.$a.' Minutes</option>
            ';
          }
          ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Content First String Equivalent</label>
        <div class="col-sm-10">
    <select class="form-control" name="var_meaning_1st" id="var_meaning_1st" required>
<option disabled selected>Select</option>
<option value="company_code" <?php if($sync_setting->var_meaning_1st=="company_code"){echo "selected";}else{echo "";}?> >Company Code</option>
<option value="employee_id" <?php if($sync_setting->var_meaning_1st=="employee_id"){echo "selected";}else{echo "";}?> >Employee ID</option>

<option value="punch_type" <?php if($sync_setting->var_meaning_1st=="punch_type"){echo "selected";}else{echo "";}?> >Attendance Type</option>
<option value="covered_date" <?php if($sync_setting->var_meaning_1st=="covered_date"){echo "selected";}else{echo "";}?> >Attendance Date</option>
<option value="covered_time" <?php if($sync_setting->var_meaning_1st=="covered_time"){echo "selected";}else{echo "";}?> >Attendance Time</option>
    </select>
        </div>
      </div>
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Content Second String Equivalent</label>
        <div class="col-sm-10">
    <select class="form-control" name="var_meaning_2nd" id="var_meaning_2nd" required>
<option disabled selected>Select</option>
<option value="company_code" <?php if($sync_setting->var_meaning_2nd=="company_code"){echo "selected";}else{echo "";}?> >Company Code</option>
<option value="employee_id" <?php if($sync_setting->var_meaning_2nd=="employee_id"){echo "selected";}else{echo "";}?> >Employee ID</option>

<option value="punch_type" <?php if($sync_setting->var_meaning_2nd=="punch_type"){echo "selected";}else{echo "";}?> >Attendance Type</option>
<option value="covered_date" <?php if($sync_setting->var_meaning_2nd=="covered_date"){echo "selected";}else{echo "";}?> >Attendance Date</option>
<option value="covered_time" <?php if($sync_setting->var_meaning_2nd=="covered_time"){echo "selected";}else{echo "";}?> >Attendance Time</option>
    </select>
        </div>
      </div>
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Content Third String Equivalent</label>
        <div class="col-sm-10">
    <select class="form-control" name="var_meaning_3rd" id="var_meaning_3rd" required>
<option disabled selected>Select</option>
<option value="company_code" <?php if($sync_setting->var_meaning_3rd=="company_code"){echo "selected";}else{echo "";}?> >Company Code</option>
<option value="employee_id" <?php if($sync_setting->var_meaning_3rd=="employee_id"){echo "selected";}else{echo "";}?> >Employee ID</option>

<option value="punch_type" <?php if($sync_setting->var_meaning_3rd=="punch_type"){echo "selected";}else{echo "";}?> >Attendance Type</option>
<option value="covered_date" <?php if($sync_setting->var_meaning_3rd=="covered_date"){echo "selected";}else{echo "";}?> >Attendance Date</option>
<option value="covered_time" <?php if($sync_setting->var_meaning_3rd=="covered_time"){echo "selected";}else{echo "";}?> >Attendance Time</option>
    </select>
        </div>
      </div>
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Content Fourth String Equivalent</label>
        <div class="col-sm-10">
    <select class="form-control" name="var_meaning_4th" id="var_meaning_4th" required>
<option disabled selected>Select</option>
<option value="company_code" <?php if($sync_setting->var_meaning_4th=="company_code"){echo "selected";}else{echo "";}?> >Company Code</option>
<option value="employee_id" <?php if($sync_setting->var_meaning_4th=="employee_id"){echo "selected";}else{echo "";}?> >Employee ID</option>

<option value="punch_type" <?php if($sync_setting->var_meaning_4th=="punch_type"){echo "selected";}else{echo "";}?> >Attendance Type</option>
<option value="covered_date" <?php if($sync_setting->var_meaning_4th=="covered_date"){echo "selected";}else{echo "";}?> >Attendance Date</option>
<option value="covered_time" <?php if($sync_setting->var_meaning_4th=="covered_time"){echo "selected";}else{echo "";}?> >Attendance Time</option>
    </select>
        </div>
      </div>
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Content Fifth String Equivalent</label>
        <div class="col-sm-10">
    <select class="form-control" name="var_meaning_5th" id="var_meaning_5th" required>
<option disabled selected>Select</option>
<option value="company_code" <?php if($sync_setting->var_meaning_5th=="company_code"){echo "selected";}else{echo "";}?> >Company Code</option>
<option value="employee_id" <?php if($sync_setting->var_meaning_1st=="employee_id"){echo "selected";}else{echo "";}?> >Employee ID</option>

<option value="punch_type" <?php if($sync_setting->var_meaning_5th=="punch_type"){echo "selected";}else{echo "";}?> >Attendance Type</option>
<option value="covered_date" <?php if($sync_setting->var_meaning_5th=="covered_date"){echo "selected";}else{echo "";}?> >Attendance Date</option>
<option value="covered_time" <?php if($sync_setting->var_meaning_5th=="covered_time"){echo "selected";}else{echo "";}?> >Attendance Time</option>
    </select>
        </div>
      </div>
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Time IN Code</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="in_code" id="in_code" placeholder="Time IN Code" required value="<?php echo $sync_setting->in_code?>">
        </div>
      </div>
      <div class="form-group">
        <label for="advanceType" class="col-sm-2 control-label">Time OUT Code</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="out_code" id="out_code" placeholder="Time OUT Code" required value="<?php echo $sync_setting->out_code?>">
        </div>
      </div>

          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
  </form>
  </div>