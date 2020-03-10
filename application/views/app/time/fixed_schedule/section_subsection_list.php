
<div class="col-md-3">
<div class="form-group">
<label >Subsection</label>
<select class="form-control" name="subsection" id="subsection" onchange="applyFiltersubsection(this.value)">
  <option selected="selected" value="All">All</option>
  <?php 
     foreach($section_subsection as $subsection ){
    if($_POST['subsection_employee'] == $subsection->subsection_id){
        $selected = "selected='selected'";
    }else{
        $selected = "";
    }
    ?>
    <option value="<?php echo $subsection->subsection_id;?>" <?php echo $selected;?>><?php echo $subsection->subsection_name; ?></option>
    <?php }?>
</select>
</div>
</div>
