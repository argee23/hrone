	<div class="form-group">
        <label for="section_name" control-label">Section Name: </label>
        <input type="text" class="form-control" name="section_name" id="section_name" placeholder="Section Name" required>
   	</div>
   	<div class="form-group">
        <label for="wSubsection" class="pull-left"> Has Subsections? </label>
        <div class="col-sm-8">
        	<input type="radio" name="subsection" value="0" required> No
        </div>
        <div class="col-sm-8">
            <input type="radio" name="subsection" value="1"> Yes
        </div>
     </div>
        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>