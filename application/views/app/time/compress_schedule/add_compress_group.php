<div class="well">

<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_compress_schedule/save_time_compress_group" >
<input type="hidden" name="company_id" value="<?php echo $myComp->company_id;?>">
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Group Name</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="compress_group_name" id="compress_group_name" placeholder="Compress Group Name" required>
    </div>
  </div>  
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Mon (No.of Hrs)</label>
    <div class="col-sm-9">
      <select class="form-control" name="c_mon" required>
        <option selected disabled value="">Select</option>
        <option value="rest day">Rest day</option>
        <?php
          $x = 4; 
          while($x <= 16) {
              echo '<option value="'.$x.'">'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>  
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Tue (No.of Hrs)</label>
    <div class="col-sm-9">
      <select class="form-control" name="c_tue" required>
        <option selected disabled value="">Select</option>
         <option value="rest day">Rest day</option>
        <?php
          $x = 4; 
          while($x <= 16) {
              echo '<option value="'.$x.'">'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>  
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Wed (No.of Hrs)</label>
    <div class="col-sm-9">
      <select class="form-control" name="c_wed" required>
        <option selected disabled value="">Select</option>
         <option value="rest day">Rest day</option>
        <?php
          $x = 4; 
          while($x <= 16) {
              echo '<option value="'.$x.'">'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>  
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Thu (No.of Hrs)</label>
    <div class="col-sm-9">
      <select class="form-control" name="c_thu" required>
        <option selected disabled value="">Select</option>
         <option value="rest day">Rest day</option>
        <?php
          $x = 4; 
          while($x <= 16) {
              echo '<option value="'.$x.'">'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>  
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Fri (No.of Hrs)</label>
    <div class="col-sm-9">
      <select class="form-control" name="c_fri" required>
        <option selected disabled value="">Select</option>
         <option value="rest day">Rest day</option>
        <?php
          $x = 4; 
          while($x <= 16) {
              echo '<option value="'.$x.'">'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>  
  
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Sat (No.of Hrs)</label>
    <div class="col-sm-9">
      <select class="form-control" name="c_sat" required>
        <option selected disabled value="">Select</option>
         <option value="rest day">Rest day</option>
        <?php
          $x = 4; 
          while($x <= 16) {
              echo '<option value="'.$x.'">'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>  

  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Sun (No.of Hrs)</label>
    <div class="col-sm-9">
      <select class="form-control" name="c_sun" required>
        <option selected disabled value="">Select</option>
         <option value="rest day">Rest day</option>
        <?php
          $x = 4; 
          while($x <= 16) {
              echo '<option value="'.$x.'">'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>  

  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Required Actual Hrs rendered of halfday employees</label>
    <div class="col-sm-9">
      <select class="form-control" name="halfday_required_hrs" required>
        <option selected disabled value="">Select</option>
        <?php
          $x = 2; 
          while($x <= 10){
              echo '<option value="'.$x.'">'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>	
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Number of hours to count tardiness as half day absent</label>
    <div class="col-sm-9">
      <select class="form-control" name="count_as_halfday_due_to_late" required>
       <option selected disabled value="">Select</option>
        <?php
          $x = 2; 
          while($x <= 8){

              echo '<option value="'.$x.'" >'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>  
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Number of hours to count under time as half day absent</label>
    <div class="col-sm-9">
      <select class="form-control" name="count_as_halfday_due_to_ut" required>
       <option selected disabled value="">Select</option>
        <?php
          $x = 2; 
          while($x <= 8){
              echo '<option value="'.$x.'" >'.$x.'</option>';
              $x=$x+0.1;
          } 
        ?>
      </select>
    </div>
  </div>  

  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Allow per hour leave filing?</label>
    <div class="col-sm-9">
      <select class="form-control" name="allow_per_hour_filing" required>
       <option selected disabled value="">Select</option>
       <option value="1">yes</option>
       <option value="0">no</option>
      </select>
    </div>
  </div>  

  <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
</form>
</div>