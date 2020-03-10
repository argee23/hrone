                <div class="form-group">
                <label>Select Location </label>
          			<select required="required" class="form-control select2" name="location_add" id="location_add" style="width: 100%;" <?php if(isset($type)){ echo 'onchange="examineLocSubView(this.value)"'; } else { echo 'onchange="examineLocSub(this.value)"'; } ?> >
                <option value="" disabled="disabled" selected="selected"> - Select Location - </option> 
          				<?php 
            				foreach($locationList as $location){
            			?>
            		<option value="<?php echo $location->location_id;?>"><?php echo $location->location_name ?></option>
            			<?php }?>
          			</select>
                </div>
                <?php if(isset($type)){ echo '<div id="divisionAddView"></div>'; } 
                else { echo '<div id="divisionAdd"></div>'; } ?>
                