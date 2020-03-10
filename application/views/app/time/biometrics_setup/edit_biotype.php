<!-- //=========== add brand -->
  <div class="col-md-12">
    <div class="panel panel-danger">
      <div class="panel-heading">   
        <strong>
          Edit Biometrics Brand
        </strong>
      </div>
        <div class="panel-body">
          <form name="" method="post" action="<?php echo base_url()?>app/time_biometrics_setup/save_edit_biotype/<?php echo $this->uri->segment("4")?>" >
          	<input type="hidden" name="id" value="<?php echo $this->uri->segment("4");?>">

              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Brand Name<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-12" >
                   <select name="brand_name" class="form-control" required>
                   <option value="<?php echo $s_bio_brand_id;?>" selected=selected><?php echo $s_brand_name;?></option>
                   <?php
                   if(!empty($active_brand)){
                      $no_brand_yet=0;
                      echo '<option disabled >&nbsp;<option>';
                        foreach($active_brand as $brand){
                         $brandstatus=$brand->InActive;
                          echo '<option value="'.$brand->bio_categ_id.'">'.$brand->brand_name.'</option>';                       
                        }
                   }else{
                      $no_brand_yet=1;
                      echo '<option option disabled selected=selected>notice: create/add a brand name first.</option>';
                   }

                   ?>                    
                   </select>
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Biometrics Type<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-12" >
                   <input type="text" name="bio_type" class="form-control" <?php 
                   if($no_brand_yet=="1"){
                    echo 'disabled placeholder="notice: create/add a brand name first."' ;
                   }else{

                   }
                   ?> required value="<?php echo $s_bio_name;?>">
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Database Type<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-12" >
                   <select name="bio_db_type" class="form-control" required>
                   <option value="<?php echo $bio_db_type;?>" selected=selected><?php echo $s_db_type_name;?></option>
                   <?php
                   if(!empty($db_typeList)){
                      $no_dbtype_yet=0;
                      echo '<option disabled >&nbsp;<option>';
                        foreach($db_typeList as $db_type){
                         $db_typestatus=$db_type->InActive;
                          echo '<option value="'.$db_type->param_id.'">'.$db_type->cValue.'</option>';                       
                        }
                   }else{
                      $no_dbtype_yet=1;
                      echo '<option option disabled selected=selected>notice: create/add a database type first.</option>';
                   }

                   ?>                    
                   </select>
                  </div>
              </div>              
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Database Username<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-12" >
                   <input type="text" name="bio_db_username" class="form-control" <?php 
                   if($no_brand_yet=="1"){
                    echo 'disabled placeholder="notice: create/add a brand name first."' ;
                   }else{

                   }
                   ?>  value="<?php echo $bio_db_username;?>">
                  </div>
              </div>           
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Database Password<?php echo $system_defined_icons->required_marked;?></label>
                  <div class="col-sm-12" >
                   <input type="text" name="bio_db_password" class="form-control" <?php 
                   if($no_brand_yet=="1"){
                    echo 'disabled placeholder="notice: create/add a brand name first."' ;
                   }else{

                   }
                   ?>  value="<?php echo $bio_db_password;?>">
                  </div>
              </div>
              <div class="form-group"   >
                <label for="next" class="col-sm-12 control-label">Biometrics Details</label>
                  <div class="col-sm-12" >
                  <?php
                  if($bio_details==""){
$show_me_bd="Users Capacity : 
Finger Print capacity:";
                  }else{
                    $show_me_bd=$bio_details;
                  }       
                  ?>
                   <textarea name="bio_details" class="form-control"><?php echo $show_me_bd;?>
                   </textarea>
                  </div>
              </div>



              <div class="form-group"   >
                <label for="next" class="col-sm-5 control-label">&nbsp;&nbsp;&nbsp;</label>
                  <div class="col-sm-7" >
                  
                    <button type="submit" class="btn <?php echo $system_defined_icons->button_save_color." ".$system_defined_icons->button_size;?> pull-right">
                    <?php
                      echo '<i  class="fa fa-'.$system_defined_icons->icon_save.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_save_color.';" " ></i> Save';
                    ?>

                    </button>
                  </div>
              </div>
            </form>

        </div>
    </div>
  </div>