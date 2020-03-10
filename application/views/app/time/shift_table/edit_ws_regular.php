<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_shift_table/save_edit_wsc/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <div class="form-group">
      <strong>
    <?php 
         $company_id =$wsc->company_id;
         $current_comp=$this->time_shift_table_model->get_company($company_id);
         if(!empty($current_comp)){
            echo $company_name = $current_comp->company_name;
         }else{
            echo $company_name="classification not exist";
         }
         $this->uri->segment("4");
       ?>
         <br>
      <i class="fa fa-edit text-danger"></i> Working Schedule Reference (Regular)
      <!-- //wsc: working schedule complete -->
      </strong>
      </div>

      <input type="hidden" name="company_name" value="<?php echo $company_name; ?>">
      <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
      <input type="hidden" name="classification_id" value="<?php echo $wsc->classification; ?>">

      <?php 
      $time_in_hr=substr($wsc->time_in, 0,2);
      $time_in_minute=substr($wsc->time_in, 3,2);
      $time_out_hr=substr($wsc->time_out, 0,2);
      $time_out_minute=substr($wsc->time_out, 3,2);

      ?>

      <div class="form-group">
        <label for="time_out" class="col-sm-4">Time IN</label>
        <div class="col-sm-8">
        <select name="time_in_hr" class="time_class">
        <option value="<?php echo $time_in_hr;?>"><?php echo $time_in_hr;?></option>
          <?php 
          for ($hr = 0; $hr <= 23; $hr++) {
              echo '<option value="'.sprintf("%02d", $hr).'">'.sprintf("%02d", $hr).'</option>';
          } 
          ?>
        </select>
        :
        <select name="time_in_minute"  class="time_class">
         <option value="<?php echo $time_in_minute;?>"><?php echo $time_in_minute;?></option>
          <?php 
          for ($hr = 0; $hr <= 60; $hr++) {
              echo '<option value="'.sprintf("%02d", $hr).'">'.sprintf("%02d", $hr).'</option>';
          } 
          ?>
        </select>
        </div>
      </div>

      <div class="form-group">
        <label for="time_out" class="col-sm-4">Time OUT</label>
        <div class="col-sm-8">
        <select name="time_out_hr" class="time_class">
         <option value="<?php echo $time_out_hr;?>"><?php echo $time_out_hr;?></option>
          <?php 
          for ($hr = 0; $hr <= 23; $hr++) {
              echo '<option value="'.sprintf("%02d", $hr).'">'.sprintf("%02d", $hr).'</option>';
          } 
          ?>
        </select>
        :
        <select name="time_out_minute"  class="time_class">
          <option value="<?php echo $time_out_minute;?>"><?php echo $time_out_minute;?></option>
          <?php 
          for ($hr = 0; $hr <= 60; $hr++) {
              echo '<option value="'.sprintf("%02d", $hr).'">'.sprintf("%02d", $hr).'</option>';
          } 
          ?>
        </select>
        </div>
      </div>

      <div class="form-group">
        <label for="lunch_break" class="col-sm-4 control-label">Lunch Break</label>
        <div class="col-sm-8">
          <select name="lunch_break" class="form-control select2" required>
            <option value="<?php echo $wsc->lunch_break;?>"><?php echo $wsc->lunch_break;?></option>
            <?php $n="00";while($n!=65){ ?>
            <option value="<?php echo sprintf("%02d", $n);?>" ><?php echo sprintf("%02d", $n);?></option>
            <?php $n=$n+5;} ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="break_1" class="col-sm-4 control-label">1st Break</label>
        <div class="col-sm-8">
          <select name="break_1" class="form-control select2">
            <option value="<?php echo $wsc->break_1;?>"><?php echo $wsc->break_1;?></option>
            <?php $n="00";while($n!=65){ ?>
            <option value="<?php echo sprintf("%02d", $n);?>" ><?php echo sprintf("%02d", $n);?></option>
            <?php $n=$n+5;} ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="break_2" class="col-sm-4 control-label">2nd Break</label>
        <div class="col-sm-8">
          <select name="break_2" class="form-control select2">
            <option value="<?php echo $wsc->break_2;?>"><?php echo $wsc->break_2;?></option>
            <?php $n="00";while($n!=65){ ?>
            <option value="<?php echo sprintf("%02d", $n);?>" ><?php echo sprintf("%02d", $n);?></option>
            <?php $n=$n+5;} ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="no_of_hours" class="col-sm-4 control-label">Registered Hours</label>
        <div class="col-sm-8">
      <!--    <input type="text" class="form-control" name="no_of_hours" placeholder="Registered Hours" maxlength="10" required value="<?php //echo $wsc->no_of_hours;?>"> -->

        <select name="no_of_hours" class="form-control">
        <option value="<?php echo $wsc->no_of_hours;?>"><?php echo $wsc->no_of_hours;?></option>
          <?php 
          for ($hr = 8; $hr <= 12; $hr = $hr + 0.1) {
              echo '<option value="'.$hr.'">'.$hr.'</option>';
          } 
          ?>
        </select>



        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-4 control-label">Description</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php echo $wsc->description;?>">
        </div>
      </div>
        <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Save';
          ?>

          </button>
      
          <!-- <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button> -->
    </div><!-- /.box-body -->
  </form>
  </div>