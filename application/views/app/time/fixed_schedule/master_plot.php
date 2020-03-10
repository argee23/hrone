<div class="row">
	<div class="col-md-12">

	<div class="box box-danger">
		<div class="panel panel-danger">
		  <div class="panel-heading"><strong>Group: <?php echo $group_details->group_name; ?></strong>
		  </div>

    <div class="box-body">
  		<form method="post" action="<?php echo base_url()?>app/time_fixed_schedule/save_master_plot/<?php echo $this->uri->segment("4");?>" >

    <div class="col-md-4">
    	<div class="form-group">
      		<label>Monday</label>
		      <select class="form-control" name="mon" required>
		      <option disabled="disabled" selected="selected" value="">Select</option>
		      <option value="restday">restday</option>
		      <?php 
		      if(!empty($reg_shifts)){
		      	foreach($reg_shifts as $rs){
		      		echo '<option value="'.$rs->time_in.' to '.$rs->time_out.'">'.$rs->time_in.' to '.$rs->time_out.'</option>';
		      	}
		      }else{

		      }
		      ?>

            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>

		      </select>
    	</div>
    </div>
    <div class="col-md-4">
    	<div class="form-group">
      		<label>Tuesday</label>
		      <select class="form-control" name="tue" required>
		       <option disabled="disabled" selected="selected" value="">Select</option>
		      <option value="restday">restday</option>
		      <?php 
		      if(!empty($reg_shifts)){
		      	foreach($reg_shifts as $rs){
		      		echo '<option value="'.$rs->time_in.' to '.$rs->time_out.'">'.$rs->time_in.' to '.$rs->time_out.'</option>';
		      	}
		      }else{

		      }
		      ?>


            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
		      
		      </select>		      
    	</div>
    </div>
    <div class="col-md-4">
    	<div class="form-group">
      		<label>Wednesday</label>
		      <select class="form-control" name="wed" required>
		      <option disabled="disabled" selected="selected" value="">Select</option>
		      <option value="restday">restday</option>
		      <?php 
		      if(!empty($reg_shifts)){
		      	foreach($reg_shifts as $rs){
		      		echo '<option value="'.$rs->time_in.' to '.$rs->time_out.'">'.$rs->time_in.' to '.$rs->time_out.'</option>';
		      	}
		      }else{

		      }
		      ?>


            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>

		      </select>		      
    	</div>
    </div>
    <div class="col-md-4">
    	<div class="form-group">
      		<label>Thursday</label>
		      <select class="form-control" name="thu" required>
		     <option disabled="disabled" selected="selected" value="">Select</option>
		      <option value="restday">restday</option>
		      <?php 
		      if(!empty($reg_shifts)){
		      	foreach($reg_shifts as $rs){
		      		echo '<option value="'.$rs->time_in.' to '.$rs->time_out.'">'.$rs->time_in.' to '.$rs->time_out.'</option>';
		      	}
		      }else{

		      }
		      ?>


            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>

		      </select>		      
    	</div>
    </div>
    <div class="col-md-4">
    	<div class="form-group">
      		<label>Friday</label>
		      <select class="form-control" name="fri" required>
		     <option disabled="disabled" selected="selected" value="">Select</option>
		      <option value="restday">restday</option>
		      <?php 
		      if(!empty($reg_shifts)){
		      	foreach($reg_shifts as $rs){
		      		echo '<option value="'.$rs->time_in.' to '.$rs->time_out.'">'.$rs->time_in.' to '.$rs->time_out.'</option>';
		      	}
		      }else{

		      }
		      ?>


            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>		      
		      </select>

    	</div>
    </div>
    <div class="col-md-4">
    	<div class="form-group">
      		<label>Saturday</label>
		      <select class="form-control" name="sat" required>
		       <option disabled="disabled" selected="selected" value="">Select</option>
		      <option value="restday">restday</option>
		      <?php 
		      if(!empty($reg_shifts)){
		      	foreach($reg_shifts as $rs){
		      		echo '<option value="'.$rs->time_in.' to '.$rs->time_out.'">'.$rs->time_in.' to '.$rs->time_out.'</option>';
		      	}
		      }else{

		      }
		      ?>


            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>	

		      </select>	      
    	</div>
    </div>
    <div class="col-md-4">
    	<div class="form-group">
      		<label>Sunday</label>
		      <select class="form-control" name="sun" required>
		       <option disabled="disabled" selected="selected" value="">Select</option>
		      <option value="restday">restday</option>
		      <?php 
		      if(!empty($reg_shifts)){
		      	foreach($reg_shifts as $rs){
		      		echo '<option value="'.$rs->time_in.' to '.$rs->time_out.'">'.$rs->time_in.' to '.$rs->time_out.'</option>';
		      	}
		      }else{

		      }
		      ?>


            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>

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