<div class="row">
	<div class="col-md-12">

	<div class="box box-danger">
		<div class="panel panel-danger">
		  <div class="panel-heading"><strong>Group: <?php echo $group_details->group_name; ?></strong>
		  </div>

    <div class="box-body">

    <form method="post" action="<?php echo base_url()?>app/time_flexi_schedule/save_master_plot/<?php echo $this->uri->segment("4");?>/<?php echo $this->uri->segment("5");?>" >

    <div class="col-md-6">
    <div class="form-group">
      <label>Monday</label>
      <select class="form-control" name="mon" id="mon">
      <option value="<?php echo $group_details->group_type; ?>"><?php echo $group_details->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Tuesday</label>
      <select class="form-control" name="tue" id="tue">
      <option value="<?php echo $group_details->group_type; ?>"><?php echo $group_details->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Wednesday</label>
      <select class="form-control" name="wed" id="wed">
      <option value="<?php echo $group_details->group_type; ?>"><?php echo $group_details->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Thursday</label>
      <select class="form-control" name="thu" id="thu">
      <option value="<?php echo $group_details->group_type; ?>"><?php echo $group_details->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Friday</label>
      <select class="form-control" name="fri" id="fri">
      <option value="<?php echo $group_details->group_type; ?>"><?php echo $group_details->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Saturday</label>
      <select class="form-control" name="sat" id="sat">
      <option value="<?php echo $group_details->group_type; ?>"><?php echo $group_details->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Sunday</label>
      <select class="form-control" name="sun" id="sun">
      <option value="<?php echo $group_details->group_type; ?>"><?php echo $group_details->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>
    <div class="col-md-4">
    	<div class="form-group">
      		<label>Standard Schedule</label>
		      <select class="form-control" name="shift_in_out" id="shift_in_out" required>
		     <option disabled="disabled" selected="selected" value="">Select</option>
		      <?php 
		      if(!empty($reg_shifts)){
		      	foreach($reg_shifts as $rs){
		      		echo '<option value="'.$rs->time_in.'-'.$rs->time_out.'">'.$rs->time_in.' to '.$rs->time_out.'</option>';
		      	}
		      }else{

		      }
		      ?>
		      </select>
    	</div>
    </div>

	<div class="col-md-8">
		<div class="form-group">
			<label>Note: This plotting will take effect to all the members of the group selected.</label>
			<button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE</button>
		</div>
	</div>

		</form>
	</div>

			</div>
		</div>
	</div>
</div>