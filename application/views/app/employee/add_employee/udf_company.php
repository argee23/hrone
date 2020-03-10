 <!-- User Define fields -->

<?php foreach($company_udf as $user_define_fields) :
      $label =  $user_define_fields->udf_label;
      $type = $user_define_fields->udf_type;
      $notNull = $user_define_fields->udf_not_null;
      $value = $user_define_fields->udf_accept_value;
      $length = $user_define_fields->udf_max_length;
      $labelval = str_replace(' ', '_', $label);
?>
    <div class="col-md-6">    
    <div class="form-group">
    <label for="<?php echo $label; ?>"><?php echo $label;  ?></label>

        <?php
        if($notNull == 'yes'){
            if($type == 'Datepicker'){?>
              <input type="date" class="form-control" name="<?php echo $labelval ?>" required>
            <?php
              }
            else if($type == 'Selectbox'){ ?>
              <select class="form-control" name="<?php echo $labelval; ?>" id="<?php echo $labelval; ?>" required>
              <option selected="selected" disabled="disabled" value="">Select</option>
              <?php

                foreach($user_define_fields_option as $user_define_fields_opt):
                    $coloptid = $user_define_fields_opt->udf_emp_col_id;
                    $colid = $user_define_fields->emp_udf_col_id;
                    $optid = $user_define_fields_opt->emp_udf_opt_id;
                    $labelopt = $user_define_fields_opt->optionLabel;
                    if($coloptid===$colid ){ 
                    echo "<option value='".$user_define_fields_opt->emp_udf_opt_id."' >".$labelopt."</option>";
                    }
                  endforeach;
                ?>
              </select>
              <?php
            }//end of if not null
            else if($type == 'Textarea'){?>
                <textarea name="<?php echo $labelval; ?>"  class="form-control" id="<?php echo $labelval; ?>" rows="4" cols="50" placeholder="<?php echo $label; ?>"  required></textarea>
               <?php
            }
            else{
              if($value == 'Letters'){?>
                <input type="text"  pattern="[A-Za-z].{0,}" maxlength="<?php echo $length; ?>" title="<?php echo $length; ?> letter(s) only allowed" class="form-control" name="<?php echo $labelval; ?>" id="<?php echo $labelval; ?>" placeholder="<?php echo $label; ?>" required>
              <?php
              }
              else if($value == 'Numbers'){?>
                <input type="number" min="1" max="<?php echo $length; ?>" class="form-control" name="<?php echo $labelval; ?>" id="<?php echo $labelval; ?>" placeholder="<?php echo $label; ?>" required>
              <?php
              }
              else{?>
                <input type="text" maxlength="<?php echo $length; ?>" title="<?php echo $length; ?> character(s) only allowed" class="form-control" name="<?php echo $labelval; ?>" id="<?php echo $labelval; ?>" placeholder="<?php echo $label; ?>" required>
              <?php
              }
            }
            ?>
            <span class="text-danger" ng-show="userForm.company.$invalid">
            <span ng-show="userForm.company.$error.required"><?php echo $label; ?> is required</span>
            </span>   
            <?php
        
        }
        else if($notNull == 'no'){
            if($type == 'Datepicker'){?>
              <input type="date" class="form-control" name="<?php echo $labelval ?>" >
            <?php
              }
            else if($type == 'Selectbox'){ ?>
              <select class="form-control" name="<?php echo $labelval; ?>" id="<?php echo $labelval; ?>">
              <option selected="selected" disabled="disabled" value="">Select</option>
              <?php

                foreach($user_define_fields_option as $user_define_fields_opt):
                    $coloptid = $user_define_fields_opt->udf_emp_col_id;
                    $colid = $user_define_fields->emp_udf_col_id;
                    $optid = $user_define_fields_opt->emp_udf_opt_id;
                    $labelopt = $user_define_fields_opt->optionLabel;
                    if($coloptid===$colid ){ 
                    echo "<option value='".$user_define_fields_opt->emp_udf_opt_id."' >".$labelopt."</option>";
                    }
                  endforeach;
                ?>
              </select>
              <?php
            }//end of if not null
            else if($type == 'Textarea'){?>
                <textarea name="<?php echo $labelval; ?>" class="form-control" id="<?php echo $labelval; ?>" rows="4" cols="50" placeholder="<?php echo $label; ?>"></textarea>
            <?php
            }
            else{
              if($value == 'Letters'){?>
                <input type="text" pattern="[A-Za-z].{0,}" maxlength="<?php echo $length; ?>" title="<?php echo $length; ?> letter(s) only allowed" class="form-control" name="<?php echo $labelval; ?>" id="<?php echo $labelval; ?>" placeholder="<?php echo $label; ?>" >
              <?php
              }
              else if($value == 'Numbers'){?>
                <input type="number" min="1" max="<?php echo $length; ?>" class="form-control" name="<?php echo $labelval; ?>" id="<?php echo $labelval; ?>" placeholder="<?php echo $label; ?>" >
              <?php
              }
              else{?>
                <input type="text" maxlength="<?php echo $length; ?>" title="<?php echo $length; ?> character(s) only allowed" class="form-control" name="<?php echo $labelval; ?>" id="<?php echo $labelval; ?>" placeholder="<?php echo $label; ?>" >
              <?php
              }
            }
        }
        ?>
      
      </div>
      </div>
     
<?php endforeach; ?>

<!-- end of User Define Fields -->