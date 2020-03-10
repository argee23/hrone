<div class="col-md-6">
  <div class="tab-content">

  <div class="tab-pane active" id="p_info">
  <div class="panel panel-success"> 
    <div class="panel-heading">

      <span class="pull-right"> 
         <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else {?><a data-toggle="modal" data-target="#personal_info_form"><i class="fa fa-edit fa-2x"></i> </a> <?php } } else{?>
         <a href="#editable_topics">View editable topic</a>
         <?php } ?>
      </span>
      <h4 class="text-danger"><i class="glyphicon glyphicon-user"></i><?php if($setting=='allowed') {  ?></i>Personal Information <?php } else{?> You're not allowed to edit <b>Personal Information</b> <?php } ?></h4>
    </div>
    <div class="panel-body">
              <div class="col-lg-12">
             <strong><i class="fa fa-user margin-r-5"></i> Basic Details</strong>
               <dl class="dl-horizontal">
                <dt>Firstname</dt>
                <dd><?php echo $info->first_name; ?></dd>
                <?php 
                    if (empty($info_update->first_name)) { } 
                    elseif($info_update->first_name==$info->first_name) { } 
                    else{  echo  '<dd class="text-primary">' . $info_update->first_name  . '</dd>'; }  ?>
                <dt>Middle Name</dt>
                <dd><?php echo $info->middle_name; ?></dd>
                <?php 
                    if (empty($info_update->middle_name)) { }
                    elseif($info_update->middle_name==$info->middle_name) { } 
                    else{ echo  '<dd class="text-primary">' . $info_update->middle_name  . '</dd>'; }?>
                <dt>Last Name</dt>
                <dd><?php echo $info->last_name; ?></dd>
                <?php 
                    if (empty($info_update->last_name)) { } 
                    elseif($info_update->last_name==$info->last_name) { }
                    else{ echo  '<dd class="text-primary">' . $info_update->last_name  . '</dd>'; }?>
                <dt>NickName</dt>
                <dd><?php echo $info->nickname; ?></dd>
                <?php 
                    if (empty($info_update->nickname)) { }
                    elseif($info_update->nickname==$info->nickname) { }
                    else{ echo  '<dd class="text-primary">' . $info_update->nickname  . '</dd>'; }?>
                
                <dt>Birthday</dt>
                <dd><?php echo date("F d, Y", strtotime($info->birthday)); ?></dd>
                <?php 
                    if (empty($info_update->birthday)) {} 
                    elseif($info_update->birthday==$info->birthday) { }
                    else { echo  '<dd class="text-primary">' . date("F d, Y", strtotime($info_update->birthday)) . '</dd>'; } ?>
                <dt>Birth Place</dt>
                <dd><?php echo $info->birth_place; ?></dd>
                <?php 
                    if (empty($info_update->birth_place)) { }
                    elseif($info_update->birth_place==$info->birth_place) { }
                    else { echo  '<dd class="text-primary">' . $info_update->birth_place . '</dd>'; } ?>
                <dt>Age</dt>
                <dd><?php echo $this->employee_201_model->calculate_interval($info->birthday); ?></dd>
                <?php 
                    if (empty($info_update->birthday)) {}
                    elseif($info_update->birthday==$info->birthday) { }
                    else { echo  '<dd class="text-primary">';?> <?php echo $this->employee_201_model->calculate_interval($info_update->birthday);?> </dd><?php }?>
                
              </dl>
               <hr>
              <strong><i class="fa fa-plus-square margin-r-5"></i> More Information</strong>
               <dl class="dl-horizontal">    
                <dt>Gender</dt>
                <dd><?php echo $info->gender_name; ?></dd>
                <?php 
                    if (empty($info_update->gender)) {} 
                    elseif($info_update->gender==$info->gender) { }
                    else { echo  '<dd class="text-primary">' . $info_update->gender_name . '</dd>'; } ?>
                
                <dt>Civil Status</dt>
                <dd><?php  echo $info->civil_status; ?></dd>
                  <?php $stat = $this->employee_201_model->civil_stat($this->session->userdata('employee_id'));
                  foreach ($stat as $r) {
                   if(!empty($r->name) AND $r->name!=$info->civil_status){ echo  '<dd class="text-primary">' . $info_update->civil_status . '</dd>'; }                 }
                 ?>

                <dt>Blood Type</dt>
                <dd><?php echo $info->my_bloodtype; ?></dd>
                <?php 
                    if (empty($info_update->blood_type)) { } 
                    elseif($info_update->blood_type==$info->blood_type) { }
                    else { echo  '<dd class="text-primary">' . $info_update->my_bloodtype . '</dd>'; } ?>
                <dt>Religion</dt>
                <dd><?php echo $info->my_religion; ?></dd>
                <?php 
                    if (empty($info_update->religion)) { } 
                    elseif($info_update->religion==$info->religion) { }
                    else { echo  '<dd class="text-primary">' . $info_update->my_religion. '</dd>'; } ?>
                <dt>Citizenship</dt>
                <dd><?php echo $info->my_citizenship; ?></dd>
                <?php 
                    if (empty($info_update->citizenship)) { }
                    elseif($info_update->citizenship==$info->citizenship) { }
                    else { echo  '<dd class="text-primary">' . $info_update->my_citizenship. '</dd>'; }?>
               </dl>
              <hr>
             <form name="change_image" method="post" action="update_image" enctype="multipart/form-data">
              <div class="form-group">
                <label>Choose your new image: </label>
                    <input type="file" name="photo" id="photo">
                     <span><small>Maximum Allowed Size: 2MB</small></span><br>
                    <button type="submit" class="btn btn-success btn-sm" <?php if($setting=='allowed') { if($pending > 0) { echo "disabled"; } else{} }  else { ?> disabled <?php }?>>Upload</button>
                 
              </div>
              </form>
              <div id='ref_img'>
               <?php  if ($info_update) { if (($info->picture != $info_update->picture) && ($info_update->picture)) { ?>
                 <img class="img img-thumbnail bg-gray" style="width: 250px;" src="<?php echo $this->employee_201_model->get_general_url(); ?>employee_picture/<?php echo $info_update->picture; ?>"><br>
                 <small><span class="text-primary">Waiting for approval</span></small> | <a onclick="del_per_image('<?php echo $info_update->id;?>')">Remove image </a>
                <?php } }?>
              </div>

              </div>
    </div>
  </div>
  </div>
<!-- END PERSONAL INFORMATION -->

  <div class="tab-pane" id="address">
  <div class="panel panel-success"> 
    <div class="panel-heading">
      <span class="pull-right">
         <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else {?> <a data-toggle="modal" data-target="#address_info_form"><i class="fa fa-edit fa-2x"></i> </a> <?php } } ?>
      </span>
      <h4 class="text-danger"><i class="glyphicon glyphicon-map-marker"></i>Address Information</h4>
    </div>

    <div class="panel-body">
                  <strong><i class="fa fa-building margin-r-5"></i> Present Adddress</strong>
               <dl class="dl-horizontal">
                <dt>Address</dt>
                <dd><?php echo $info->present_address; ?> </dd>
                <?php 
                    if (empty($info_update->present_address)) { } 
                    elseif($info_update->present_address==$info->present_address) { }
                    else { echo  '<dd class="text-primary">' . $info_update->present_address . '</dd>'; }?>
                <dt>City</dt>
                <dd><?php echo $info->present_city_name; ?></dd>
                <?php 
                    if (empty($info_update->present_city)) {} 
                    elseif($info_update->present_city==$info->present_city) { }
                    else { echo  '<dd class="text-primary">' . $info_update->present_city_name . '</dd>'; } ?>
                <dt>Province</dt>
                <dd><?php echo $info->present_province_name; ?></dd>
                <?php  
                    if (empty($info_update->present_province)) { } 
                    elseif($info_update->present_province==$info->present_province) { }
                    else { echo  '<dd class="text-primary">' . $info_update->present_province_name . '</dd>'; } ?>
                <dt>Years of Stay</dt>
                <dd><?php echo $info->present_address_years_of_stay; ?></dd>
                <?php 
                    if (empty($info_update->present_address_years_of_stay)) { } 
                    elseif($info_update->present_address_years_of_stay==$info->present_address_years_of_stay) { }
                    else { echo  '<dd class="text-primary">' . $info_update->present_address_years_of_stay . '</dd>'; }?>
              </dl>
              <hr>

              <strong><i class="fa fa-home margin-r-5"></i> Permanent Address</strong>
               <dl class="dl-horizontal">
                <dt>Address</dt>
                <dd><?php echo $info->permanent_address; ?></dd>
                <?php 
                    if (empty($info_update->permanent_address)) {} 
                    elseif($info_update->permanent_address==$info->permanent_address) { }
                    else { echo  '<dd class="text-primary">' . $info_update->permanent_address . '</dd>'; }  ?>
                <dt>City</dt>
                <dd><?php echo $info->permanent_city_name; ?></dd>
                <?php 
                    if (empty($info_update->permanent_city)) { } 
                    elseif($info_update->permanent_city==$info->permanent_city) { }
                    else { echo  '<dd class="text-primary">' . $info_update->permanent_city_name . '</dd>'; }?>
                <dt>Province</dt>
                <dd> <?php echo $info->permanent_province_name; ?></dd>
                <?php 
                    if (empty($info_update->permanent_province)) { } 
                    elseif($info_update->permanent_province==$info->permanent_province) { }
                    else { echo  '<dd class="text-primary">' . $info_update->permanent_province_name . '</dd>'; }?>
                <dt>Years of Stay</dt>
                <dd><?php echo $info->permanent_address_years_of_stay; ?></dd>
                <?php 
                    if (empty($info_update->permanent_address_years_of_stay)) { } 
                    elseif($info_update->permanent_address_years_of_stay==$info->permanent_address_years_of_stay) { }
                    else { echo  '<dd class="text-primary">' . $info_update->permanent_address_years_of_stay . '</dd>'; } ?>
              </dl>
    </div>
    </div>
    </div>
