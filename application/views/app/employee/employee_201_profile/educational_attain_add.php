<div class="row">
<div class="col-md-8">

<div class="box box-warning">
<div class="panel panel-warning">
  <div class="panel-heading"><strong>EDUCATIONAL ATTAINMENT</strong> (add)</div>
  <div class="box-body">

  <form method="post" action="<?php echo base_url()?>app/employee_201_profile/educational_attain_save/<?php echo $this->uri->segment("4");?>" >
          <div class="row">
            <div class="col-md-12">
            
            <div class="form-group">
              <label for="education_type">Education type</label>
              <select name="education_type" class="form-control" onchange="allowCourse(this.value);" required>
                <option selected="selected" disabled="disabled" value="">~Select Education type~</option>
                  <?php 
                  foreach($educationList as $education){
                    $check = false;
                    foreach($education_allowed as $allowed){
                      if($education->education_id == $allowed->education_id){
                        if($_POST['education'] == $education->education_id){
                            $selected = "selected='selected'";
                        }else{
                            $selected = "";
                        }?>
                        <option value="<?php echo $education->education_id;?>" <?php echo $selected;?> disabled><?php echo $education->education_name;?></option>
                      <?php 
                      $check = true;
                      }
                    }
                    if($check == false){
                        if($_POST['education'] == $education->education_id){
                            $selected = "selected='selected'";
                        }else{
                            $selected = "";
                        }?>
                        <option value="<?php echo $education->education_id;?>" <?php echo $selected;?> ><?php echo $education->education_name;?></option>
                    <?php }           
                   }?>
              </select>
               <p style="color:#ff0000;">Education type is required</p>          
            </div>

            <div class="form-group">
              <label for="school_name">School name</label>
              <input type="text" name="school_name" class="form-control" placeholder="School name" required>
               <p style="color:#ff0000;">School name is required</p>       
            </div>

            <div class="form-group" >
              <label for="school_address">School address</label>
              <input type="text" name="school_address" class="form-control" placeholder="School address" required>
               <p style="color:#ff0000;">School address is required</p>       
            </div>

            <div class="form-group">
            <div>
              <label for="course">Course</label>
              <input type="text" name="course" id="course" class="form-control" placeholder="Course">
            </div>
            </div>

            <div class="form-group">
              <label for="Honors">Honors</label>
            <input type="text" name="honors" class="form-control" placeholder="Honors">
            </div>


            </div>
            
            <div class="col-md-6">
            <div class="form-group">
              <label for="date_start">Date started</label>
              <input type="text" id="date_start" name="date_start" class="form-control" value="<?php  echo date('Y-m-d'); ?>" placeholder="date start" required>
               <p style="color:#ff0000;">Date started is required</p>       
            </div>
            </div>

            <div id="date_end_view">
            <div class="col-md-6">
            <div class="form-group" >
              <label for="date_end">Date graduated</label>
              <input type="text" id="date_end" name="date_end" class="form-control" placeholder="date end" value="<?php  echo date('Y-m-d'); ?>"  required>
               <p style="color:#ff0000;">Date graduated is required</p>       
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
              <input type="hidden" value="yes" id="isGraduated" name="isGraduated">
              <input type="checkbox" id="isGraduated_" name="isGraduated_" value="yes" onchange="date_graduated(this.value);">
              <label> Unfinished</label>
            </div>
            </div> 
            </div>

            </div>


     <div class="form-group">
     <button type="submit" class="form-control btn btn-warning"><i class="fa fa-floppy-o"></i> SAVE </button>
     </div>
    </form>       
   </div><!-- /.box-body -->   

</div> 
</div>

</div>
</div>


