<select class="form-control select2" name="section" id="section" style="width: 100%;" onchange="applyFilter()">
  <option selected="selected" value="0">-All Sections-</option>
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