<div class="form-group">
  <label>Subsection</label>
  <select class="form-control" name="subsection" id="subsection" required>
    <option selected="selected" value="All" >All</option>
    <?php
      foreach($section_subsection as $subsection){
      if($_POST['section_subsection'] == $subsection->subsection_id){
          $selected = "selected='selected'";
      }else{
          $selected = "";
      }
      ?>
    <option value="<?php echo $subsection->subsection_id;?>" <?php echo $selected;?>><?php echo $subsection->subsection_name;?></option>
    <?php }?>
  </select>
</div>