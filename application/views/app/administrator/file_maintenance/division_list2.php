                <div class="col-md-12">
                <div class="form-group">
                <label>Select Division: (Can Select Multiple)</label>
                <select required="required" class="form-control select2" name="dept_division[]" id="dept_division" style="width: 100%;" multiple="multiple" >
                <!-- <option value="0"> Main </option> -->
                  <?php 
                    foreach($divisionList as $division){
                  ?>
                <option value="<?php echo $division->division_id;?>"><?php echo $division->division_name?></option>
                <!-- <option value="<?php echo $division->division_id;?>"><?php echo $division->division_name." - ".$division->location_name;?></option> -->
                  <?php }?>
                </select>
                </div>
                <div class="form-group">
                  <div id="fetch2"></div>
                </div>
                </div>
                <div class="form-group">
                <label for="dept_code" class="col-sm-12">Department Code :</label>
                <div class="col-sm-12">
                <input type="text" class="form-control" name="dept_code" id="dept_code" placeholder="Department Code" required>
                </div>
                </div>
                <div class="form-group">
                <label for="dept_name" class="col-sm-12">Department Name :</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="dept_name" id="dept_name" placeholder="Department Name" required>
                </div>

      </div>