<!-- END ADDRESS INFO -->
  <div class="tab-pane" id="contact">
  <div class="panel panel-success"> 
    <div class="panel-heading">
      <span class="pull-right">
         <?php if($setting=='allowed') { if($pending > 0) {?> <br>Editing of information temporary disabled due to pending request. <?php } else {?> <a data-toggle="modal" data-target="#contact_info_form"><i class="fa fa-edit fa-2x"></i> </a><?php } } ?>
      </span>
      <h4 class="text-danger"><i class="glyphicon glyphicon-phone"></i>Contact Information</h4>
    </div>

    <div class="panel-body">
              <strong><i class="fa fa-phone margin-r-5"></i> Contact Accounts</strong>
               <dl class="dl-horizontal">
                <dt>Mobile No. 1</dt>
                <dd><?php echo $info->mobile_1; ?></dd>
                <?php 
                    if (empty($info_update->mobile_1)) { }
                    elseif($info_update->mobile_1==$info->mobile_1) { }
                    else { echo  '<dd class="text-primary">' . $info_update->mobile_1 . '</dd>'; } ?>
                <dt>Mobile No. 2</dt>
                <dd><?php echo $info->mobile_2; ?></dd>
                <?php 
                    if (empty($info_update->mobile_2)) { } 
                    elseif($info_update->mobile_2==$info->mobile_2) { }
                    else { echo  '<dd class="text-primary">' . $info_update->mobile_2 . '</dd>'; } ?>
                <dt>Mobile No. 3</dt>
                <dd><?php echo $info->mobile_3; ?></dd>
                <?php 
                    if (empty($info_update->mobile_3)) { } 
                    elseif($info_update->mobile_3==$info->mobile_3) { }
                    else { echo  '<dd class="text-primary">' . $info_update->mobile_3 . '</dd>'; } ?>
                <dt>Mobile No. 4</dt>
                <dd><?php echo $info->mobile_4; ?></dd>
                <?php 
                    if (empty($info_update->mobile_4)) { } 
                    elseif($info_update->mobile_4==$info->mobile_4) { }
                    else { echo  '<dd class="text-primary">' . $info_update->mobile_4 . '</dd>'; } ?>

                <dt>Telephone No. 1</dt>
                <dd><?php echo $info->tel_1; ?></dd>
                <?php 
                    if (empty($info_update->tel_1)) { } 
                    elseif($info_update->tel_1==$info->tel_1) { }
                    else { echo  '<dd class="text-primary">' . $info_update->tel_1 . '</dd>'; } ?>
                <dt>Telephone No. 2</dt>
                <dd><?php echo $info->tel_2; ?></dd>
                <?php 
                    if (empty($info_update->tel_2)) { } 
                    elseif($info_update->tel_2==$info->tel_2) { }
                    else { echo  '<dd class="text-primary">' . $info_update->tel_1 . '</dd>'; } ?>
              </dl>
              <hr>

              <strong><i class="fa fa-twitter margin-r-5"></i> Social Media Accounts</strong>
               <dl class="dl-horizontal">     
                <dt>Email Address</dt>
                <dd><i class="fa fa-envelope margin-r-5"></i><?php echo $info->email; ?></dd>
                <?php 
                    if (empty($info_update->email)) { } 
                    elseif($info_update->email==$info->email) { }
                    else { echo  '<dd class="text-primary">' . $info_update->email . '</dd>'; }?>
                <dt>Facebook</dt>
                <dd><i class="fa fa-facebook margin-r-5"></i><?php echo $info->facebook; ?></dd>
                <?php 
                    if (empty($info_update->facebook)) {} 
                    elseif($info_update->facebook==$info->facebook) { }
                    else { echo  '<dd class="text-primary">' . $info_update->facebook . '</dd>'; } ?>
                <dt>Twitter</dt>
                <dd><i class="fa fa-twitter margin-r-5"></i><?php echo $info->twitter; ?></dd>
                <?php 
                    if (empty($info_update->twitter)) { } 
                    elseif($info_update->twitter==$info->twitter) { }
                    else { echo  '<dd class="text-primary">' . $info_update->twitter . '</dd>'; } ?>
                <dt>Instagram</dt>
                <dd><i class="fa fa-instagram margin-r-5"></i><?php echo $info->instagram; ?></dd>
                <?php 
                    if (empty($info_update->instagram)) { } 
                    elseif($info_update->instagram==$info->instagram) { }
                    else { echo  '<dd class="text-primary">' . $info_update->instagram . '</dd>'; } ?>
               </dl>

    </div>
  </div>
  </div>
