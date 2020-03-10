<div class="col-md-4">
  <div class="form-group">
    <label for="company">Day</label>
    <select class="form-control" name="day" id="day" onchange="applyFilterDay(this.value);" >
      <option selected="selected" value="0">-All Day-</option>
      <?php 
        for ($day_num=0 ; $day_num < 31; $day_num++) {
          $selected = $day_num;
          $day = $day_num+1;?>
        <option value="<?php echo $day;?>" <?php echo $selected;?>><?php echo $day; ?></option>
        <?php }
        ?>
    </select>
  </div>
</div>