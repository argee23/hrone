
   <?php foreach ($display_cutoff as $dis_cutoff) {
           $c_off ='';
        
              $cut_off_id = $dis_cutoff->cut_off_id;
                
               if($cut_off_id == 6){
                  $c_off ="Per Payday";

              }elseif($cut_off_id == '1-2-3-4'){

                    $c_off = "1st,2nd,3rd and 4th Cutoff";
              }elseif($cut_off_id == '1-2-3'){

                    $c_off = "1st,2nd and 3rd Cutoff";
              }elseif($cut_off_id == '1-2'){

                    $c_off = "1st and 2nd Cutoff";
              }elseif($cut_off_id == '1'){

                    $c_off = "1st Cutoff";
              }elseif($cut_off_id == '2'){

                    $c_off = "2nd Cutoff";
              }elseif($cut_off_id == '3'){

                    $c_off = "3rd Cutoff";
              }elseif($cut_off_id == '4'){

                    $c_off = "4th Cutoff";
              }elseif($cut_off_id == '5'){

                    $c_off = "5th Cutoff";
              }elseif($cut_off_id == '1-2-3-5'){

                    $c_off = "1st,2nd,3rd and 5th Cutoff";
              }elseif($cut_off_id == '1-2-4-5'){

                    $c_off = "1st,2nd,4th and 5th Cutoff";
              }elseif($cut_off_id == '1-2-4'){

                    $c_off = "1st,2nd and 4th Cutoff";
              }elseif($cut_off_id == '1-2-5'){

                    $c_off = "1st,2nd,3rd and 5th Cutoff";
              }elseif($cut_off_id == '1-3-4'){

                    $c_off = "1st,3rd and 4th Cutoff";
              }elseif($cut_off_id == '1-3-5'){

                    $c_off = "1st,3rd and 5th Cutoff";
              }elseif($cut_off_id == '1-3'){

                    $c_off = "1st and 3rd Cutoff";
              }elseif($cut_off_id == '1-4'){

                    $c_off = "1st and 4th Cutoff";
              }elseif($cut_off_id == '1-4-5'){

                    $c_off = "1st,4th and 5th Cutoff";
              }elseif($cut_off_id == '1-5'){

                    $c_off = "1st and 5th Cutoff";
              }elseif($cut_off_id == '2-3'){

                    $c_off = "2nd and 3rd Cutoff";
              }elseif($cut_off_id == '2-3-5'){

                    $c_off = "2nd,3rd and 5th Cutoff";
              }elseif($cut_off_id == '2-4-5'){

                    $c_off = "2nd,4th and 5th Cutoff";
              }elseif($cut_off_id == '2-4'){

                    $c_off = "2nd and 4th Cutoff";
              }elseif($cut_off_id == '2-5'){

                    $c_off = "2nd and 5th Cutoff";
              }elseif($cut_off_id == '3-4'){

                    $c_off = "3rd and 4th Cutoff";
              }elseif($cut_off_id == '3-5'){

                    $c_off = "3rd and 5th Cutoff";
              }elseif($cut_off_id == '4-5'){

                    $c_off = "4th and 5th Cutoff";
              }elseif($cut_off_id == '2-3-4'){

                    $c_off = "2nd,3rd and 4th Cutoff";
              }elseif($cut_off_id == '3-4-5'){

                    $c_off = "3rd,4th and 5th Cutoff";
              }elseif($cut_off_id == 'per_pay_day'){
                    $c_off ="Per Payday";
              }

            }
               ?>
        <div class="col-md-6">
              <div class="form-group">
              <label for="company">CutOff by Pay Type</label>

                     <input class="form-control" type="text" name="cut_off" id="cut_off" value="<?php echo $c_off; ?>">

                </div>
              </div>

              



