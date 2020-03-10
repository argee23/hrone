<div class="form-group">
  <label>Section</label>
  <select class="form-control" name="section" id="section" onchange="getSectionSubsection(this.value)" required>
    <option selected="selected" value="All" >All</option>
    <?php
      foreach($department_section as $section){
      if($_POST['department_section'] == $section->section_id){
          $selected = "selected='selected'";
      }else{
          $selected = "";
      }
      ?>
    <option value="<?php echo $section->section_id;?>" <?php echo $selected;?>><?php echo $section->section_name;?></option>
    <?php }?>
  </select>
</div>