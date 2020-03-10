<div class="col-md-4">
      <label for="department">Division</label>
</div>
<div class="col-md-8">
        <select class="form-control select2" name="division" id="division" onchange="loadDept(this.value)" required>
        <option value=""  selected="selected" disabled="">Select</option>                          
       
        <?php if($with_division==1){  } else{ echo "<option value='no_div'>Division is not required</option>";}?>
        <?php 
        foreach($divisionList as $div){
        echo "<option value='".$div->division_id."' >".$div->division_name."</option>";
        }
        ?>
        </select>  
</div>
       
            