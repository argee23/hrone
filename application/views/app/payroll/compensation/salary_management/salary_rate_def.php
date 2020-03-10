  <div class="form-group">
          <label for="company">Salary Rate</label>
           <select class="form-control" name="salary_rate" id="salary_rate" onchange="view_salary_computation(this.value)" required>
            <option selected="selected" value="" disabled>~select salary rate~</option>
            <?php
              foreach($salary_rate as $rate){
              if($_POST['rate'] == $rate->salary_rate_id){
                  $selected = "selected='selected'";
              }else{
                  $selected = "";
              }
              ?>
              <option value="<?php echo $rate->salary_rate_id;?>" <?php echo $selected;?>><?php echo $rate->salary_rate_name;?></option>
              <?php }?>
          </select>
          <p style="color:#ff0000;">Salary Rate is required</p>
        </div>