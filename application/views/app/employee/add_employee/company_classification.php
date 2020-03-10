<div class="col-md-6">
<div class="form-group">
    <label>Classification</label>
    <select class="form-control select2" name="classification" id="classification" style="width: 100%;" ng-model="classification" required>
      <option selected="selected" value="" disabled>-Select-</option>
      <?php 
        foreach($company_classifications as $classification){
        if($_POST['classification'] == $classification->company_id){
            $selected = "selected='selected'";
        }else{
            $selected = "";
        }
        ?>
        <option value="<?php echo $classification->classification_id;?>" <?php echo $selected;?>><?php echo $classification->classification;?></option>
        <?php }?>
    </select>

    <span class="text-danger" ng-show="userForm.classification.$invalid">
    <span ng-show="userForm.classification.$error.required">classification is required</span>
    </span>
</div>
</div>