<!-- END Contact Information -->


  <div class="tab-pane" id="employment">
  <div class="panel panel-success"> 
    <div class="panel-heading">
      <h4 class="text-danger"><i class="fa fa-building margin-r-5"></i>Employment Information </h4>
    </div>

    <div class="panel-body">

              <strong><i class="fa fa-building margin-r-5"></i> Employment</strong>
               <dl class="dl-horizontal">    
               <?php if ($has_division) { ?>
                <dt>Division</dt>
                <dd></i><?php echo $info->employment_info->division_name; ?></dd>
                

               <?php  } ?> 

                <dt>Department</dt>
                <dd><?php echo $info->employment_info->dept_name; ?></dd>
                <dt>Section</dt>
                <dd><?php echo $info->employment_info->section_name; ?></dd>

              <?php if ($info->employment_info->subsection > 0 || $info->employment_info->subsection != null) { ?>
                <dt>Subsection</dt>
                <dd></i><?php echo $info->employment_info->subsection_name; ?></dd>
               <?php  } ?> 

                <dt>Position</dt>
                <dd><?php echo $info->employment_info->position_name; ?></dd>
                <dt>Employment</dt>
                <dd><?php echo $info->employment_info->employment_name; ?></dd>
                <dt>Classification</dt>
                <dd><?php echo $info->employment_info->classification_name; ?></dd>
                
                <dt>Location</dt>
                <dd><?php echo $info->employment_info->location_name; ?></dd>
                <dt>Tax Code</dt>
                <dd><?php echo $info->taxcode; ?></dd>
                
                <dt>Pay Type</dt>
                <dd><?php echo $info->pay_type_name; ?></dd>
                <dt>Date Employed</dt>
                <dd><?php echo date("F d, Y", strtotime($info->date_employed))?></dd>
            
                <dt>Report to</dt>
                <dd>
                  <?php 
                       echo $this->employee_201_model->get_report_info($info->report_to);
                   ?>
                </dd>
              

               </dl>
    </div>
  </div>
  </div>
