<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_shift_table/save_add_wshd" ><!-- //save_add_wshd: save add working schedule halfday (halfday) -->
    <div class="box-body">
      <div class="form-group">
      <strong>
    <?php 
         $company_id =$this->uri->segment('4');
         $current_comp=$this->time_shift_table_model->get_company($company_id);
         if(!empty($current_comp)){
           $company_name = $current_comp->company_name;
         }else{
           $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
           <i class="fa fa-angle-double-right text-danger"></i> Add Working Schedule Reference (Half Day)
      </strong>
      </div>


      <div class="form-group">
        <label for="time_out" class="col-sm-4">Time IN</label>
        <div class="col-sm-8">
        <select name="time_in_hr" class="time_class">
        <option selected disabled>Hour</option>
          <?php 
          for ($hr = 0; $hr <= 23; $hr++) {
              echo '<option value="'.sprintf("%02d", $hr).'">'.sprintf("%02d", $hr).'</option>';
          } 
          ?>
        </select>
        :
        <select name="time_in_minute"  class="time_class">
        <option selected disabled>Minute</option>
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
        <option selected disabled>Hour</option>
          <?php 
          for ($hr = 0; $hr <= 23; $hr++) {
              echo '<option value="'.sprintf("%02d", $hr).'">'.sprintf("%02d", $hr).'</option>';
          } 
          ?>
        </select>
        :
        <select name="time_out_minute"  class="time_class">
         <option selected disabled>Minute</option>
          <?php 
          for ($hr = 0; $hr <= 60; $hr++) {
              echo '<option value="'.sprintf("%02d", $hr).'">'.sprintf("%02d", $hr).'</option>';
          } 
          ?>
        </select>
        </div>
      </div>
     <input type="hidden" name="company_name" value="<?php echo $company_name; ?>">
      <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">


      <div class="form-group">
        <label for="break_1" class="col-sm-4 control-label">Break</label>
        <div class="col-sm-8">
          <select name="break_1" class="form-control select2">
            <?php $n="00";while($n!=65){ ?>
            <option value="<?php echo sprintf("%02d", $n);?>" ><?php echo sprintf("%02d", $n);?></option>
            <?php $n=$n+5;} ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="no_of_hours" class="col-sm-4 control-label">Registered Hours</label>
        <div class="col-sm-8">
        <!--  <input type="text" class="form-control" name="no_of_hours" placeholder="Registered Hours" maxlength="10" required> -->
        <select name="no_of_hours" class="form-control">
          <?php 
          for ($hr = 4; $hr <= 5; $hr++) {
              echo '<option value="'.$hr.'">'.$hr.'</option>';
          } 
          ?>
        </select>


        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-4 control-label">Description</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="description" id="description" placeholder="Description">
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-4 control-label">Classifications</label>
        <div class="col-sm-8">
           <?php 
          foreach($company_classifications as $cl){
            $cl_id=$cl->classification_id;

            echo '<input type="checkbox" name="classification_id[]" value="'.$cl_id.'" checked>&nbsp;'.$cl->classification."<br>";

          }
          ?>
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