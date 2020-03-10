
<div class="form-group">
<label>Section</label>
    <select class="form-control select2" name="section" style="width: 100%;" required>
      <option selected="selected" disabled="disabled" value="">-Select-</option>
      <?php 
        foreach($get_section as $section){
        if($_POST['section'] == $section->section_id){
            $selected = "selected='selected'";
        }else{
            $selected = "";
        }
        ?>
        <option value="<?php echo $section->section_id;?>" <?php echo $selected;?>><?php echo $section->section_name;?></option>
        <?php }?>
    </select>
</div>