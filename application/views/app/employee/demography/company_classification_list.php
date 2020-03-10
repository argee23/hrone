<div class="col-md-6">
<div class="form-group">
    <label for="classification">Classification</label>
    <select class="form-control select2" name="classification" id="classification" style="width: 100%;" onchange="applyFilterclassification(this.value);">
      <option selected="selected" value="0">-All classification-</option>
      <?php 
        foreach($company_classifications as $classification){
        if($_POST['classification'] == $classification->classification_id){
            $selected = "selected='selected'";
        }else{
            $selected = "";
        }
        ?>
        <option value="<?php echo $classification->classification_id;?>" <?php echo $selected;?>><?php echo $classification->classification;?></option>
        <?php }?>
    </select>
</div>
</div>