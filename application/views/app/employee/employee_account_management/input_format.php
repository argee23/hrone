<?php 
if($input_type=='text'){?>
  <select class="form-control" id='format_data<?php echo $field_no?>'>
      <option disabled selected>Select Format</option>
      <option value='Number'>Numbers Only</option>
      <option value='Alphanumerics'>Alphanumerics </option>
  </select>
<?php } elseif($input_type=='dropdown') {?>
<textarea type="text" rows='3' name="" class="form-control" placeholder="dropdwon data. It should be seperated by dash. for example(yes-no)" id='format_data<?php echo $field_no?>'></textarea>
<?php } elseif($input_type=='datepicker'){ ?>
  <select class="form-control" id='format_data<?php echo $field_no?>'>
      <option disabled selected>Select Date Type</option>
      <option value='date'>Date</option>
      <option value='datetime-local'>Datetime </option>
      <option value='month'>Month and year </option>
      <option value='week'>Week and year </option>
      <option value='time'>Time</option>
  </select>
<?php }?>