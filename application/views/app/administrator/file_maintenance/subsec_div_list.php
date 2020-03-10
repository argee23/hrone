

                <div class="form-group">
                <label>Select Division</label>
          			<select class="form-control select2" name="division_add" id="division_add" style="width: 100%;" required="required" <?php if(isset($type)){ echo 'onchange="examineDivSubView(this.value)"'; } 
                else { echo 'onchange="examineDivSub(this.value)"'; } ?>  >
          			<option selected="selected" disabled="disabled" value="">- Select Division -</option>
                <!-- <option value="0"> Main </option> -->
<?php
$check_div=$this->file_maintenance_model->div_w_subsection();
                if(!empty($check_div)){

                  foreach($check_div as $wSubsec){
                    $a=$wSubsec->division_id;
                    $d_name=$wSubsec->division_name;

                    if(!empty($divisionList)){
                     foreach($divisionList as $div){
                      $b=$div->division_id;
                      if($a==$b){
                        echo '<option value="'.$b.'">'.$d_name.'</option>';//$a.' VS '.$b.$d_name.'<br>';
                      }
                     }
                    }else{
                      echo '<option disabled> No department setup for this company yet.</option>';
                    }


            }
          }else{
            echo '<option disabled> No department of which section is w/subsetion as a setup.<option>';
          }
?>
          			</select>
                </div>
                <?php if(isset($type)){ echo '<div id="departmentView"></div>'; } 
                else { echo '<div id="department"></div>'; } ?>