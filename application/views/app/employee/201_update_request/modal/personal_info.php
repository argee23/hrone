 <div class="modal-content">
     
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Updated Personal Information</center></h4>
      </div>
     
      
      <div class="modal-body">
        
        <?php 
              if(empty($personal->first_name) AND empty($personal->middle_name) 
              AND empty($personal->last_name) AND empty($personal->fullname) 
              AND  empty($personal->nickname) AND empty($personal->birthday) 
              AND empty($personal->age) AND empty($personal->birth_place) 
              AND empty($personal->gender) AND  empty($personal->civil_status) 
             AND empty($personal->blood_type) AND empty($personal->citizenship) 
             AND empty($personal->religion) AND  empty($personal->picture)) {  } else { ?>

            <div class="panel panel-default">
            <div class="panel-heading">
            <strong><a class="text-danger"><i>Personal Information</i></a></strong>
            </div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-12">

                  <?php if(empty($personal->first_name)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">First Name :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->first_name?> <br><n class='text-danger'><?php echo $personal->first_name?></n></div>
      <?php }  if(empty($personal->middle_name)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Middle Name :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->middle_name?> <br><n class='text-danger'><?php echo $personal->middle_name?></n></div>
      <?php } if(empty($personal->last_name)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Last Name :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->last_name?> <br><n class='text-danger'><?php echo $personal->last_name?></n></div>
      <?php } if(empty($personal->nickname)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Nick Name :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->nickname?> <br><n class='text-danger'><?php echo $personal->nickname?></n></div>
      <?php } if(empty($personal->birthday)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Birthday :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->birthday?> <br><n class='text-danger'><?php echo $personal->birthday?></n></div>
      <?php }  if(empty($personal->age)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Age :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->age?> <br><n class='text-danger'><?php echo $personal->age?></n></div>
      <?php }  if(empty($personal->birth_place)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Birth Place :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->birth_place?> <br><n class='text-danger'><?php echo $personal->birth_place?></n></div>
      <?php } if(empty($personal->gender)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Gender :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->gender?> <br><n class='text-danger'><?php echo $personal->gender?></n></div>
      <?php } if(empty($personal->civil_status)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Civil Status:</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->civil_status?> <br><n class='text-danger'><?php echo $personal->civil_status?></n></div>
      <?php }  if(empty($personal->citizenship)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Citizenship :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->my_citizenship?> <br><n class='text-danger'><?php echo $personal->my_citizenship?></n></div>
      <?php } if(empty($personal->blood_type)) {}else{ ?>
         <div class='col-md-6'> <label  for="firstname">Blood Type :</label> </div>
          <div class='col-md-6'> <?php echo $personal_o->blood_type?> <br><n class='text-danger'><?php echo $personal->blood_type?></n></div>
      <?php } if(empty($personal->picture)) {}else{ ?>
         
        <div class='col-md-12'> <label  for="firstname">Picture (<i>Request Update: Red Border</i>) :</label> </div>
          <div class='col-md-12'> 
          <img class="img img-thumbnail bg-gray" style="width: 240px;height:150px;border:1px solid green;" src="<?php echo $this->employee_emp_prof_update_request_model->get_general_url(); ?>employee_picture/<?php echo $personal_o->picture; ?>">
            <n class='text-danger'>
              <img class="img img-thumbnail bg-gray" style="width: 240px;height:150px;border:1px solid red;" src="<?php echo $this->employee_emp_prof_update_request_model->get_general_url(); ?>employee_picture/<?php echo $personal->picture; ?>">
         </n>
         </div>

      <?php } ?>
      </div>
      </span>
      </div>

        <?php } ?>


        <?php if(empty($personal->sss) AND empty($personal->tin) AND empty($personal->pagibig) AND empty($personal->philhealth)) { } else { ?>

          <div class="panel panel-default">
            <div class="panel-heading"><strong><a class="text-danger"><i>Goverment Information</i></a></strong></div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-12">
                  <?php if(empty($personal->bank)) {}else{ ?>
                     <div class='col-md-3'> <label  for="firstname">Bank :</label> </div>
                      <div class='col-md-9'> <?php echo $personal_o->bank?> <br><n class='text-danger'><?php echo $personal->bank?></n></div>

                   <?php } if(empty($personal->sss)) {}else{ ?>
                     <div class='col-md-3'> <label  for="firstname">SSS :</label> </div>
                      <div class='col-md-9'> <?php echo $personal_o->sss?> <br><n class='text-danger'><?php echo $personal->sss?></n></div>
                  <?php }  if(empty($personal->pagibig)) {}else{ ?>
                     <div class='col-md-3'> <label  for="firstname">Pagibig :</label> </div>
                      <div class='col-md-9'> <?php echo $personal_o->pagibig?> <br><n class='text-danger'><?php echo $personal->pagibig?></n></div>
                  <?php }  if(empty($personal->tin)) {}else{ ?>
                     <div class='col-md-3'> <label  for="firstname">TIN :</label> </div>
                      <div class='col-md-9'> <?php echo $personal_o->tin?> <br><n class='text-danger'><?php echo $personal->tin?></n></div>
                  <?php }  if(empty($personal->philhealth)) {}else{ ?>
                     <div class='col-md-3'> <label  for="firstname">Philhealth :</label> </div>
                      <div class='col-md-9'> <?php echo $personal_o->philhealth?> <br><n class='text-danger'><?php echo $personal->philhealth?></n></div>
                  <?php } ?>
                </span>
            </div>
          </div>
        <?php } ?>


         <?php  if(empty($personal->permanent_address) AND empty($personal->permanent_province) AND empty($personal->permanent_city) AND empty($personal->permanent_address_years_of_stay)
                  AND empty($personal->present_address) AND empty($present->permanent_province) AND empty($present->permanent_city) AND empty($present->permanent_address_years_of_stay)) {  } else { ?>

                  <div class="panel panel-default">
                    <div class="panel-heading"><strong><a class="text-danger"><i>Address Information</i></a></strong></div>
                    <div class="panel-body">
                      <span class="dl-horizontal col-sm-12">
                           <?php if(empty($personal->permanent_address)) {}else{ ?>
                            <div class='col-md-6'> <label  for="firstname">Permanent Address :</label> </div>
                            <div class='col-md-6'> <?php echo $personal_o->permanent_address?> <br><n class='text-danger'><?php echo $personal->permanent_address?></n></div>
                           <?php }  if(empty($personal->permanent_province)) {}else{ $res = $this->employee_emp_prof_update_request_model->province_sel($personal->permanent_province,'provinces','name'); ?>
                            <div class='col-md-6'> <label  for="firstname">Permanent Province :</label> </div>
                            <div class='col-md-6'> <?php echo $personal_o->permanent_province?> <br><n class='text-danger'><?php echo $res?></n></div>
                           <?php }  if(empty($personal->permanent_city)) {}else{  $res = $this->employee_emp_prof_update_request_model->province_sel($personal->permanent_city,'cities','city_name');?>
                            <div class='col-md-6'> <label  for="firstname">Permanent City :</label> </div>
                            <div class='col-md-6'> <?php echo $personal_o->permanent_city?> <br><n class='text-danger'><?php echo $res?></n></div>
                           <?php } if(empty($personal->permanent_address_years_of_stay)) {}else{ ?>
                            <div class='col-md-6'> <label  for="firstname">Permanent Address Years of stay :</label> </div>
                            <div class='col-md-6'> <?php echo $personal_o->permanent_address_years_of_stay?> <br><n class='text-danger'><?php echo $personal->permanent_address_years_of_stay?></n></div>
                           <?php } if(empty($personal->present_address)) {}else{ ?>
                            <div class='col-md-6'> <label  for="firstname">Present Address :</label> </div>
                            <div class='col-md-6'> <?php echo $personal_o->present_address?> <br><n class='text-danger'><?php echo $personal->present_address?></n></div>
                           <?php }  if(empty($personal->present_province)) {}else{ $res = $this->employee_emp_prof_update_request_model->province_sel($personal->present_province,'provinces','name'); ?>
                            <div class='col-md-6'> <label  for="firstname">Present Province :</label> </div>
                            <div class='col-md-6'> <?php echo $personal_o->present_province?> <br><n class='text-danger'><?php echo $res?></n></div>
                           <?php }  if(empty($personal->present_city)) {}else{ $res = $this->employee_emp_prof_update_request_model->province_sel($personal->present_city,'cities','city_name'); ?>
                            <div class='col-md-6'> <label  for="firstname">Present City :</label> </div>
                            <div class='col-md-6'> <?php echo $personal_o->present_city?> <br><n class='text-danger'><?php echo $res?></n></div>
                           <?php } if(empty($personal->present_address_years_of_stay)) {}else{ ?>
                            <div class='col-md-6'> <label  for="firstname">Present Address Years of stay :</label> </div>
                            <div class='col-md-6'> <?php echo $personal_o->present_address_years_of_stay?> <br><n class='text-danger'><?php echo $personal->present_address_years_of_stay?></n></div>
                           <?php }?>
                     </span>
                    </div>
                  </div>

        <?php } ?>

        <?php 
              if(empty($personal->mobile_1) AND empty($personal->mobile_2) AND empty($personal->tel_1) AND empty($personal->tel_2)) {  } else { ?>
          <div class="panel panel-default">
            <div class="panel-heading"><strong><a class="text-danger"><i>Contact Information</i></a></strong></div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-12">
                  <?php if(empty($personal->mobile_1)) {}else{ ?>
                      <div class='col-md-6'> <label  for="firstname">Mobile 1 :</label> </div>
                      <div class='col-md-6'> <?php echo $personal_o->mobile_1?> <br><n class='text-danger'><?php echo $personal->mobile_1?></n></div>
                  <?php }   
                    if(empty($personal->mobile_2)) {}else{ ?>
                      <div class='col-md-6'> <label  for="firstname">Mobile 2 :</label> </div>
                      <div class='col-md-6'> <?php echo $personal_o->mobile_2?> <br><n class='text-danger'><?php echo $personal->mobile_2?></n></div>
                  <?php }
                  }   
                    if(empty($personal->mobile_3)) {}else{ ?>
                      <div class='col-md-6'> <label  for="firstname">Mobile 3 :</label> </div>
                      <div class='col-md-6'> <?php echo $personal_o->mobile_3?> <br><n class='text-danger'><?php echo $personal->mobile_3?></n></div>
                  <?php
                  }   
                    if(empty($personal->mobile_4)) {}else{ ?>
                      <div class='col-md-6'> <label  for="firstname">Mobile 4 :</label> </div>
                      <div class='col-md-6'> <?php echo $personal_o->mobile_4?> <br><n class='text-danger'><?php echo $personal->mobile_4?></n></div>
                  <?php
                  if(empty($personal->tel_1)) {}else{ ?>
                      <div class='col-md-6'> <label  for="firstname">Tel 1 :</label> </div>
                      <div class='col-md-6'> <?php echo $personal_o->tel_1?> <br><n class='text-danger'><?php echo $personal->tel_1?></n></div>
                  <?php }   
                    if(empty($personal->tel_2)) {}else{ ?>
                      <div class='col-md-6'> <label  for="firstname">Tel 2 :</label> </div>
                      <div class='col-md-6'> <?php echo $personal_o->tel_2?> <br><n class='text-danger'><?php echo $personal->tel_2?></n></div>
                  <?php } ?>
             </span>
            </div>
          </div>
        <?php } ?>

        <?php if(empty($personal->facebook) AND empty($personal->twitter) AND empty($personal->instagram)) {  } else { ?>

          <div class="panel panel-default">
            <div class="panel-heading"><strong><a class="text-danger"><i>Personal Information</i></a></strong></div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-12">
                       <div class='col-md-6'> <label  for="firstname">Facebook :</label> </div>
                        <div class='col-md-6'> <?php echo $personal_o->facebook?> <br><n class='text-danger'><?php echo $personal->facebook?></n></div>
                    <?php    
                      if(empty($personal->twitter)) {}else{ ?>
                        <div class='col-md-6'> <label  for="firstname">Twitter:</label> </div>
                        <div class='col-md-6'> <?php echo $personal_o->twitter?> <br><n class='text-danger'><?php echo $personal->twitter?></n></div>
                    <?php }
                    if(empty($personal->instagram)) {}else{ ?>
                        <div class='col-md-6'> <label  for="firstname">Twitter :</label> </div>
                        <div class='col-md-6'> <?php echo $personal_o->instagram?> <br><n class='text-danger'><?php echo $personal->instagram?></n></div>
                    <?php }  ?>
                    </div>
             </span>
            </div>
          </div>
        <?php } ?>

        <?php if(empty($personal->residence_map)){} else{?>
          <div class="panel panel-default">
            <div class="panel-heading"><strong><a class="text-danger"><i>Residence Information</i></a></strong></div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-12">
                   <div class='col-md-4'> <label  for="firstname">Residence Map :</label> </div>
                      <div class='col-md-12'> 
                      <img class="img img-thumbnail bg-gray" style="width: 100%;height:100%;border:1px solid green;" src="<?php echo base_url(); ?>public/employee_files/residence/<?php echo $personal_o->residence_map; ?>"">
                      <n class='text-danger'>
                      <img class="img img-thumbnail bg-gray" style="width: 100%;height:100%;border:1px solid red;margin-top: 10px;" src="<?php echo base_url(); ?>public/employee_files/residence/<?php echo $personal->residence_map; ?>">
                    </n>
                  </div>
             </span>
            </div>
          </div>

        <?php } ?>

        <?php  if(empty($personal->electronic_signature)){} else{?>
          <div class="panel panel-default">
            <div class="panel-heading"><strong><a class="text-danger"><i>Electronic Signature</i></a></strong></div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-12">
                     <div class='col-md-4'> <label  for="firstname">Electronic Signature :</label> </div>
                        <div class='col-md-12'> 
                      <?php if(empty($personal_o->electronic_signature)){?>

                      <img class="img img-thumbnail bg-gray" style="width: 200px;height:100%;border:1px solid green;" src="<?php echo base_url(); ?>public/employee_files/electronic_signature/no_image.png">

                      <?php } else{ ?>

                      <img class="img img-thumbnail bg-gray" style="width: 100%;height:100%;border:1px solid green;" src="<?php echo base_url(); ?>public/employee_files/electronic_signature/<?php echo $personal_o->electronic_signature; ?>">

                      <?php } ?>

                      

                        <n class='text-danger'>
                          <img class="img img-thumbnail bg-gray" style="width: 100%;height: 100%;border:1px solid red;margin-top: 10px;" src="<?php echo base_url(); ?>public/employee_files/electronic_signature/<?php echo $personal->electronic_signature; ?>">
                       </n>
                      </div>
             </span>
            </div>
          </div>
        <?php } ?>

          <?php   if(empty($personal->whole_body_pic)){} else{?>
          <div class="panel panel-default">
            <div class="panel-heading"><strong><a class="text-danger"><i> Whole Body Picture</i></a></strong></div>
            <div class="panel-body">
              <span class="dl-horizontal col-sm-12">
                     <div class='col-md-4'> <label  for="firstname">Whole Body Picture :</label> </div>
                          <div class='col-md-12'> 
                        <img class="img img-thumbnail bg-gray" style="width: 100%;height:100%;border:1px solid green;" src="<?php echo base_url(); ?>public/employee_files/whole_body_picture/<?php echo $personal_o->whole_body_pic; ?>"">
                          <n class='text-danger'>
                            <img class="img img-thumbnail bg-gray" style="width: 100%;height:100%;border:1px solid red;margin-top: 10px;" src="<?php echo base_url(); ?>public/employee_files/whole_body_picture/<?php echo $personal->whole_body_pic; ?>">
                         </n></div>
                    </div>
             </span>
            </div>
          </div>
          <?php } ?>

      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>

</div>
  
<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>
