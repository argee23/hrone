<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"></span><strong>PERSONAL INFORMATION</strong> (edit)</div>
    <form method="post" action="<?php echo base_url()?>app/employee_201_profile/personal_info_modify/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
	      <div class="row">
	        <div class="col-md-6">

	        <div class="form-group">
            <label>Title</label>
            <select class="form-control" name="title" id="title">
            <option selected="selected" value="<?php echo $personal_info_view->title; ?>"><?php echo $personal_info_view->title_name; ?></option>
            <?php 
              foreach($UserTitles as $title){
              if($_POST['title'] == $title->param_id){
                  $selected = "selected='selected'";
              }else{
                  $selected = "";
              }
              ?>
              <option value="<?php echo $title->param_id;?>" <?php echo $selected;?>><?php echo $title->cValue;?></option>
              <?php }?>
              </select>
          </div>

            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="first_name" class="form-control" placeholder="First name" value="<?php echo $personal_info_view->first_name; ?>" required>
              <p style="color:#ff0000;">First name is required</p>
            </div>

            <div class="form-group" >
              <label>Middle Name</label>
              <input type="text" name="middle_name" class="form-control" placeholder="Middle name" value="<?php echo $personal_info_view->middle_name; ?>" >
            </div>

            <div class="form-group">
              <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" placeholder="Last name" value="<?php echo $personal_info_view->last_name; ?>" required>
            <p style="color:#ff0000;">Last name is required</p>
            </div>

            <div class="form-group">
              <label>Name extension</label>
            <input type="text" name="name_extension" class="form-control" placeholder="Name extension" value="<?php echo $personal_info_view->name_extension; ?>">
            </div>

            <div class="form-group">
              <label>Birthday</label>
              <input type="text" id="birthday" name="birthday" class="form-control" value="<?php echo $personal_info_view->birthday; ?>" required>
              <p style="color:#ff0000;">Birthday is required</p>
            </div><!-- /.form group -->

          <div class="form-group">
              <label >Place of Birth</label>
              <input type="text" name="birth_place" class="form-control" placeholder="Place of birth" value="<?php echo $personal_info_view->birth_place; ?>">
            </div>

            </div>
            
            <div class="col-md-6">
              <div class="form-group">
              <label>Nickname</label>
                <input type="text" name="nickname" class="form-control" placeholder="Nickname" value="<?php echo $personal_info_view->nickname; ?>" required>
            </div>

              <div class="form-group">
                <label>Civil Status</label>
                <select name="civil_status" id="civil_status" class="form-control" required>
                <option selected="selected" value="<?php echo $personal_info_view->civil_status; ?>"><?php echo $personal_info_view->civil_status_name; ?></option>
                <?php 
                  foreach($civilStatusList as $civil_status){
                  if($_POST['civil_status'] == $civil_status->civil_status_id){
                      $selected = "selected='selected'";
                  }else{
                      $selected = "";
                  }
                  ?>
                  <option value="<?php echo $civil_status->civil_status_id;?>" <?php echo $selected;?>><?php echo $civil_status->civil_status;?></option>
                  <?php }?>
              </select>
              <p style="color:#ff0000;">Civil status is required</p>                             
            </div><!-- /.form-group -->

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" id="title" class="form-control" required>
                  <option selected="selected" value="<?php echo $personal_info_view->gender; ?>"><?php echo $personal_info_view->gender_name; ?></option>
                  <?php 
                    foreach($genderList as $gender){
                    if($_POST['gender'] == $gender->gender_id){
                        $selected = "selected='selected'";
                    }else{
                        $selected = "";
                    }
                    ?>
                    <option value="<?php echo $gender->gender_id;?>" <?php echo $selected;?>><?php echo $gender->gender_name;?></option>
                    <?php }?>
                </select>
                <p style="color:#ff0000;">Gender is required</p>
              </div><!-- /.form-group -->
               
            <div class="form-group">
                <label>Blood Type</label>
                <select name="blood_type" class="form-control">
                  <option selected="selected" value="<?php echo $personal_info_view->blood_type; ?>"><?php echo $personal_info_view->blood_type_name; ?></option>
                  <?php 
                    foreach($bloodType as $bloodType){
                    if($_POST['gender'] == $bloodType->param_id){
                        $selected = "selected='selected'";
                    }else{
                        $selected = "";
                    }
                    ?>
                    <option value="<?php echo $bloodType->param_id;?>" <?php echo $selected;?>><?php echo $bloodType->cValue;?></option>
                    <?php }?>
                </select>
              </div><!-- /.form group -->

              <div class="form-group">
                <label>Citizenship</label>
                <select name="citizenship" class="form-control">
                  <option selected="selected" value="<?php echo $personal_info_view->citizenship; ?>"><?php echo $personal_info_view->citizenship_name; ?></option>
                  <?php 
                    foreach($citizenshipList as $citizenship){
                    if($_POST['citizenship'] == $citizenship->param_id){
                        $selected = "selected='selected'";
                    }else{
                        $selected = "";
                    }
                    ?>
                    <option value="<?php echo $citizenship->param_id;?>" <?php echo $selected;?>><?php echo $citizenship->cValue;?></option>
                    <?php }?>
                </select>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label>Religion</label>
                <select name="religion" class="form-control">
                  <option selected="selected" value="<?php echo $personal_info_view->religion; ?>"><?php echo $personal_info_view->religion_name; ?></option>
                  <?php 
                    foreach($religionList as $religion){
                    if($_POST['religion'] == $religion->param_id){
                        $selected = "selected='selected'";
                    }else{
                        $selected = "";
                    }
                    ?>
                    <option value="<?php echo $religion->param_id;?>" <?php echo $selected;?>><?php echo $religion->cValue;?></option>
                    <?php }?>
                </select>
              </div><!-- /.form-group -->
            </div>
            </div>

     <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
     </div>
    </div><!-- /.box-body -->
    </form>
</div>
</div>

</div>  
</div>


