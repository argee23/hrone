<div class="form-group">
    <label>City/Municipality</label>
    <select class="form-control select2" name="pre_city" id="pre_city" style="width: 100%;" required>
      <option selected="selected" disabled="disabled" value="">-Select-</option>
      <?php 
        foreach($province_cities as $cities){
        if($_POST['cities'] == $cities->id){
            $selected = "selected='selected'";
        }else{
            $selected = "";
        }
        ?>
        <option value="<?php echo $cities->id;?>" <?php echo $selected;?>><?php echo $cities->city_name;?></option>
        <?php }?>
    </select>
    <p style="color:#ff0000;">City/Municipality is required</p>
</div>