<!--   End Employment Information -->


  <div class="tab-pane" id="residence">
  <div class="panel panel-success"> 
    <div class="panel-heading">
    <h4 class="text-danger"><i class="glyphicon glyphicon-map-marker"></i>Residence Information</h4>
    </div>

    <div class="panel-body">

            <strong><i class="fa fa-map margin-r-5"></i> Residence Map</strong>
            <div class='col-md-12'>
              <center> <h4>Update Residence Map</h4>
               <form name="change_image" method="post" action="update_residence" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Choose your new residence map: </label>
                    <div class="input-group">
                      <input type="file"  name="photo" id="photo">
                      <div class="input-group-btn">
                      
                      </div>
                    </div>
                    <span>Maximum Allowed Size: 500KB</span>
                      <?php if($setting=='allowed') { if($pending > 0) {?> <br><n class='text-danger'>Editing of information temporary disabled due to pending request. </n><?php } else {?><button type="submit" class="btn btn-success btn-sm" style="margin-left:20px;">Upload</button> <?php } } ?>
                  </div>
                </form>
            </div>
              <hr>
             <div class="col-sm-6">
              <?php if ($info_update) { if (($info->residence_map != $info_update->residence_map) && ($info_update->residence_map)) { ?>
                <a  type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left" title="Click to download" href="download/residence/<?php echo $info_update->residence_map;?>">
                 <img class="img img-thumbnail bg-gray" style="width: 250px;height:250px; " src="<?php echo base_url(); ?>public/employee_files/residence/<?php echo $info_update->residence_map; ?>"><br>
                 <small><span>Click the image to download(Waiting for approval)</span></small>
                </a> 
                <?php } }?>
                 <br>
             </div>

             <div <?php if(empty($info_update->residence_map)) {?> class="col-sm-12" <?php } else{?> class="col-sm-6"  <?php }?>>
                <a  type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="Click to download" href="download/residence/<?php echo $info->residence_map;?>">
                 <img style="width: 250px;height:250px; " class="img img-responsive"  src="<?php echo base_url(); ?>public/employee_files/residence/<?php echo $info->residence_map; ?>">
                <n style='color:white;'>Click the image to download( original image ).</n>
               </a>
              </div>

             </div>


    </div>
  </div>
  </div>
<!-- End Residence Information -->

  </div>
</div>

