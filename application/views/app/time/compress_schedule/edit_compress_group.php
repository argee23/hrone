<div class="well">

<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/time_compress_schedule/update_time_compress_group" >
<input type="hidden" name="c_group_id" value="<?php echo $cGinfo->c_group_id;?>">
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Group Name</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="compress_group_name" id="compress_group_name" placeholder="Compress Group Name" required value="<?php echo $cGinfo->compress_group_name;?>">
    </div>
    <input type="hidden" name="company_id" value="<?php echo $cGinfo->company_id;?>">
  </div>  
  <div class="form-group">
    <label for="group_name" class="col-sm-3 control-label">Mon (No.of Hrs)</label>
    <div class="col-sm-9">
      <select class="form-control" name="c_mon" required>
      <?php
      if($cGinfo->c_mon=="rest day"){
        echo '<option value="rest day" selected>Rest day</option>';
      }else{
       echo '<option value="'.$cGinfo->c_mon.'" selected>'.$cGinfo->c_mon.'</option>';
       echo '<option value="" disabled></option>';
      }
      ?>
       
        <?php
          $x = 4; 
          while($x <= 16) {

              echo '<option value="'.$x.'" >'.$x.'</option>';
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
      <?php
      if($cGinfo->c_tue=="rest day"){
        echo '<option value="rest day" selected>Rest day</option>';
      }else{
       echo '<option value="'.$cGinfo->c_tue.'" selected>'.$cGinfo->c_tue.'</option>';
       echo '<option value="" disabled></option>';        
      }
      ?>
        <?php
          $x = 4; 
          while($x <= 16) {         
              echo '<option value="'.$x.'" >'.$x.'</option>';
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
      <?php
      if($cGinfo->c_wed=="rest day"){
        echo '<option value="rest day" selected>Rest day</option>';
      }else{
       echo '<option value="'.$cGinfo->c_wed.'" selected>'.$cGinfo->c_wed.'</option>';
       echo '<option value="" disabled></option>';       
      }
      ?>
        <?php
          $x = 4; 
          while($x <= 16) {           
              echo '<option value="'.$x.'" >'.$x.'</option>';
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
      <?php
      if($cGinfo->c_thu=="rest day"){
        echo '<option value="rest day" selected>Rest day</option>';
      }else{
       echo '<option value="'.$cGinfo->c_thu.'" selected>'.$cGinfo->c_thu.'</option>';
       echo '<option value="" disabled></option>';        
      }
      ?>
        <?php
          $x = 4; 
          while($x <= 16) {

              echo '<option value="'.$x.'" >'.$x.'</option>';
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
      <?php
      if($cGinfo->c_fri=="rest day"){
        echo '<option value="rest day" selected>Rest day</option>';
      }else{
       echo '<option value="'.$cGinfo->c_fri.'" selected>'.$cGinfo->c_fri.'</option>';
       echo '<option value="" disabled></option>';        
      }
      ?>
        <?php
          $x = 4; 
          while($x <= 16) {

              echo '<option value="'.$x.'" >'.$x.'</option>';
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
      <?php
      if($cGinfo->c_sat=="rest day"){
        echo '<option value="rest day" selected>Rest day</option>';
      }else{
       echo '<option value="'.$cGinfo->c_sat.'" selected>'.$cGinfo->c_sat.'</option>';
       echo '<option value="" disabled></option>';        
      }
      ?>
        <?php
          $x = 4; 
          while($x <= 16) {          
              echo '<option value="'.$x.'" >'.$x.'</option>';
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
      <?php
      if($cGinfo->c_sun=="rest day"){
        echo '<option value="rest day" selected>Rest day</option>';
      }else{
       echo '<option value="'.$cGinfo->c_sun.'" selected>'.$cGinfo->c_sun.'</option>';
       echo '<option value="" disabled></option>';        
      }
      ?>
        <?php
          $x = 4; 
          while($x <= 16) {

              echo '<option value="'.$x.'" >'.$x.'</option>';
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
        <?php
          $x = 2; 
          while($x <= 10){
             if($cGinfo->halfday_required_hrs==$x){
              $sel="selected";
             }else{
              $sel="";
             }

              echo '<option value="'.$x.'" '.$sel.'>'.$x.'</option>';
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
        <?php
          $x = 2; 
          while($x <= 8){
             if($cGinfo->count_as_halfday_due_to_late==$x){
              $sel="selected";
             }else{
              $sel="";
             }

              echo '<option value="'.$x.'" '.$sel.'>'.$x.'</option>';
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
        <?php
          $x = 2; 
          while($x <= 8){
             if($cGinfo->count_as_halfday_due_to_ut==$x){
              $sel="selected";
             }else{
              $sel="";
             }
              echo '<option value="'.$x.'" '.$sel.'>'.$x.'</option>';
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
       <option value="1" <?php if($cGinfo->allow_per_hour_filing == '1'){ echo "selected"; }?> >yes</option>
       <option value="0" <?php if($cGinfo->allow_per_hour_filing=='0' || empty($cGinfo->allow_per_hour_filing)){ echo "selected"; }?>>no</option>
      </select>
    </div>
  </div>  



  <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>
</form>
</div>