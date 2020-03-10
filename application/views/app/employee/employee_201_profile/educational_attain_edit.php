<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>EDUCATIONAL ATTAINMENT</strong> (edit)</div>
  <div class="box-body">
   <form method="post" action="<?php echo base_url()?>app/employee_201_profile/educational_attain_modify/<?php echo $this->uri->segment("4");?>" >


    	 <div class="box-body">

          <div class="row">
            <div class="col-md-12">

            <div class="form-group">
              <label for="education_type">Education type</label>
              <select name="education_type" class="form-control" onchange="allowCourse(this.value);" required>
                <option selected="selected" value="<?php echo $education_attain_view->education_type_id; ?>"><?php echo $education_attain_view->education_name;?></option>
                  <?php 
                  foreach($educationList as $educationlist){
                    $check = false;
                    foreach($education_allowed as $allowed){
                      if($educationlist->education_id == $allowed->education_id){
                        if($_POST['education'] == $educationlist->education_id){
                            $selected = "selected='selected'";
                        }else{
                            $selected = "";
                        }?>
                        <option value="<?php echo $educationlist->education_id;?>" <?php echo $selected;?> disabled><?php echo $educationlist->education_name;?></option>
                      <?php 
                      $check = true;
                      }
                    }
                    if($check == false){
                        if($_POST['education'] == $educationlist->education_id){
                            $selected = "selected='selected'";
                        }else{
                            $selected = "";
                        }?>
                        <option value="<?php echo $educationlist->education_id;?>" <?php echo $selected;?> ><?php echo $educationlist->education_name;?></option>
                    <?php }           
                   }?>
                </select>  
               <p style="color:#ff0000;">Education type is required</p>               
            </div>

            <div class="form-group">
              <label for="school_name">School Name</label>
              <input type="text" name="school_name" class="form-control" placeholder="School Name" value="<?php echo $education_attain_view->school_name; ?>" required>
               <p style="color:#ff0000;">School name is required</p>       
            </div>

            <div class="form-group" >
              <label for="school_address">School Address</label>
              <input type="text" name="school_address" class="form-control" placeholder="School Address" value="<?php echo $education_attain_view->school_address; ?>" required>
               <p style="color:#ff0000;">School address is required</p>       
            </div>

            
            <div class="form-group">
            <div>
              <label for="course">Course</label>
              <?php if ($education_attain_view->education_type_id==4||$education_attain_view->education_type_id==7||$education_attain_view->education_type_id==8){ ?>
                  <input type="text" name="course" class="form-control" placeholder="Course" value="<?php echo $education_attain_view->course; ?>" required>
              <?php } ?>
              <?php if ($education_attain_view->education_type_id==1||$education_attain_view->education_type_id==2||$education_attain_view->education_type_id==3){ ?>
              <input type="text" name="course" class="form-control" placeholder="Course" value="<?php echo $education_attain_view->course; ?>" disabled>
              <?php } ?>
            </div>
            </div>

            <div class="form-group">
              <label for="Honors">Honors</label>
            <input type="text" name="honors" class="form-control" placeholder="Honors" value="<?php echo $education_attain_view->honors; ?>">
            </div>


            </div>
            
            <div class="col-md-6">
            <div class="form-group">
              <label for="date_start">Date started</label>
              <input type="text" id="date_start" name="date_start" class="form-control" placeholder="date start" value="<?php echo $education_attain_view->date_start; ?>" required>
               <p style="color:#ff0000;">Date started is required</p>       
            </div>
            </div>

            <div id="date_end_view">
            <div class="col-md-6">
            <div class="form-group">
              <label for="date_end">Date graduated</label>
              <input type="text" id="date_end" name="date_end" class="form-control" placeholder="date end" value="<?php if($education_attain_view->isGraduated==1){} else { echo $education_attain_view->date_end; }?>" required>
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
              <input type="hidden" value="<?php if($education_attain_view->isGraduated==1){ echo "no"; } else{ echo "yes"; } ?>" name="isGraduated" id="isGraduated">
              <input type="checkbox" name="isGraduated_" id="isGraduated_" value="yes" onchange="date_graduated(this.value);" <?php if($education_attain_view->isGraduated==1){ echo "checked"; }?>>
              <label> Unfinished</label>
            </div>
            </div>
            </div>


            </div>

            </div><!-- /.box-body -->   
    
<div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
     </div>
    </form>    
</div>
</div>

</div>  
</div>


