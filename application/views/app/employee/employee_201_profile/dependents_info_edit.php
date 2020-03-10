<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>DEPENDENTS</strong> (edit)</div>
  <div class="box-body">

  <form method="post" action="<?php echo base_url()?>app/employee_201_profile/dependents_info_modify/<?php echo $this->uri->segment("4");?>" >


    	 <div class="box-body">

          <div class="row">
            <div class="col-md-6">

            <div class="form-group" >
            <label for="relation">Relation</label>
              <select id="relation" name="relation" class="form-control"  onchange="genderr();" required>
                  <option selected="selected" value="<?php echo $dependent_info_view->relationship;
                  ?>"><?php echo $dependent_info_view->relationship_name;?></option>
                  <?php 
                    foreach($relation_dependents as $relation){
                    if($_POST['relation'] == $relation->param_id){
                        $selected = "selected='selected'";
                    }else{
                        $selected = "";
                    }
                      $check =  $this->employee_201_model->check_rel_exist($this->session->userdata('employee_id'),$relation->param_id);
                        if($check=='true'){ $d= ''; }  elseif($relation->param_id==$_POST['relation'] AND $check!='true') { $d='';  } else{ $d='disabled'; }
                        if($dependent_info_view->relationship==$relation->param_id){} else{
                    ?>
                    <option value="<?php echo $relation->param_id;?>" <?php echo $selected; ?> <?php echo $d?>><?php echo $relation->cValue;?></option>
                    <?php } }?>
                </select>
                <p style="color:#ff0000;">Relation is required</p>
            </div>

            <div class="form-group">
              <label for="first_name">First name</label>
              <input type="text" name="first_name" class="form-control" placeholder="First name" value="<?php echo $dependent_info_view->first_name; ?>" required>
              <p style="color:#ff0000;">First name is required</p>
            </div>

            <div class="form-group" >
              <label for="middle_name">Middle name</label>
              <input type="text" name="middle_name" class="form-control" placeholder="Middle name" value="<?php echo $dependent_info_view->middle_name; ?>" >
            </div>

            <div class="form-group">
              <label for="last_name">Last name</label>
            <input type="text" name="last_name" class="form-control" placeholder="Last name" value="<?php echo $dependent_info_view->last_name; ?>" required>
            <p style="color:#ff0000;">Last name is required</p>
            </div>

            <div class="form-group">
              <label for="name_ext">Name extension</label>
            <input type="text" name="name_ext" class="form-control" placeholder="Name extension" value="<?php echo $dependent_info_view->name_ext; ?>">
            </div>


            </div>
            
            <div class="col-md-6">
            <div class="form-group">
              <label for="birthday">Birthday</label>
              <input type="text" id="birthday" name="birthday" class="form-control" placeholder="birthday" value="<?php  echo $dependent_info_view->birthday; ?>" required>
              <p style="color:#ff0000;">Birthday is required</p>
            </div>

            <div class="form-group" >
              <label for="gender">Gender</label>
              <select name="gender" class="form-control" id="gender" required>
                  <option selected="selected" value="<?php echo $dependent_info_view->gender; ?>"><?php echo $dependent_info_view->gender_name; ?></option>
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
            </div>

            <div class="form-group">
              <label for="civil_status">Civil status</label>
            <select name="civil_status" class="form-control" required>
                <option selected="selected" value="<?php echo $dependent_info_view->civil_status; ?>"><?php echo $dependent_info_view->civil_status_name; ?></option>
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
            </div>

            
            </div>
            </div>
            </div><!-- /.box-body -->   
    
     <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> Save Changes</button>
     </div>
     </form>
     </div> 
     </div>

</div>
</div>

</div>  
</div>


