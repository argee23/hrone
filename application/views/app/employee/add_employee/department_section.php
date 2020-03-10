<div class="col-md-6">
<div class="form-group">
  <label for="section">Section</label>
  <select class="form-control" name="section" id="section" onchange="getSubsection(this.value);" required>
    <option selected="selected" disabled="disabled" value="">-Select Sections-</option>
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
  <p style="color:#ff0000;">Section is required</p>
</div>
</div>