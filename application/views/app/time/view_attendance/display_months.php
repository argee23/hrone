    <div class="col-md-4">
      <div class="form-group">
        <label for="company">Month</label>
        <select class="form-control" name="month" id="month" onchange="get_dayList(this.value); applyFilter(this.value);">
          <option selected="selected" value="0" disabled>-Select month-</option>
            <?php 
            for ($month_num=1 ; $month_num <=12; $month_num++) {
              $selected = $month_num; ?>
            <option value="<?php echo $month_num;?>" <?php echo $selected;?>><?php echo date('M', mktime(0,0,0,$month_num)); ?></option>
            <?php }
            ?>

        </select>
      </div>
    </div>