<div class="col-md-3">
    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
      <?php $inf =  $this->general_model->picture($this->session->userdata('employee_id')); 
      if(empty($inf)){ $pic='user.png'; } else{ $pic=$inf; }?>
        <img class="profile-user-img img-responsive img-circle" src="<?php echo $this->employee_201_model->get_general_url(); ?>employee_picture/<?php echo $pic?>" alt="User profile picture">
        <p class="text-muted text-center text-success"><?php echo $info->employee_id;?></p>
        <h4 class=" text-center"><?php echo $info->first_name; ?><?php echo ' ' . $info->middle_name; ?><?php echo ' ' . $info->last_name; ?></h4>
        <h5 class=" text-center">"<i><?php echo $info->nickname; ?></i>"</h5>

        <ul class="list-group list-group-unbordered">
        </ul>
        <div class="well well-sm">
          <button class="btn btn-default btn-block btn-flat my_hover" data-toggle="pill" data-target="#p_info">Personal Information</button>
       <!--    <button class="btn btn-default btn-block btn-flat my_hover" data-toggle="pill" data-target="#employment">Employment Information</button> -->
          <button class="btn btn-default btn-block btn-flat my_hover" data-toggle="pill" data-target="#address">Address Information</button>
          <button class="btn btn-default btn-block btn-flat my_hover" data-toggle="pill" data-target="#contact">Contact Information</button>
          <button class="btn btn-default btn-block btn-flat my_hover" data-toggle="pill" data-target="#residence">Residence Information</button>
          <button class="btn btn-default btn-block btn-flat my_hover" data-toggle="pill" data-target="#employment">Employment Information</button>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->

</div>




<!-- Modal -->
<div id="contact_info_form" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Contact Information</h4>
      </div>
      <div class="modal-body">
        <form name="contactinfo" method="post" action="update_contact">
        <div class="col-lg-12">
          <div class="col-lg-6">
        
          <label>Mobile No. (1): <i class="text-danger"> <?php if(empty($mobile_)) { echo "<br>No setting set up by admin.You're free to use any format."; } else{ echo "Format:".$mobile_; } ?></i></label>
            <small ng-show="contactinfo.mobile_1.$error.required"><i>Atleast 1 mobile number is required.</i></small>
          </label>
          
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
            <input id="mobile_1" type="text" class="form-control" name="mobile_1" value="<?php if(empty($info_update->mobile_1)){ echo $info->mobile_1; } else{ echo $info_update->mobile_1; } ?>"  <?php if(empty($mobile_)) {} else{ ?> pattern="<?php echo $mobile?>" <?php } ?>  required>
            
          </div>
        
         
          <label>Mobile No.(2): <i class="text-danger"> <?php if(empty($mobile_)) { echo "<br>No setting set up by admin.You're free to use any format."; } else{ echo "Format:".$mobile_; }  ?> </i></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
            <input id="mobile_2" type="text" class="form-control" name="mobile_2" value="<?php if(empty($info_update->mobile_2)){ echo $info->mobile_2; } else{ echo $info_update->mobile_2; } ?>" <?php if(empty($mobile_)) {} else{ ?> pattern="<?php echo $mobile?>" <?php } ?>>
          </div>
         
           <label>Mobile No.(3): <i class="text-danger"> <?php if(empty($mobile_)) { echo "<br>No setting set up by admin.You're free to use any format."; } else{ echo "Format:".$mobile_; }  ?> </i></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
            <input id="mobile_3" type="text" class="form-control" name="mobile_3" value="<?php if(empty($info_update->mobile_3)){ echo $info->mobile_3; } else{ echo $info_update->mobile_3; } ?>" <?php if(empty($mobile_)) {} else{ ?> pattern="<?php echo $mobile?>" <?php } ?>>
          </div>

            <label>Mobile No.(4): <i class="text-danger"> <?php if(empty($mobile_)) { echo "<br>No setting set up by admin.You're free to use any format."; } else{ echo "Format:".$mobile_; }  ?> </i></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
            <input id="mobile_4" type="text" class="form-control" name="mobile_4" value="<?php if(empty($info_update->mobile_4)){ echo $info->mobile_4; } else{ echo $info_update->mobile_4; } ?>" <?php if(empty($mobile_)) {} else{ ?> pattern="<?php echo $mobile?>" <?php } ?>>
          </div>

         <label>Telephone No. (1):  <i class="text-danger"><?php if(empty($tel_)) { echo "<br>No setting set up by admin.You're free to use any format."; } else{ echo"Format:".$tel_; } ?></i></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
           <input id="tel_1" type="text" class="form-control" name="tel_1" value="<?php if(empty($info_update->tel_1)){ echo $info->tel_1; } else{ echo $info_update->tel_1; } ?>" 
           <?php if(empty($tel_)) {} else{ ?> pattern="<?php echo $tel?>" <?php } ?> placeholder="<?php echo $tel?>">
          
          </div>
       
          
       <label>Telephone No. (2): <i class="text-danger"><?php if(empty($tel_)) { echo "<br>No setting set up by admin.You're free to input any format."; } else{ echo  "Format:".$tel_; }  ?></i></label>
          <div class="input-group"> 
            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
             <input id="tel_2" type="text" class="form-control" name="tel_2" value="<?php if(empty($info_update->tel_2)){ echo $info->tel_2; } else{ echo $info_update->tel_2; } ?>" 
             <?php if(empty($tel_)) {} else{ ?> pattern="<?php echo $tel?>" <?php } ?>>
            </div>
          <div class="form-group"><br>
          
         
          </div>
          </div>
          <div class="col-lg-6">
          <div class="form-group" ng-class="{'has-error' : contactinfo.email.$invalid}">
          <label>Email Address: <small ng-show="contactinfo.email.$invalid"><i>Please provide a valid email address.</i></small></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-at"></i></span>
            <input id="email" placeholder="sample@email.com" type="email" class="form-control" name="email" ng-init="email = '<?php if(empty($info_update->email)) { echo $info->email; } else{  echo $info_update->email; } ?>'" ng-model="email" required>
          </div>
          </div>
          <div class="form-group has-feedback" ng-class="{'has-error' : contactinfo.instagram.$invalid}">
          <label>Instagram Username: <small ng-show="contactinfo.instagram.$invalid"><i>Sample Format: @username</i></small></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
            <input id="instagram" type="text" placeholder="@username" class="form-control" name="instagram" ng-init="instagram = '<?php if(empty($info_update->instagram)) { echo $info->instagram; } else{ echo $info_update->instagram; } ?>'" ng-model="instagram">
          </div>
          </div>
          <div class="form-group">
          <label>Facebook URL:</label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
            <input id="facebook" type="text" placeholder="www.facebook.com/your_url" class="form-control" name="facebook" ng-init="facebook = '<?php if(empty($info_update->facebook)) { echo $info->facebook; } else{ echo $info_update->facebook; } ?>'" ng-model="facebook">
          </div>
          </div>
         <div class="form-group">
          <label>Twitter Username:</label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
            <input id="twitter" type="text" placeholder="@username" class="form-control" name="twitter" ng-init="twitter = '<?php if(empty($info_update->twitter)) {  echo $info->twitter; } else{ echo $info_update->twitter; }  ?>'" ng-model="twitter">
          </div>
          </div>

          </div>
          </div>

            <div class="col-md-6"><button type="submit" class="btn btn-block btn-success" ng-disabled="contactinfo.$invalid"><i class="fa fa-save"></i> Save Changes
          </button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>

