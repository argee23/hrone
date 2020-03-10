<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_news_and_events" > <!--on class -> this allows input fields to have spaces between them -->

			<div class="box-body">
				<div class="form-group">
    				<label class="col-sm-3 control-label">Select Company (Can select multiple)</label>
        			<div class="col-sm-9">
          	  	<select multiple="multiple" class="form-control select2" name="company[]" style="width: 100%;" required>
		      			<!-- <option selected="selected" disabled="disabled" value="">- Choose Company -</option>
		      			<option value="0"> All </option> -->
		      			<?php 
		        				foreach($companyList as $company){
		        				if($_POST['company'] == $company->company_id){
		            				$selected = "selected='selected'";
		        				}
		        				else{
		            				$selected = "";
		        				}
		        		?>
		        		<option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
		        		<?php }?>
						</select>
        			</div>
      			</div>
      			<div class="form-group">
    				<label class="col-sm-3 control-label">Event Title</label>
        			<div class="col-sm-9">
          	  		<input type="text" class="form-control" name="event_title" id="event_title" placeholder="Event Title" value ="<?php echo set_value('event_title')?>" required>
        			</div>
      			</div>
      			<div class="form-group">
    				<label class="col-sm-3 control-label">Event Description</label>
        			<div class="col-sm-9">
          	  		<textarea name="event_description" id="event_description" placeholder="Put some description for your event here..." class="form-control" style="width:100%;height:100px" required></textarea>
        			</div>
      			</div>
      			
            <div class="form-group">
            <label class="col-sm-3 control-label">Start Date</label>
              <div class="col-sm-9">
                <div class="input-group input-append date" id="datePicker">
                  <input type="text" class="form-control" name="start_date" required />
                  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Start Time</label>
              <div class="col-sm-9">
                <div class="input-group bootstrap-timepicker timepicker">
                  <input id="timePicker" type="text" class="form-control input-small" name="start_time" required>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">End Date</label>
              <div class="col-sm-9">
                <div class="input-group input-append date" id="datePicker2">
                  <input type="text" class="form-control" name="end_date" required />
                  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">End Time</label>
              <div class="col-sm-9">
                <div class="input-group bootstrap-timepicker timepicker">
                  <input id="timePicker2" type="text" class="form-control input-small" name="end_time" required />
                  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
              </div>
            </div>
          		<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button> 
    		</div>

</form>