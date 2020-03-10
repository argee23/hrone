      <div class="col-md-12">
          <div class="col-md-3">Choose Company <?php //echo $selected_spec_cov;?></div>
          <div class="col-md-6">        
            <select class="form-control" name="chosen_company" id="chosen_company" required onchange="select_employee(this.value)"  >
              <option selected disabled value=""> Select Company</option>
                <?php
                if(!empty($companyList)){
                  foreach($companyList as $c){
                    $wd=$c->wDivision;
                    if($selected_spec_cov=="by_div"){
                      if($wd=="1"){
                          echo '<option  value="'.$c->company_id.'">'.$c->company_name.'</option>';
                      }else{

                      }
                    }else{
                        echo '<option  value="'.$c->company_id.'">'.$c->company_name.'</option>';
                    }
                    
                  }
                }else{
                  echo '<option disabled selected>Notice: you have no access to any company yet.</option>';
                }

                ?>
            </select>
          </div>
      </div> 

<input type="hidden" id="selected_spec_cov" value="<?php echo $selected_spec_cov;?>">
