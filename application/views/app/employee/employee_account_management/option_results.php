
    <div class="col-md-2" style="padding-top: 10px;">
       <label>Policy Title :</label>
     </div>
   <div class="col-md-10" style="padding-top: 10px;">
    <input type="text" name="add_policy" id="add_policy" class="form-control" placeholder="Input Policy Title">
   </div>


<!-- for account security -->

<?php if($option_results=='account_sec'){?>
  <div class="col-md-4" style="padding-top: 10px;">
    <label>Default Password Selection :</label>
  </div>
  <div class="col-md-8" style="padding-top: 10px;">
        <select class="form-control">
            <option selected>List of Selection</option>
        <?php foreach($acc_sec_default_pass as $row){?>
            <option disabled> <?php echo $row->field_desc?></option>
        <?php } ?>
        </select>
  </div>

   <div class="col-md-4" style="padding-top: 10px;">
    <label>Would you like to add the ff? :</label>
  </div>
  <div class="col-md-8" style="padding-top: 10px;">
       <input type="checkbox" value='download' id='download' class='additional'> <n class='text-danger'>Download Account List</n><br>
       <input type="checkbox" value='reset' id='reset' class='additional'> <n class='text-danger'>Reset All Password</n><br>
  </div>

   <div class="col-md-4">
    <label>Add Note :</label>
  </div>
  <div class="col-md-8">
       <input type="text" class="form-control" id="note" placeholder="optional">
  </div>


<!-- for government fields -->

<?php } elseif($option_results=='govt_fields'){?>

  <div class="col-md-2" style="padding-top: 10px;">
    <label>Default fields :</label>
  </div>
  <div class="col-md-10" style="padding-top: 10px;">
  <?php $i = 0; foreach($table_fields as $row_fields){?>
      <div <?php if($row_fields=='field_id' || $row_fields=='field_name'){ echo "style='display:none;'";}?>> 
      <input type="checkbox" value='<?php echo $row_fields?>' <?php if($row_fields=='field_id' || $row_fields=='field_name'){ } else{echo "class='fields'"; }?>  id='<?php echo $row_fields?>' checked> <n class='text-danger'><?php echo $row_fields?></n><br></div>
  <?php  $i = $i +1; } echo "<input type='hidden' id='no_fields' value='".$i."'>"; ?>
  </div>

  <div class="col-md-2" style="padding-top: 10px;">
    <label>Add Note :</label>
  </div>
  <div class="col-md-10" style="padding-top: 10px;">
       <input type="text" class="form-control" id="note" placeholder="optional">
  </div>

<!-- for disable account  -->

<?php } elseif($option_results=='dis_acct'){?>

  <div class="col-md-2" style="padding-top: 10px;">
    <label>Default fields :</label>
  </div>
  <div class="col-md-10" style="padding-top: 10px;">
      <div class="col-md-3"> <input type="checkbox" value='Company' class='acct' checked> <n class='text-danger'>Company</n></div>
      <div class="col-md-3"> <input type="checkbox" value='Location' class='acct' checked> <n class='text-danger'>Location</n></div>
      <div class="col-md-3"> <input type="checkbox" value='Division' class='acct' checked> <n class='text-danger'>Division</n></div>
      <div class="col-md-3"> <input type="checkbox" value='Department' class='acct' checked> <n class='text-danger'>Department</n></div>
      <div class="col-md-3"> <input type="checkbox" value='Section' class='acct' checked> <n class='text-danger'>Section</n></div>
      <div class="col-md-3"> <input type="checkbox" value='SubSection' class='acct' checked> <n class='text-danger'>SubSection</n></div>
      <div class="col-md-3"> <input type="checkbox" value='Employment' class='acct' checked> <n class='text-danger'>Employment</n></div>
      <div class="col-md-3"> <input type="checkbox" value='Classification' class='acct' checked> <n class='text-danger'>Classification</n></div>
      <div class="col-md-3"> <input type="checkbox" value='Position' class='acct' checked> <n class='text-danger'>Position</n></div>

  </div>

  <div class="col-md-2" style="padding-top: 10px;">
    <label>Add Note :</label>
  </div>
  <div class="col-md-10" style="padding-top: 10px;">
       <input type="text" class="form-control" id="note" placeholder="optional">
  </div>

<!-- for disable account  -->

<?php } elseif($option_results=='notif'){?>

  <div class="col-md-5" style="padding-top: 10px;">
    <label>Newly hired welcome notification :</label>
  </div>
  <div class="col-md-7" style="padding-top: 10px;">
     <div class="col-md-12"><input type="checkbox" value='All' class='who_view' checked> <n class='text-danger'>All Employees </n></div>
    <div class="col-md-12"><input type="checkbox" value='Designation' class='who_view' checked> <n class='text-danger'>Employees Designation Only</n></div>
  </div>

  <div class="col-md-2" style="padding-top: 10px;">
    <label>Add Note :</label>
  </div>
  <div class="col-md-10" style="padding-top: 10px;">
       <input type="text" class="form-control" id="note" placeholder="optional">
  </div>

<?php } elseif($option_results=='mob_tel'){?>
 <div class="col-md-2" style="padding-top: 10px;">
    <label>Add Note :</label>
  </div>
  <div class="col-md-10" style="padding-top: 10px;">
       <input type="text" class="form-control" id="note" placeholder="optional">
  </div>
<?php } else{?>

   <div class="col-md-2" style="padding-top: 10px;">
    <label>No. of fields :</label>
  </div>
  <div class="col-md-10" style="padding-top: 10px;">
    <select class='form-control' onchange="other_add_fields('others',this.value);">
            <option>Select number of fields</option>
        <?php for($x = 1; $x <= 100; $x++){?>
            <option><?php echo $x?></option>
        <?php } ?>
    </select>
  </div> 
  <div class="col-md-12" id='fields_fillup'>
  
  </div>

   <div class="col-md-2">
    <label>Add Note :</label>
  </div>
  <div class="col-md-10">
       <input type="text" class="form-control" id="note" placeholder="optional">
  </div>
<?php } ?>