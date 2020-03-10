                <div class="form-group">
                <label>Select Location : </label>
                <select required="required" class="form-control select2" name="location" id="location" style="width: 100%;" <?php if(!isset($section)) { ?>onchange="getLocation(this.value)" <?php } else{ ?> onchange="getLocationSec(this.value)" <?php } ?> >
                <option value="" disabled="disabled" selected="selected"> - Select Location - </option> 
                  <?php 
                    foreach($divisionList as $division){
                  ?>
                <option value="<?php echo $division->location_id;?>"><?php echo $division->location_name ?></option>
                  <?php }?>
                </select>
                </div>
                <div id="add"></div>