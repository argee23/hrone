<div class="form-group col-md-3">
    <label>City/Municipality</label>
    <select class="form-control select2" name="city" style="width: 100%;" required>
      <option selected="selected" disabled="disabled" value="">-Select-</option>
      <?php 
        foreach($citiesList as $cities){
        if($_POST['cities'] == $cities->id){
            $selected = "selected='selected'";
        }else{
            $selected = "";
        }
        ?>
        <option value="<?php echo $cities->id;?>" <?php echo $selected;?>><?php echo $cities->city_name;?></option>
        <?php }?>
    </select>
</div>