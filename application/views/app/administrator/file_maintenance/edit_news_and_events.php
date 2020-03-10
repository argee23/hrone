<?php

$startingtimestamp  = $news_and_events->event_start;
$endingtimestamp    = $news_and_events->event_end;

$start_date         = date('Y-m-d', strtotime($startingtimestamp));
$start_time         = date('H:i:s', strtotime($startingtimestamp));

$end_date         = date('Y-m-d', strtotime($endingtimestamp));
$end_time         = date('H:i:s', strtotime($endingtimestamp));

 ?>

<form class="form-horizontal" method="post" action=" <?php echo base_url() ?>app/file_maintenance/modify_news_and_events/<?php echo $this->uri->segment("4") ?>" > <!-- this allows input fields to have spaces between them -->
			<div class="box-body">
    			<div class="form-group">
    				<label class="col-sm-3 control-label">Company Name</label>
        			<div class="col-sm-9">
                  <input type="hidden" name="company_id" value="<?php echo $news_and_events->company_id?>">
                  <input type="hidden" name="company_name" value="<?php echo $news_and_events->company_name?>">
          	  		<input type="text" class="form-control" placeholder="ID" value ="<?php echo $news_and_events->company_name ?>" disabled="disabled" required>
        			</div>
      			</div>
      			<div class="form-group">
    				<label class="col-sm-3 control-label">Event Title</label>
        			<div class="col-sm-9">
          	  		<input type="text" class="form-control" name="event_title" id="event_title" placeholder="Event Title" value ="<?php echo $news_and_events->event_title ?>" required>
        			</div>
      			</div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Event Description</label>
              <div class="col-sm-9">
                  <textarea class="form-control" name="event_description" id="event_description" placeholder="Event Description" style="width:100%;height:100px" required><?php echo $news_and_events->event_description ?></textarea>
              </div>
            </div>
      			<div class="form-group">
            <label class="col-sm-3 control-label">Start Date</label>
              <div class="col-sm-9">
                <div class="input-group input-append date" id="editDatePicker">
                  <input type="text" class="form-control" name="start_date" value="<?php echo $start_date ?>"/>
                  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Start Time</label>
              <div class="col-sm-9">
                <div class="input-group bootstrap-timepicker timepicker">
                  <input id="editTimePicker" type="text" class="form-control input-small" name="start_time" value="<?php echo $start_time ?>">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">End Date</label>
              <div class="col-sm-9">
                <div class="input-group input-append date" id="editDatePicker2">
                  <input type="text" class="form-control" name="end_date" value="<?php echo $end_date ?>"/>
                  <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">End Time</label>
              <div class="col-sm-9">
                <div class="input-group bootstrap-timepicker timepicker">
                  <input id="editTimePicker2" type="text" class="form-control input-small" name="end_time" value="<?php echo $end_time ?>"/>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
              </div>
            </div>
          		<button type="submit" class="btn btn-warning pull-right"><i class="fa fa-floppy-o"></i> Save</button> 
    	</div>

</form>