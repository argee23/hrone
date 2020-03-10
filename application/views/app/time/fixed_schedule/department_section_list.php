<div class="col-md-3">
<div class="form-group">
  <label for="section">Section</label>
  <select class="form-control" name="section" id="section" onchange="getSubsection(this.value); applyFiltersection(this.value)">
    <option selected="selected" value="All">All</option>
    <?php 
      foreach($department_sections as $section){
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
</div>