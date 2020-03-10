
         <input type="hidden" name="type" value="<?php echo $type;?>">
        <?php  if($type=='qualifying'){?>
           <span class="dl-horizontal col-sm-12">
                 <?php if(count($qq)==0){ echo "<h3>No Qualifying Question/s found.</h3>";} else{ $i=1; foreach($qq as $q){?>
                   <br>
                  <div class="col-md-12">
                      <h5> <n class="text-danger"><?php echo $i.")";?> </n><?php echo $q->question;?> </h5>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12"><n class="text-danger"><i>Answer : <?php if($q->correct_ans==1){ echo "yes"; } else{ echo "no"; }?></i></n></div>
                  </div>
                   <br>
                  <?php $i++; } } ?>
              </span>
        <?php } else if($type=='hypothetical'){?>

             <span class="dl-horizontal col-sm-12">
                 <?php if(count($qq)==0){ echo "<h3>No Hypothetical Question/s found.</h3>";} else{  $i=1; foreach($qq as $h){?>
                   <br>
                  <div class="col-md-12">
                      <h5> <n class="text-danger"><?php echo $i.")";?> </n><?php echo $h->question;?> </h5>
                  </div>
                  <div class="col-md-12">
                  <input type="text" class="form-control" class="hypothetical" name="hypoQues_id[]" id="<?php echo $i;?>" value="<?php echo $h->answer;?>">
                  <input type="hidden" name="idd<?php echo $i;?>" value="<?php echo $h->idd;?>">
                  </div>
                   <br>
                  <?php $i++; } echo "<input type='hidden' id='hypotheticalcount' value='".$i."' "; } ?>
              </span>

          <?php } else{ ?>



            <span class="dl-horizontal col-sm-12">
                 <?php if(count($qq)==0){ echo "<h3>No Multiple Choice Question/s found.</h3>";} 
                 else{  $i=1; foreach($qq as $h){
                  $choices = $this->application_forms_model->get_questions_choices($h->idd);
                
                  ?>
                   <br>
                  <div class="col-md-12">
                      <input type="hidden" name="hypoQues[]" value="<?php echo $h->idd;?>" >
                      <h5> <n class="text-danger"><?php echo $i.")";?> </n><?php echo $h->question;?> </h5>
                  </div>
                  <div class="col-md-12">
                  <input type="checkbox"  name="hypoQues<?php echo $h->idd;?>[]" value="no_data" style='display: none;'>
                  <?php foreach($choices as $c){
                   $check = $this->application_forms_model->check_if_exist($c->mc_id,$h->idd,$job_id,$applicant_id);
                    ?>
                  <n style='margin-left: 50px;'><input type="checkbox"  name="hypoQues<?php echo $h->idd;?>[]" value="<?php echo $c->mc_id;?>" <?php if($check==1){ echo "checked"; }?>> <?php echo $c->mc_choice;?><br></n>
                  <?php }  ?>
                  </div>
                   <br>
                  <?php $i++; } } ?>
              </span>



          <?php } ?>