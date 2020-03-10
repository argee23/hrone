<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_shift_table/save_add_wsc" >
    <div class="box-body">
      <div class="form-group">
      <strong>
      <?php  $classification ="1";//$this->uri->segment('4');
         $current_clas=$this->time_shift_table_model->get_classification($classification);
         if(!empty($current_clas)){
            echo $current_classification = $current_clas->classification;
         }else{
            echo "classification not exist";
         }?>
         <br>
      <i class="fa fa-plus text-danger"></i> Working Schedule Reference (Regular)
      </strong>
      </div>
      <div class="form-group">
      <input type="hidden" name="classification_name" value="<?php echo $current_classification; ?>">
      <input type="hidden" name="classification_id" value="<?php echo $classification; ?>">
        <label for="time_in" class="col-sm-4 control-label">Time IN</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="time_in" id="time_in" placeholder="Time IN" required>
        </div>
      </div>
      <div class="form-group">
        <label for="time_out" class="col-sm-4 control-label">Time OUT</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="time_out" id="time_out" placeholder="Time OUT" required>
        </div>
      </div>
      <div class="form-group">
        <label for="lunch_break" class="col-sm-4 control-label">Lunch Break</label>
        <div class="col-sm-8">
          <select name="lunch_break" class="form-control select2" required>
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
            <?php $n="00";while($n!=65){ ?>
            <option value="<?php echo sprintf("%02d", $n);?>" ><?php echo sprintf("%02d", $n);?></option>
            <?php $n=$n+5;} ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="no_of_hours" class="col-sm-4 control-label">Registered Hours</label>
        <div class="col-sm-8">
         <input type="text" class="form-control" name="no_of_hours" placeholder="Registered Hours" maxlength="10" required>
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-4 control-label">Description</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="description" id="description" placeholder="Description">
        </div>
      </div>

          <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
          <?php
            echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Save';
          ?>

          </button>

      
         <!--  <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-floppy-o"></i> Save</button> -->
    </div><!-- /.box-body -->
  </form>
  </div>