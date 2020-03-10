<div class="form-group">
    <label>Company</label>
    <select class="form-control select2" name="company" id="company" style="width: 100%;" required>
      <option selected="selected" value="" disabled>-Select-</option>
      <?php 
        foreach($get_company as $company){
        if($_POST['company'] == $company->company_id){
            $selected = "selected='selected'";
        }else{
            $selected = "";
        }
        ?>
        <option value="<?php echo $company->company_id;?>" <?php echo $selected;?>><?php echo $company->company_name;?></option>
        <?php }?>
    </select>
</div>