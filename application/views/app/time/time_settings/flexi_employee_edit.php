<div class="well">
<!-- form start -->
      <?php $company_id= $this->uri->segment('5'); 
$location_name=$this->time_settings_model->get_location($company_id);
if(!empty($location_name)){
      $cur_loc= $location_name->company_name; //current location
      $cur_loc_id= $location_name->company_id; //current location
}else{
      $cur_loc ="<i class='fa fa-warning text-danger'></i> Location not found.";
}
?>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_settings/save_flexi_employee_edit/<?php echo $cur_loc_id;?>" >
      <div class="form-group">
        <div class="col-sm-12">
     <i class="fa fa-edit text-danger"></i><strong>Edit Individual Employee Flexi Schedule Tagging  [ <?php echo $cur_loc;?> ]</strong>
        </div>
      </div>
      <div style="text-align: center" class="form-group" >
      <input type="hidden" name="company_id" value="<?php echo $cur_loc_id;?>">
      <input type="hidden" name="flexi_id" value="<?php echo $flexi_emp->flexi_id;?>">
      <input type="hidden" name="employee_string" value="<?php echo $flexi_emp->name;?>">
      <label for="employee"  class="col-sm-12 control-label"><a type="button" class="btn btn-success btn-xs"><i class="fa fa-user"></i></a> &nbsp;&nbsp;[<?php echo $flexi_emp->name;?>]</label>
     
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Monday</label>
        <div class="col-sm-6">
          <select name="monday" class="form-control select2" required>
            <option value="<?php echo $flexi_emp->monday;?>" selected ><?php echo $flexi_emp->monday;?></option>
            <option value="0" disabled>----------</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Tuesday</label>
        <div class="col-sm-6">
          <select name="tuesday" class="form-control select2" required>
            <option value="<?php echo $flexi_emp->tuesday;?>" selected ><?php echo $flexi_emp->tuesday;?></option>
            <option value="0" disabled>----------</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Wednesday</label>
        <div class="col-sm-6">
          <select name="wednesday" class="form-control select2" required>
            <option value="<?php echo $flexi_emp->wednesday;?>" selected ><?php echo $flexi_emp->wednesday;?></option>
            <option value="0" disabled>----------</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Thursday</label>
        <div class="col-sm-6">
          <select name="thursday" class="form-control select2" required>
            <option value="<?php echo $flexi_emp->thursday;?>" selected ><?php echo $flexi_emp->thursday;?></option>
            <option value="0" disabled>----------</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Friday</label>
        <div class="col-sm-6">
          <select name="friday" class="form-control select2" required>
            <option value="<?php echo $flexi_emp->friday;?>" selected ><?php echo $flexi_emp->friday;?></option>
            <option value="0" disabled>----------</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Saturday</label>
        <div class="col-sm-6">
          <select name="saturday" class="form-control select2" required>
            <option value="<?php echo $flexi_emp->saturday;?>" selected ><?php echo $flexi_emp->saturday;?></option>
            <option value="0" disabled>----------</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Sunday</label>
        <div class="col-sm-6">
          <select name="sunday" class="form-control select2" required>
            <option value="<?php echo $flexi_emp->sunday;?>" selected ><?php echo $flexi_emp->sunday;?></option>
            <option value="0" disabled>----------</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Start Shift on Actual Time IN</label>
        <div class="col-sm-6">
          <select name="base_on_actual_time_in" class="form-control select2" required>
            <option value="<?php echo $flexi_emp->base_on_actual_time_in;?>" selected ><?php echo $flexi_emp->base_on_actual_time_in;?></option>
            <option value="0" disabled>----------</option>
            <option value="yes">yes</option>
            <option value="no">no</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="" class="col-sm-6 control-label">Shift Hours</label>
        <div class="col-sm-6">
          <select name="shift_hours" class="form-control select2" required>
            <option value="<?php echo $flexi_emp->shift_hours;?>" selected ><?php echo $flexi_emp->shift_hours;?> hours</option>
            <option value="8">8.00 hrs</option>
            <option value="9">9.00 hrs</option>
            <option value="10">10.00 hrs</option>
            <option value="11">11.00 hrs</option>
            <option value="12">12.00 hrs</option>
          </select>
        </div>
      </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
  </form>
  </div>
