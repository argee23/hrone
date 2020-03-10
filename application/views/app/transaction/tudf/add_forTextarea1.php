 

      <div class="form-group">
        <label for="accept_value" class="col-sm-2 control-label" >Accept value</label>
        <div class="col-sm-10">
          <select class="form-control" name="accept_value" id="accept_value" onchange="for_single_maxlength();"  required>
              <option selected="selected" value="" disabled="">~ Select Accept Value ~</option>
              <option value="varchar">Alpha numeric only</option>
              <option value="text">Letters only</option>
              <option value="int">Numbers only</option>
          </select>
        </div>
      </div>
     <div class="form-group">
         <label for="max_length" class="col-sm-2 control-label" id="for_ml">Max length</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" name="max_length" id="max_length" placeholder="Max length" value=""  min="1" max="255" required>
        </div>
      </div>