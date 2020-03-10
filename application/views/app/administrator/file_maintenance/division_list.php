
                <div class="form-group">
                <label>Select Division:</label>
                <select class="form-control select2" name="division" id="division" style="width: 100%;" <?php if(!isset($section)) { ?>onchange="fetchDivDepts(this.value)" <?php } else{ ?> onchange="fetchDivDeptsSec(this.value)" <?php } ?> >
                <option selected="selected" disabled="disabled" value="">- Select Division -</option>
                <!-- <option value="0"> Main </option> -->
                  <?php 
                    foreach($divisionList as $division){
                  ?>
                <option value="<?php echo $division->division_id;?>"><?php echo $division->division_name?></option>
                  <?php }?>
                </select>
                </div>
                <div class="form-group">
                  <div id="fetch2"></div>
                </div>