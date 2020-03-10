
                <div class="form-group">
                <label>Select Division:</label>
          			<select class="form-control select2" name="division_add" id="division_add" style="width: 100%;" onchange="examineDiv(this.value)" required="required" >
          			<option selected="selected" disabled="disabled" value="">- Select Division -</option>
                <!-- <option value="0"> Main </option> -->
          				<?php 
            				foreach($divisionList as $division){
            			?>
            		<option value="<?php echo $division->division_id;?>"><?php echo $division->division_name?></option>
            			<?php }?>
          			</select>
                </div>
                <div id="department"></div>