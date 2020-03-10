<div class="row">
<div class="col-md-9">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong><?php echo $employee->group_name; ?></strong>
     <i class="fa fa-arrow-circle-left fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='left' title='View member(s)' onclick="view_group_employee('<?php echo $employee->group_id; ?>')"></i>
  </div>

    <form method="post" action="<?php echo base_url()?>app/time_fixed_schedule/modify_employee_member/<?php echo $this->uri->segment("4");?>" >

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
      <select class="form-control" name="mon" id="mon" required>
        <?php if(!empty($employee->mon)){ ?>
        <option selected="selected" value="<?php echo $employee->mon; ?>" ><?php echo $employee->mon; ?></option>
        <?php } ?>
        <?php if(empty($employee->mon)){?>
        <option selected="selected" value="" disabled>~select shift in and out~</option>
        <?php } ?>
        <option value="restday">Rest day</option>
            <?php foreach($shift_in_out_complete as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_hol as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Tuesday</label>
      <select class="form-control" name="tue" id="tue" required>
        <?php if(!empty($employee->tue)){ ?>
        <option selected="selected" value="<?php echo $employee->tue; ?>" ><?php echo $employee->tue; ?></option>
        <?php } ?>
        <?php if(empty($employee->tue)){?>
        <option selected="selected" value="" disabled>~select shift in and out~</option>
        <?php } ?>
        <option value="restday">Rest day</option>
            <?php foreach($shift_in_out_complete as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_hol as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Wednesday</label>
      <select class="form-control" name="wed" id="wed" required>
        <?php if(!empty($employee->wed)){ ?>
        <option selected="selected" value="<?php echo $employee->wed; ?>" ><?php echo $employee->wed; ?></option>
        <?php } ?>
        <?php if(empty($employee->wed)){?>
        <option selected="selected" value="" disabled>~select shift in and out~</option>
        <?php } ?>
        <option value="restday">Rest day</option>
            <?php foreach($shift_in_out_complete as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_hol as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Thursday</label>
      <select class="form-control" name="thu" id="thu" required>
        <?php if(!empty($employee->thu)){ ?>
        <option selected="selected" value="<?php echo $employee->thu; ?>" ><?php echo $employee->thu; ?></option>
        <?php } ?>
        <?php if(empty($employee->thu)){?>
        <option selected="selected" value="" disabled>~select shift in and out~</option>
        <?php } ?>
        <option value="restday">Rest day</option>
            <?php foreach($shift_in_out_complete as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_hol as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Friday</label>
      <select class="form-control" name="fri" id="fri" required>
        <?php if(!empty($employee->fri)){ ?>
        <option selected="selected" value="<?php echo $employee->fri; ?>" ><?php echo $employee->fri; ?></option>
        <?php } ?>
        <?php if(empty($employee->fri)){?>
        <option selected="selected" value="" disabled>~select shift in and out~</option>
        <?php } ?>
        <option value="restday">Rest day</option>
            <?php foreach($shift_in_out_complete as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_hol as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Saturday</label>
      <select class="form-control" name="sat" id="sat" required>
        <?php if(!empty($employee->sat)){ ?>
        <option selected="selected" value="<?php echo $employee->sat; ?>" ><?php echo $employee->sat; ?></option>
        <?php } ?>
        <?php if(empty($employee->sat)){?>
        <option selected="selected" value="" disabled>~select shift in and out~</option>
        <?php } ?>
        <option value="restday">Rest day</option>
            <?php foreach($shift_in_out_complete as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_hol as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
      </select>
    </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label>Sunday</label>
      <select class="form-control" name="sun" id="sun" required>
        <?php if(!empty($employee->sun)){ ?>
        <option selected="selected" value="<?php echo $employee->sun; ?>" ><?php echo $employee->sun; ?></option>
        <?php } ?>
        <?php if(empty($employee->sun)){?>
        <option selected="selected" value="" disabled>~select shift in and out~</option>
        <?php } ?>
        <option value="restday">Rest day</option>
            <?php foreach($shift_in_out_complete as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_half as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
            <?php foreach($shift_in_out_hol as $shift){?>
            <option value="<?php echo $shift->time_in.' to '.$shift->time_out;?>" ><?php echo $shift->time_in.' to '.$shift->time_out;?></option>
            <?php }?>
      </select>
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


