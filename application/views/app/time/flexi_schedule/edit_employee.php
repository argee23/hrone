<div class="row">
<div class="col-md-12">


<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong><?php echo $employee->group_name; ?></strong> (<?php if($employee->group_type === 'full_flexi'){ echo 'Full flexi'; } else if($employee->group_type === 'controlled_flexi'){ echo 'Controlled flexi'; }?> )
   <i class="fa fa-arrow-circle-left fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='left' title='View member(s)' onclick="view_group_employee('<?php echo $employee->flexi_group_id; ?>')"></i>
  </div>

    <form method="post" action="<?php echo base_url()?>app/time_flexi_schedule/modify_employee_member/<?php echo $this->uri->segment("4");?>" >

    <div class="box-body">

    
    <div class="row">
      <div class="col-md-12">
      <div class="form-group">
        <div class="col-sm-4">
        <p>Employee ID</p>
        </div>
        <div class="col-sm-7">
          <label>
              <label><?php echo $employee->employee_id; ?></label>
          </label>
        </div>
      </div>
      </div>

      <div class="col-md-12">
      <div class="form-group">
        <div class="col-sm-4">
        <p>Employee Name</p>
        </div>
        <div class="col-sm-7">
          <label>
              <label><?php echo $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' '.$employee->name_extension; ?></label>
          </label>
        </div>
      </div>
      </div>

      <div class="col-md-12">
      <div class="form-group">
        <div class="col-sm-4">
        <p>Company</p>
        </div>
        <div class="col-sm-7">
          <label>
              <label><?php echo $employee->company_name; ?></label>
          </label>
        </div>
      </div>
      </div>

      <div class="col-md-12">
      <div class="form-group">
        <div class="col-sm-4">
        <p>Classification</p>
        </div>
        <div class="col-sm-7">
          <label>
              <label><?php echo $employee->classification; ?></label>
          </label>
        </div>
      </div>
      </div>
    </div>

    <br>
    <div class="col-md-6">
    <div class="form-group">
      <label>Monday</label>
      <select class="form-control" name="mon" id="mon">
      <?php if($employee->mon === 'restday'){?>
          <option value="restday" selected>Rest day</option>
      <?php } ?>

      <option value="<?php echo $employee->group_type; ?>"><?php echo $employee->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Tuesday</label>
      <select class="form-control" name="tue" id="tue">
      <?php if($employee->tue === 'restday'){?>
          <option value="restday" selected>Rest day</option>
      <?php } ?>
      <option value="<?php echo $employee->group_type; ?>"><?php echo $employee->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Wednesday</label>
      <select class="form-control" name="wed" id="wed">
      <?php if($employee->wed === 'restday'){?>
          <option value="restday" selected>Rest day</option>
      <?php } ?>
      <option value="<?php echo $employee->group_type; ?>"><?php echo $employee->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Thursday</label>
      <select class="form-control" name="thu" id="thu">
      <?php if($employee->thu === 'restday'){?>
          <option value="restday" selected>Rest day</option>
      <?php } ?>
      <option value="<?php echo $employee->group_type; ?>"><?php echo $employee->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Friday</label>
      <select class="form-control" name="fri" id="fri">
      <?php if($employee->fri === 'restday'){?>
          <option value="restday" selected>Rest day</option>
      <?php } ?>
      <option value="<?php echo $employee->group_type; ?>"><?php echo $employee->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Saturday</label>
      <select class="form-control" name="sat" id="sat">
       <?php if($employee->sat === 'restday'){?>
          <option value="restday" selected>Rest day</option>
      <?php } ?>
      <option value="<?php echo $employee->group_type; ?>"><?php echo $employee->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Sunday</label>
      <select class="form-control" name="sun" id="sun">
      <?php if($employee->sun === 'restday'){?>
          <option value="restday" selected>Rest day</option>
      <?php } ?>
      <option value="<?php echo $employee->group_type; ?>"><?php echo $employee->group_type; ?></option>
      <option value="restday">Rest day</option>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Standard shift in and out</label>
      <select class="form-control" name="shift_in_out" id="shift_in_out" required>
        <?php if(!empty($employee->standard_shift_in)&&!empty($employee->standard_shift_out)){ ?>
        <option selected="selected" value="<?php echo $employee->standard_shift_in.'-'.$employee->standard_shift_out; ?>" ><?php echo $employee->standard_shift_in.'-'.$employee->standard_shift_out; ?></option>
        <?php } ?>
        <?php if(empty($employee->standard_shift_in)&&empty($employee->standard_shift_out)){?>
        <option selected="selected" value="" disabled>~select shift in and out~</option>
        <?php } ?>
            <?php foreach($shift_in_out_complete as $shift){?>
            <option value="<?php echo $shift->time_in.'-'.$shift->time_out;?>" ><?php echo $shift->time_in.'-'.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.'-'.$shift->time_out;?>" ><?php echo $shift->time_in.'-'.$shift->time_out;?></option>
            <?php }?>
            <?php// foreach($shift_in_out_hol as $shift){?>
            <!-- <option value="<?php //echo $shift->time_in.'-'.$shift->time_out;?>" ><?php //echo $shift->time_in.'-'.$shift->time_out;?></option> -->
            <?php //}?>
      </select>
    </div>
    </div>


    <div class="col-md-6">
    <div class="form-group">
      <label>Schedule Tagging</label><br>
<input type="radio" name="schedule_tagging" value="follow_flexi_shift_table" <?php if($employee->schedule_tagging=="follow_flexi_shift_table"){echo "checked";}else{}?> >Follow Flexi Schedules Table.
<input type="radio" name="schedule_tagging" value="follow_time_in" <?php if($employee->schedule_tagging=="follow_time_in"){echo "checked";}else{}?>>Follow Time IN as the start of Shift.
    </div>
    </div>


     <br>
     <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
     </div>
    </div><!-- /.box-body -->
    </form>
</div>
</div>

</div>  
</div>