<div id="personal_info_form" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><n class="text-danger"><i class="glyphicon glyphicon-user"></i> <b>Personal Information</b></n></h4>
      </div>
      <div class="modal-body">
      <form class="form-horizontal" name="pinfo_form" action="update_personal_info" method="post">
          <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">First Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="first_name" placeholder="First name" name="first_name" value="<?php if(empty($info_update->first_name)) { echo $info->first_name; } else{ echo $info_update->first_name; }  ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Middle Name</label> 
      <div class="col-sm-10">
        <input type="text" class="form-control" id="middle_name" placeholder="Middle Name" name="middle_name" value="<?php if(empty($info_update->middle_name)) { echo $info->middle_name; } else{ echo $info_update->middle_name; }  ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Last Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="<?php if(empty($info_update->last_name)) { echo $info->last_name; } else{ echo $info_update->last_name; }  ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Nick Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="nickname" placeholder="Nick name" name="nickname" value="<?php if(empty($info_update->nickname)) { echo $info->nickname; } else{ echo $info_update->nickname; }  ?>">
      </div>
    </div>
  
    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Birthday</label>
      <div class="col-sm-10">
          <input type="text" style="width: 100%" id="birthday" name="birthday" value="<?php if(empty($info_update->birthday)) { echo $info->birthday; } else{ echo $info_update->birthday; }  ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Birth Place</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="birth_place" placeholder="Birth place" name="birth_place" value="<?php if(empty($info_update->birth_place)) { echo $info->birth_place; } else{ echo $info_update->birth_place; }  ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Gender</label>
      <div class="col-sm-10">
        <select class="form-control" name="gender" id="gender">
          <?php foreach ($genderList as $gend)
          {?>
            <option value="<?php echo $gend->gender_id?>" <?php if(empty($info_update->gender)) { if($gend->gender_id==$info->gender) { echo "selected"; } } else{ if($gend->gender_id==$info_update->gender) { echo "selected"; }} ?>><?php echo $gend->gender_name?></option>
          <?php } ?>
          }?>
        </select>
      </div>  
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Civil Status</label>
      <div class="col-sm-10">
        <select class="form-control" name="civil_status" id="civil_status">
          <?php foreach ($civilStatusList as $status)
          { $stat = $this->employee_201_model->civil_stat($this->session->userdata('employee_id'));  ?>
            <option value="<?php echo $status->civil_status_id?>" <?php if(empty($stat)) { if($status->civil_status_id==$info->civil_id) { echo "selected"; } } else{ foreach ($stat as $r) { if($status->civil_status_id==$r->civil_status) { echo "selected"; } }} ?>><?php echo $status->civil_status?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Blood Type</label>
      <div class="col-sm-10">
        <select class="form-control" name="blood_type" id="blood_type">
          <?php foreach ($bloodType as $bt)
          { ?>
            <option value="<?php echo $bt->param_id?>" <?php if(empty($info_update->blood_type)) { if($bt->param_id==$info->blood_type) { echo "selected"; } } else{ if($bt->param_id==$info_update->blood_type) { echo "selected"; }} ?>><?php echo $bt->cValue?></option>
         <?php }?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Religion</label>
      <div class="col-sm-10">
        <select class="form-control" name="religion" id="religion">
          <?php foreach ($religionList as $bt)
          {?>
             <option value="<?php echo $bt->param_id?>" <?php if(empty($info_update->religion)) { if($bt->param_id==$info->religion) { echo "selected"; } } else{ if($bt->param_id==$info_update->religion) { echo "selected"; }} ?>><?php echo $bt->cValue?></option>
          <?php }?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">Citizenship</label>
      <div class="col-sm-10">
        <select class="form-control" name="citizenship" id="citizenship">
          <?php foreach ($citizenshipList as $bt)
          {?>
              <option value="<?php echo $bt->param_id?>" <?php if(empty($info_update->citizenship)) { if($bt->param_id==$info->citizenship) { echo "selected"; } } else{ if($bt->param_id==$info_update->citizenship) { echo "selected"; }} ?>><?php echo $bt->cValue?></option>       
         <?php }?>
        </select>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
      </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>

<script>
 var startdate = moment();
 startdate = startdate.subtract(15, "year").format('YYYY-MM-DD'); //do not allow applicant under 15

 var enddate = moment();
 enddate = enddate.subtract(60, "year").format('YYYY-MM-DD'); //do not allow applicant greater than 70.

$('#birthday').Zebra_DatePicker({
 direction: [enddate, startdate] 
});
</script>

<div id="address_info_form" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title"><n class="text-danger"><i class="glyphicon glyphicon-map-marker"></i> <b>Address Information</b></n></h4>
      </div>
      <div class="modal-body">
<form name="add_info" method="post" action="update_address_info">
          <div class="col-sm-6">
              <div class="panel panel-warning">
                  <div class="panel-heading">Permanent Address</div>
                  <div class="panel-body">
                    <div class="form-group">
                    <label>Province: </label>
                      <select class="form-control" name="permanent_province" id="permanent_province" onchange="get_cities_filtered('permanent_city',this.value);">
                        <?php foreach ($provinceList as $gend)
                        {?>
                          <option value="<?php echo $gend->id;?>" <?php if(empty($info_update->permanent_province)){ if($info->permanent_province==$gend->id){ echo "selected"; } } else{ if($info_update->permanent_province==$gend->id){ echo "selected"; } }?> ><?php echo $gend->name;?></option>
                        <?php }?>
                      </select>

                    </div>
                    <div class="form-group">
                      <label>City:</label>
                      <?php if(!empty($info->permanent_province)){ $pp = $info->permanent_province; }   else{ $pp="All";  } $cityList = $this->employee_201_model->cityList($pp); ?>
                      <select class="form-control" name="permanent_city" id="permanent_city">
                        <?php 
                        foreach ($cityList as $city)
                        {?>
                          <option value="<?php echo $city->id;?>" <?php if(empty($info_update->permanent_city)){ if($info->permanent_city==$city->id){ echo "selected"; } } else{ if($info_update->permanent_city==$city->id){ echo "selected"; } }?> ><?php echo $city->city_name;?></option>
                        <?php }?> </select>
                    </div>  
                    <div class="form-group">
                      <label>Address: </label>
                      <input type="text" class="form-control" id="permanent_address" name="permanent_address" value="<?php if(empty($info_update->permanent_address)){ echo $info->permanent_address; } else{ echo $info_update->permanent_address; }?>" >
                    </div>
                    <div class="form-group has-feedback" ng-class="{'has-error' : add_info.per_yrsofstay.$error.pattern}">
                      <label>Years of Stay: <small ng-show="add_info.per_yrsofstay.$error.pattern"><i>Not <b><u>valid</u></b> number.</i></small></label>
                      <input type="number" class="form-control" id="permanent_address_years_of_stay" name="permanent_address_years_of_stay" value="<?php if(empty($info_update->permanent_address_years_of_stay)){ echo $info->permanent_address_years_of_stay; } else{ echo $info_update->permanent_address_years_of_stay; }?>">
                    </div>
                  </div>
              </div>
          </div>

          <div class="col-sm-6" id='present_div'>
              <div class="panel panel-info">
                  <div class="panel-heading">Present Address</div>

                  <div class="panel-body">
                    <div class="form-group" >
                      <label>Province: </label>
                      <select class="form-control" name="present_province" id="present_province" onchange="get_cities_filtered('present_city',this.value);">
                     
                        <?php foreach ($provinceList as $gend)
                        {?>
                            <option value="<?php echo $gend->id;?>" <?php if(empty($info_update->present_province)){ if($info->present_province==$gend->id){ echo "selected"; } } else{ if($info_update->present_province==$gend->id){ echo "selected"; } }?> ><?php echo $gend->name;?></option>

                       <?php }?>
                      </select>
                      <select style='display: none;' class="form-control" name="copy_province" id="copy_province" >
                     
                        <?php foreach ($provinceList as $gend)
                        {?>
                            <option value="<?php echo $gend->id;?>" <?php if(empty($info_update->present_province)){ if($info->present_province==$gend->id){ echo "selected"; } } else{ if($info_update->present_province==$gend->id){ echo "selected"; } }?> ><?php echo $gend->name;?></option>

                       <?php }?>
                      </select>

                    </div>
                    <div class="form-group">
                      <label>City:</label>
                      <?php    if(!empty($info->present_province)){ $ppp = $info->present_province; }   else{ $ppp="All";  } $cityList = $this->employee_201_model->cityList($ppp); ?>
                      <select class="form-control" name="present_city" id="present_city">
                        
                       <?php foreach ($cityList as $city)
                        {?>
                          <option value="<?php echo $city->id;?>" <?php if(empty($info_update->present_city)){ if($info->present_city==$city->id){ echo "selected"; } } else{ if($info_update->present_city==$city->id){ echo "selected"; } }?> ><?php echo $city->city_name;?></option>
                        <?php }?>   
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Address: </label>
                      <input type="text" class="form-control" id="present_address" name="present_address" value="<?php if(empty($info_update->present_address)){ echo $info->present_address; } else{ echo $info_update->present_address; }?>">
                    </div>
                    <div class="form-group has-feedback" ng-class="{'has-error' : add_info.pre_yrsofstay.$error.pattern}">
                      <label>Years of Stay: <small ng-show="add_info.pre_yrsofstay.$error.pattern"><i>Not <b><u>valid</u></b> number.</i></small></label>
                      <input type="number" class="form-control" id="present_address_years_of_stay" name="present_address_years_of_stay" value="<?php if(empty($info_update->present_address_years_of_stay)){ echo $info->present_address_years_of_stay; } else{ echo $info_update->present_address_years_of_stay; }?>">
                    </div>
                    <div class="checkbox">
                <label><input type="checkbox" onclick="copy_permanent();" id="copy">Same with permanent address</label>
              </div>  
                  </div>
              </div>
              <input type='hidden' id='p_address' value="<?php if(empty($info_update->present_address)){ echo $info->present_address; } else{ echo $info_update->present_address; }?>">
             
              <input type='hidden' id='p_province'  value="<?php if(empty($info_update->present_province)){ echo $info->present_province; } else{ echo $info_update->present_province; }?>">             
               <input type='hidden' id='p_city' value="<?php if(empty($info_update->present_city)){ echo $info->present_city; } else{ echo $info_update->present_city; }?>">
              <input type='hidden' id='p_yrsoftay' value="<?php if(empty($info_update->present_address_years_of_stay)){ echo $info->present_address_years_of_stay; } else{ echo $info_update->present_address_years_of_stay; }?>">

           
          </div>
           <div class="col-md-6"><button type="submit" class="btn btn-block btn-success"> <i class="fa fa-save"></i> Save Changes</button></div>
            <div class="col-md-6"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Close</button></div>
      </form>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>

  </div>
</div>

<script>
  function copy_permanent()
  {
    var value = document.getElementById('permanent_province').value;

    if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                 { 
                  document.getElementById("present_city").innerHTML=xmlhttp.responseText;

                   if(document.getElementById("copy").checked)
                    { 
                        var prov = document.getElementById('permanent_province').value;
                        var add = document.getElementById('permanent_address').value;
                        var city = document.getElementById('permanent_city').value;
                        var yr = document.getElementById('permanent_address_years_of_stay').value;

                        document.getElementById('present_province').value = prov;
                        document.getElementById('present_address').value = add;
                        document.getElementById('present_city').value = city;
                        document.getElementById('present_address_years_of_stay').value = yr;

                    }
                    else
                    {
                        var prov = document.getElementById('p_province').value;
                        var add = document.getElementById('p_address').value;
                        var city = document.getElementById('p_city').value;
                        var yr = document.getElementById('p_yrsoftay').value;

                        document.getElementById('present_province').value = prov;
                        document.getElementById('present_address').value = add;
                        document.getElementById('present_city').value = city;
                        document.getElementById('present_address_years_of_stay').value = yr;
                    }

                 }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_201/get_cities_filtered/"+value,true);
            xmlhttp.send();

   
  }

  function del_per_image(id)
  {  
      var option = 'employee_info_for_update';
      var idd='picture';
      var result = confirm("Are you sure you want to update the ststus?");
      if(result == true)
      {
        $("#ref_img").load(location.href + " #ref_img");
       {
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                 { 
                  document.getElementById("ref_img").innerHTML=xmlhttp.responseText;

                 }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_201/del_per_image/"+id+"/"+option+"/"+idd,true);
            xmlhttp.send();
        } }
        else{}

  }


function get_cities_filtered(option,value)
{
     if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                 { 
                  document.getElementById(option).innerHTML=xmlhttp.responseText;

                 }
              }
            xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_201/get_cities_filtered/"+value,true);
            xmlhttp.send();
}
</script>