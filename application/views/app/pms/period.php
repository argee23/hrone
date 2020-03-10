      <label for="message">Payroll Period Group</label>
  <select class="form-control" name="payroll_period_group_id" required >

            <option  disabled="" selected="" value="">select appraisal goup</option>

            <?php foreach($payroll_period_group as $row){?><option value="<?php echo $row->pay_type_id;?>"><?php echo $row->pay_type_name; ?></option><?php }?>

</select>