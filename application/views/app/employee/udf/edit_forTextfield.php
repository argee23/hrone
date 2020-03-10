<div class="form-group">
        <label for="accept_value" class="col-sm-2 control-label" >Accept value</label>
        <div class="col-sm-10">
          <select class="form-control" name="accept_value" id="accept_value" required>
              <!--<option selected="selected" value="<?php echo $user_define_edit->udf_accept_value ?>" >~ <?php echo $user_define_edit->udf_accept_value ?> ~</option> -->
              <option selected="selected" value="" disabled>~ Select ~</option>
              <option value="Alphanumeric">Alpha numeric only</option>
              <option value="Letters">Letters only</option>
              <option value="Numbers">Numbers only</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="max_length" class="col-sm-2 control-label">Max length</label>
        <div class="col-sm-10">
            <!--<input type="number" class="form-control" name="max_length" id="max_length" placeholder="Max length" value="<?php echo $user_define_edit->udf_max_length ?>"  min="1" required> -->
            <input type="number" class="form-control" name="max_length"  id="max_length" placeholder="Max length" value=""  min="1" max="255" required>
        </div>
      </div>