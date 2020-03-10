<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>ACCOUNT INFORMATION</strong> (edit)</div>

    <form method="post" action="<?php echo base_url()?>app/employee_201_profile/account_info_modify/<?php echo $this->uri->segment("4");?>" >

    <div class="box-body">

          
          <?php $bank = 'select bank';
              if($account_info_view->bank != null){
                 $bank = $account_info_view->bank_name; 
              }
            ?>

            <div class="row">
            <div class="col-md-6">

            <div class="form-group">
            <label>Bank</label>
            <select class="form-control" name="bank" id="bank">
            <option selected="selected" value="<?php echo $account_info_view->bank; ?>"><?php echo $bank; ?></option>
            <?php 
              foreach($bankList as $bank){
              if($_POST['bank'] == $bank->bank_id){
                  $selected = "selected='selected'";
              }else{
                  $selected = "";
              }
              ?>
              <option value="<?php echo $bank->bank_id;?>" <?php echo $selected;?>><?php echo $bank->bank_name;?></option>
              <?php }?>
              </select>
            </div>

            <div class="form-group">
            <label for="tin">TIN</label>
            <?php $format = $government_fields[1]->field_format; 
              if(!empty($format)){ echo 'format: '.$format; }?>
            <?php if($government_fields[1]->field_option == 0){?>
            <input type="text" class="form-control" pattern = "<?php echo $government_format[1]; ?>" maxlength="<?php echo $government_fields[1]->field_max_length; ?>"  name="tin" value="<?php echo $account_info_view->tin; ?>" >
            <?php } ?>
            <?php if($government_fields[1]->field_option == 1){?>
            <input type="text" class="form-control" pattern = "<?php echo $government_format[1]; ?>" maxlength="<?php echo $government_fields[1]->field_max_length; ?>" name="tin" value="<?php echo $account_info_view->tin; ?>" required>
            <p style="color:#ff0000;">TIN No. is required</p>
            <?php } ?>
            </div>

            <div class="form-group">
            <label for="pagibig">Pagibig No.</label>
            <?php $format = $government_fields[3]->field_format; 
              if(!empty($format)){ echo 'format: '.$format; }?>
            <?php if($government_fields[3]->field_option == 0){?>
            <input type="text" class="form-control" pattern = "<?php echo $government_format[3]; ?>" maxlength="<?php echo $government_fields[3]->field_max_length; ?>" name="pagibig" value="<?php echo $account_info_view->pagibig; ?>" >
            <?php } ?>
            <?php if($government_fields[3]->field_option == 1){?>
            <input type="text" class="form-control" pattern = "<?php echo $government_format[3]; ?>" maxlength="<?php echo $government_fields[3]->field_max_length; ?>" name="pagibig" value="<?php echo $account_info_view->pagibig; ?>" required>
            <p style="color:#ff0000;">Pagibig No. is required</p>
            <?php } ?>
            </div>


            </div>
            <div class="col-md-6">

            <div class="form-group">
              <label>Account No.</label>
              <?php $format = $government_fields[4]->field_format; 
                if(!empty($format)){ echo 'format: '.$format; }?>
              <?php if($government_fields[4]->field_option == 0){?>
              <input type="text" class="form-control" pattern = "<?php echo $government_format[4]; ?>" maxlength="<?php echo $government_fields[4]->field_max_length; ?>" name="account_no" value="<?php echo $account_info_view->account_no; ?>" >
              <?php } ?>
              <?php if($government_fields[4]->field_option == 1){?>
              <input type="text" class="form-control" pattern = "<?php echo $government_format[4]; ?>" maxlength="<?php echo $government_fields[4]->field_max_length; ?>" name="account_no" value="<?php echo $account_info_view->account_no; ?>" required>
              <p style="color:#ff0000;">Account No. is required</p>
              <?php } ?>
            </div>

              <div class="form-group">
              <label for="sss">SSS No.</label>
              <?php $format = $government_fields[0]->field_format; 
                if(!empty($format)){ echo 'format: '.$format; }?>
              <?php if($government_fields[0]->field_option == 0){?>
              <input type="text" class="form-control" pattern = "<?php echo $government_format[0]; ?>" maxlength="<?php echo $government_fields[0]->field_max_length; ?>" name="sss" value="<?php echo $account_info_view->sss; ?>">
              <?php } ?>
              <?php if($government_fields[0]->field_option == 1){?>
              <input type="text" class="form-control" pattern = "<?php echo $government_format[0]; ?>" maxlength="<?php echo $government_fields[0]->field_max_length; ?>" name="sss" value="<?php echo $account_info_view->sss; ?>" required>
              <p style="color:#ff0000;">SSS No. is required</p>
              <?php } ?>
            </div>

            <div class="form-group"> 
            <label for="philhealth">Philhealth</label>
            <?php $format = $government_fields[2]->field_format; 
              if(!empty($format)){ echo 'format: '.$format; }?>
            <?php if($government_fields[2]->field_option == 0){?>
            <input type="text" class="form-control" pattern = "<?php echo $government_format[2]; ?>" maxlength="<?php echo $government_fields[2]->field_max_length; ?>" name="philhealth" value="<?php echo $account_info_view->philhealth; ?>">
            <?php } ?>
            <?php if($government_fields[2]->field_option == 1){?>
            <input type="text" class="form-control" pattern = "<?php echo $government_format[2]; ?>" maxlength="<?php echo $government_fields[2]->field_max_length; ?>" name="philhealth" value="<?php echo $account_info_view->philhealth; ?>" required>
            <p style="color:#ff0000;">Philhealth No. is required</p>
            <?php } ?>
            </div>

            
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


